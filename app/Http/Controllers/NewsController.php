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
            $news = DB::table('news')->when($search, function ($query, $search) {
                return $query->where('id', $search);
            })->paginate(10);
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
            DB::transaction(function () use ($validated, $request) {
                if ($request->hasFile('image')) {
                    $imageResult = Cloudinary::uploadApi()->upload($request->file('image')->getRealPath(), [
                        'folder' => 'news'
                    ]);
                    $validated['image'] = $imageResult['secure_url'];
                    $validated['public_id'] = $imageResult['public_id'];
                }
                News::create($validated);
            });
            return redirect()->route('admin.news.index')->with('success', 'News article created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load create news form: ' . $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $news = News::findOrFail($id);

            $related = News::where('id', '!=', $news->id)
                ->latest()
                ->take(2)
                ->get();

            return view('user.news.show', compact('news', 'related'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load news article: ' . $e->getMessage()]);
        }
    }

    public function edit(string $id)
    {
        try {
            $news = DB::table('news')->where('id', $id)->firstOrFail();
            if (!$news) {
                return redirect()->route('admin.news.index')->withErrors(['error' => 'News article not found.']);
            }
            return view('admin.news.edit', compact('news'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load edit news form: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $match = News::findOrFail($id);
            if (!$match) {
                return redirect()->route('admin.news.index')->withErrors(['error' => 'News article not found.']);
            }

            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'slug' => 'required|string|max:255|unique:news,slug,' . $match->id,
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            ]);
            $validated = $validator->validate();

            DB::transaction(function () use ($match, $validated, $request) {
                if ($request->hasFile('image')) {
                    if ($match->public_id) {
                        Cloudinary::uploadApi()->destroy($match->public_id);
                    }
                    $imageResult = Cloudinary::uploadApi()->upload($request->file('image')->getRealPath(), [
                        'folder' => 'news'
                    ]);
                    $validated['image'] = $imageResult['secure_url'];
                    $validated['public_id'] = $imageResult['public_id'];
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
            $match = News::findOrFail($id);
            if (!$match) {
                return redirect()->route('admin.news.index')->withErrors(['error' => 'News article not found.']);
            }

            DB::transaction(function () use ($match) {
                if ($match->public_id) {
                    Cloudinary::uploadApi()->destroy($match->public_id);
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
