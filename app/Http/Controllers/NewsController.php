<?php

namespace App\Http\Controllers;

use App\Models\News;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use DB;
use Illuminate\Http\Request;
use Validator;

class NewsController extends Controller
{
    public function index()
    {
        try {
            $news = DB::table('news')->orderByDesc('created_at')->paginate(10);
            return view("user.news.index", compact("news"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load news articles: ' . $e->getMessage()]);
        }
    }

    public function adminIndex(Request $request)
    {
        try {
            $search = $request->input('search');
            $news = DB::table('news')
                ->when($search, fn($q, $search) => $q->where('id', $search))
                ->orderByDesc('created_at')
                ->paginate(10);
            return view("admin.news.index", compact("news"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load news articles: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        try {
            return view("admin.news.create");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load create news form: ' . $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'slug' => 'required|string|max:255|unique:news,slug',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            ]);
            $validated = $validator->validate();
            $validator_images = Validator::make($request->all(), [
                'gallery_images' => 'nullable|array|max:4',
                'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            ]);
            $validated_images = $validator_images->validate();
            DB::transaction(function () use ($validated, $validated_images, $request) {
                if ($request->hasFile('image')) {
                    $imageResult = Cloudinary::uploadApi()->upload($request->file('image')->getRealPath(), [
                        'folder' => 'news'
                    ]);

                    if (!$imageResult || !isset($imageResult['secure_url']) || !isset($imageResult['public_id'])) {
                        throw new \Exception('Failed to upload main news image: ' . json_encode($imageResult));
                    }
                    $validated['image'] = $imageResult['secure_url'];
                    $validated['public_id'] = $imageResult['public_id'];
                }
                $news = News::create($validated);

                if (!empty($validated_images['gallery_images']) && is_array($validated_images['gallery_images'])) {
                    foreach ($validated_images['gallery_images'] as $galleryImage) {
                        $galleryResult = Cloudinary::uploadApi()->upload(
                            $galleryImage->getRealPath(),
                            ['folder' => 'news/gallery']
                        );

                        if (!$galleryResult || !isset($galleryResult['secure_url']) || !isset($galleryResult['public_id'])) {
                            throw new \Exception('Failed to upload news gallery image: ' . json_encode($galleryResult));
                        }

                        $news->images()->create([
                            'image_url' => $galleryResult['secure_url'],
                            'public_id' => $galleryResult['public_id'],
                        ]);
                    }
                }
            });
            return redirect()->route('admin.news.index')->with('success', 'News article created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to create news article: ' . $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $news = News::with('images')->findOrFail($id);
            
            $galleryUrls = $news->images
                ->sortBy('id')
                ->take(4)
                ->pluck('image_url')
                ->values()
                ->all();

            $related = News::where('id', '!=', $news->id)
                ->latest()
                ->take(2)
                ->get();

            return view('user.news.show', compact('news', 'related', 'galleryUrls'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load news article: ' . $e->getMessage()]);
        }
    }

    public function edit(string $id)
    {
        try {
            $news = News::with('images')->findOrFail($id);

            $news->gallery_images = $news->images->map(function ($img) {
                return [
                    'url' => $img->image_url,
                    'id'  => $img->id,
                ];
            })->values();

            return view('admin.news.edit', compact('news'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load edit news form: ' . $e->getMessage()]);
        }
    }


    public function update(Request $request, string $id)
    {
        try {
            $match = News::with('images')->findOrFail($id);

            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'slug' => 'required|string|max:255|unique:news,slug,' . $match->id,
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            ]);
            $validated = $validator->validate();

            $validator_images = Validator::make($request->all(), [
                'gallery_images' => 'nullable|array|max:4',
                'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
                'deleted_image_ids' => 'nullable|json',
            ]);
            $validated_images = $validator_images->validate();

            DB::transaction(function () use ($match, $validated, $validated_images, $request) {
                if ($request->hasFile('image')) {
                    if ($match->public_id) {
                        Cloudinary::uploadApi()->destroy($match->public_id);
                    }
                    $imageResult = Cloudinary::uploadApi()->upload($request->file('image')->getRealPath(), [
                        'folder' => 'news'
                    ]);
                    if (!$imageResult || !isset($imageResult['secure_url']) || !isset($imageResult['public_id'])) {
                        throw new \Exception('Failed to upload main news image: ' . json_encode($imageResult));
                    }

                    $validated['image'] = $imageResult['secure_url'];
                    $validated['public_id'] = $imageResult['public_id'];
                }
                if ($request->has('deleted_image_ids') && $request->deleted_image_ids !== '[]') {
                    $deletedIds = json_decode($request->deleted_image_ids, true);
                    if (is_array($deletedIds)) {
                        foreach ($deletedIds as $imageId) {
                            $img = $match->images()->find($imageId);
                            if ($img) {
                                if ($img->public_id) {
                                    Cloudinary::uploadApi()->destroy($img->public_id);
                                }
                                $img->delete();
                            }
                        }
                    }
                }
                if (!empty($validated_images['gallery_images']) && is_array($validated_images['gallery_images'])) {
                    foreach ($request->file('gallery_images') as $galleryImage) {
                        $galleryResult = Cloudinary::uploadApi()->upload(
                            $galleryImage->getRealPath(),
                            ['folder' => 'news/gallery']
                        );

                        if (!$galleryResult || !isset($galleryResult['secure_url']) || !isset($galleryResult['public_id'])) {
                            throw new \Exception('Failed to upload news gallery image: ' . json_encode($galleryResult));
                        }

                        $match->images()->create([
                            'image_url' => $galleryResult['secure_url'],
                            'public_id' => $galleryResult['public_id'],
                        ]);
                    }
                }

                $match->update($validated);
            });

            return redirect()->route('admin.news.index')->with('success', 'News article updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to update news article: ' . $e->getMessage()]);
        }
    }

    public function destroy(string $id)
    {
        try {
            $match = News::with('images')->findOrFail($id);
            if (!$match) {
                return redirect()->route('admin.news.index')->withErrors(['error' => 'News article not found.']);
            }

            DB::transaction(function () use ($match) {
                if ($match->public_id) {
                    Cloudinary::uploadApi()->destroy($match->public_id);
                }
                foreach ($match->images as $img) {
                    if ($img->public_id) Cloudinary::uploadApi()->destroy($img->public_id);
                }
                $match->delete();
            });

            return redirect()->route('admin.news.index')->with('success', 'News article deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to delete news article: ' . $e->getMessage()]);
        }
    }
}
