<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;
use Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Str;

class ProductController extends Controller
{
    public function shopAccessories(Request $request)
    {
        try {
            $category_id = $request->query('category_id');
            $q = trim($request->query('q'));

            $query = Product::with(['category', 'variants'])->where('is_rental', false);

            if (!empty($q)) {
                $query->where('name', 'LIKE', '%' . $q . '%');
            }

            if ($category_id) {
                $query->where('category_id', $category_id);
            }

            $products = $query->paginate(8);

            $categories = Category::whereHas('products', function ($query) {
                $query->where('is_rental', false);
            })->get();

            return view('user.product.shopAccessories', compact('products', 'categories'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load accessories: ' . $e->getMessage()]);
        }
    }

    public function rental(Request $request)
    {
        try {
            $category_id = $request->query('category_id');

            $query = Product::with(['category', 'variants'])->where('is_rental', true);

            if ($category_id) {
                $query->where('category_id', $category_id);
            }

            $products = $query->paginate(8);

            $categories = Category::whereHas('products', function ($query) {
                $query->where('is_rental', true);
            })->get();

            return view('user.product.rental', compact('products', 'categories'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load rental products: ' . $e->getMessage()]);
        }
    }

    public function adminIndex(Request $request)
    {
        $search = $request->input('search');
        $products = Product::with('category')->when($search, function ($query, $search) {
            return $query->where('id', $search);
        })->paginate(10);
        return view("admin.product.index", compact("products"));
    }

    public function create()
    {
        try {
            $categories = Category::all();
            return view("admin.product.create", compact('categories'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load categories: ' . $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:255",
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'is_rental' => 'required|boolean',
            'has_variants' => 'nullable|boolean',
            'variants_json' => 'nullable|string',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'category_id' => 'nullable|exists:categories,id',
        ]);
        $validated = $validator->validate();
        $hasVariants = (int)($request->input('has_variants', 0)) === 1;

        if (!$hasVariants) {
            Validator::make($request->all(), [
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
            ])->validate();
        } else {
            Validator::make($request->all(), [
                'variants_json' => 'required|string',
            ])->validate();
        }

        $variants = [];

        if ($hasVariants) {
            $variants = json_decode($request->input('variants_json'), true);

            if (!is_array($variants) || count($variants) === 0) {
                return redirect()->back()
                    ->withErrors(['error' => 'Variants data is invalid or empty.'])
                    ->withInput();
            }

            foreach ($variants as $i => $v) {
                $color = trim((string)($v['color'] ?? ''));
                $size  = trim((string)($v['size'] ?? ''));
                $stock = $v['stock'] ?? null;
                $price = $v['price'] ?? null;

                if ($color === '' || $size === '') {
                    return redirect()->back()
                        ->withErrors(['error' => "Variant #" . ($i + 1) . " must have color and size."])
                        ->withInput();
                }

                if (!is_numeric($stock) || (int)$stock < 0) {
                    return redirect()->back()
                        ->withErrors(['error' => "Variant #" . ($i + 1) . " stock must be a non-negative number."])
                        ->withInput();
                }

                if ($price !== null && $price !== '' && (!is_numeric($price) || (float)$price < 0)) {
                    return redirect()->back()
                        ->withErrors(['error' => "Variant #" . ($i + 1) . " price must be >= 0."])
                        ->withInput();
                }
            }

            $seen = [];
            foreach ($variants as $v) {
                $key = mb_strtolower(trim($v['color'])) . '|' . mb_strtolower(trim($v['size']));
                if (isset($seen[$key])) {
                    return redirect()->back()
                        ->withErrors(['error' => "Duplicate variant: {$v['color']} - {$v['size']}"])
                        ->withInput();
                }
                $seen[$key] = true;
            }
        }

        $validator_images = Validator::make($request->all(), [
            'gallery_images' => 'nullable|array|max:5',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
        $validated_images = $validator_images->validate();

        try {
            DB::transaction(function () use ($validated, $validated_images, $hasVariants, $variants) {
                $slug = Str::slug($validated['name']);

                $originalSlug = $slug;
                $counter = 1;
                while (Product::query()->where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $counter++;
                }
                $validated['slug'] = $slug;
                try {
                    $mainImageResult = Cloudinary::uploadApi()->upload($validated['main_image']->getRealPath(), [
                        'folder' => 'products'
                    ]);
                } catch (\Exception $uploadException) {
                    throw new \Exception('Cloudinary upload failed: ' . $uploadException->getMessage());
                }

                if (!$mainImageResult || !isset($mainImageResult['secure_url']) || !isset($mainImageResult['public_id'])) {
                    throw new \Exception('Failed to upload main image to Cloudinary. Result: ' . json_encode($mainImageResult));
                }

                $validated['image'] = $mainImageResult['secure_url'];
                $validated['public_id'] = $mainImageResult['public_id'];

                if ($hasVariants) {
                    $totalStock = 0;
                    $minPrice = null;

                    foreach ($variants as $v) {
                        $stock = (int) ($v['stock'] ?? 0);
                        $totalStock += $stock;

                        $p = $v['price'] ?? null;

                        if ($p !== null && $p !== '') {
                            $p = (float) $p;
                            if ($minPrice === null || $p < $minPrice) {
                                $minPrice = $p;
                            }
                        }
                    }

                    $validated['stock'] = $totalStock;

                    $validated['price'] = $minPrice ?? 0;
                }

                $product = Product::create($validated);

                if ($hasVariants) {
                    $totalStock = 0;

                    foreach ($variants as $v) {
                        $stock = (int) $v['stock'];
                        $totalStock += $stock;

                        $product->variants()->create([
                            'color' => trim($v['color']),
                            'size'  => trim($v['size']),
                            'price' => ($v['price'] === null || $v['price'] === '') ? null : (float) $v['price'],
                            'stock' => $stock,
                            'image' => null,
                        ]);
                    }

                    $product->update(['stock' => $totalStock]);
                }

                if (!empty($validated_images['gallery_images']) && is_array($validated_images['gallery_images'])) {
                    foreach ($validated_images['gallery_images'] as $galleryImage) {
                        $galleryResult = Cloudinary::uploadApi()->upload($galleryImage->getRealPath(), [
                            'folder' => 'products/gallery'
                        ]);

                        if (!$galleryResult || !isset($galleryResult['secure_url']) || !isset($galleryResult['public_id'])) {
                            throw new \Exception('Failed to upload gallery image to Cloudinary. Result: ' . json_encode($galleryResult));
                        }

                        $product->images()->create([
                            'image_url' => $galleryResult['secure_url'],
                            'public_id' => $galleryResult['public_id'],
                        ]);
                    }
                }
            });

            return redirect()->route('admin.product.index')
                ->with('success', 'Added new product successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while adding the product: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show(string $id)
    {
        $product = Product::with(['images', 'variants'])->findOrFail($id);
        if (!$product) {
            return redirect()->route('product.index')
                ->withErrors(['error' => 'Product not found.']);
        }
        return view('user.product.show', compact('product'));
    }

    public function edit(string $id)
    {
        try {
            $match = Product::with(["images", "variants"])->find($id);
            if (!$match) {
                return redirect()->route('admin.product.index')
                    ->withErrors(['error' => 'Product not found.']);
            }

            $categories = Category::all();
            return view('admin.product.edit', compact('match', 'categories'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load product: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, string $id)
    {
        $match = Product::with('images')->find($id);
        if (!$match) {
            return redirect()->route('admin.product.index')
                ->withErrors(['error' => 'Product not found.']);
        }

        $hasVariants = (int) $request->input('has_variants', 0) === 1;

        $rules = [
            "name" => "required|string|max:255",
            'slug' => 'required|string|max:255|unique:products,slug,' . $match->id,
            'description' => 'nullable|string',
            'is_rental' => 'required|boolean',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'category_id' => 'nullable|exists:categories,id',
            'deleted_image_ids' => 'nullable|string',
            'has_variants' => 'nullable|boolean',
        ];

        if ($hasVariants) {
            $rules['price'] = 'nullable|numeric|min:0';
            $rules['stock'] = 'nullable|integer|min:0';
            $rules['variants_json'] = 'required|string';
        } else {
            $rules['price'] = 'required|numeric|min:0';
            $rules['stock'] = 'required|integer|min:0';
            $rules['variants_json'] = 'nullable|string';
        }

        $validated = Validator::make($request->all(), $rules)->validate();
        $hasVariants = (int)($request->input('has_variants', 0)) === 1;

        if (!$hasVariants) {
            Validator::make($request->all(), [
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
            ])->validate();
        } else {
            Validator::make($request->all(), [
                'variants_json' => 'required|string',
            ])->validate();
        }

        $validator_images = Validator::make($request->all(), [
            'gallery_images' => 'nullable|array|max:5',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
        $validated_images = $validator_images->validate();

        try {
            DB::transaction(function () use ($match, $validated, $validated_images, $request, $hasVariants) {
                $variants = [];
                if ($hasVariants) {
                    $variants = json_decode($request->input('variants_json'), true) ?? [];
                    if (!is_array($variants) || count($variants) === 0) {
                        throw new \Exception('Variants data is invalid or empty.');
                    }
                }
                if ($hasVariants) {
                    $match->variants()->delete();

                    $totalStock = 0;
                    $minPrice = null;

                    foreach ($variants as $i => $v) {
                        $color = trim((string)($v['color'] ?? ''));
                        $size  = trim((string)($v['size'] ?? ''));
                        $stock = $v['stock'] ?? null;
                        $price = $v['price'] ?? null;

                        if ($color === '' || $size === '') throw new \Exception("Variant #" . ($i + 1) . " must have color and size.");
                        if (!is_numeric($stock) || (int)$stock < 0) throw new \Exception("Variant #" . ($i + 1) . " stock must be >= 0.");
                        if ($price !== null && $price !== '' && (!is_numeric($price) || (float)$price < 0)) {
                            throw new \Exception("Variant #" . ($i + 1) . " price must be >= 0.");
                        }

                        $stockInt = (int)$stock;
                        $totalStock += $stockInt;

                        $priceFloat = ($price === null || $price === '') ? null : (float)$priceFloat = (float)$price;
                        if ($priceFloat !== null) $minPrice = $minPrice === null ? $priceFloat : min($minPrice, $priceFloat);

                        $match->variants()->create([
                            'color' => $color,
                            'size'  => $size,
                            'price' => $priceFloat,
                            'stock' => $stockInt,
                            'image' => null,
                        ]);
                    }

                    $validated['stock'] = $totalStock;

                    // nếu price trống thì set theo min variant price (hoặc 0)
                    if (!isset($validated['price']) || $validated['price'] === null || $validated['price'] === '') {
                        $validated['price'] = $minPrice ?? 0;
                    }
                } else {
                    $match->variants()->delete();
                }
                if ($request->hasFile('main_image')) {
                    $mainImageResult = Cloudinary::uploadApi()->upload($request->file('main_image')->getRealPath(), [
                        'folder' => 'products'
                    ]);

                    if (!$mainImageResult || !isset($mainImageResult['secure_url'])) {
                        throw new \Exception('Upload result invalid: ' . json_encode($mainImageResult));
                    }

                    if ($match->public_id) {
                        Cloudinary::uploadApi()->destroy($match->public_id);
                    }

                    $validated['image'] = $mainImageResult['secure_url'];
                    $validated['public_id'] = $mainImageResult['public_id'];
                }

                if ($request->has('deleted_image_ids') && $request->deleted_image_ids !== '[]') {
                    $deletedIds = json_decode($request->deleted_image_ids, true);
                    if (is_array($deletedIds)) {
                        foreach ($deletedIds as $imageId) {
                            $image = $match->images()->find($imageId);
                            if ($image) {
                                Cloudinary::uploadApi()->destroy($image->public_id);
                                $image->delete();
                            }
                        }
                    }
                }

                if (!empty($validated_images['gallery_images']) && is_array($validated_images['gallery_images'])) {
                    foreach ($request->file('gallery_images') as $galleryImage) {
                        $galleryResult = Cloudinary::uploadApi()->upload($galleryImage->getRealPath(), [
                            'folder' => 'products/gallery'
                        ]);

                        if (!$galleryResult || !isset($galleryResult['secure_url'])) {
                            throw new \Exception('Failed to upload gallery image. Result: ' . json_encode($galleryResult));
                        }

                        $match->images()->create([
                            'image_url' => $galleryResult['secure_url'],
                            'public_id' => $galleryResult['public_id'],
                        ]);
                    }
                }

                $hasVariants = (int)$request->input('has_variants', 0) === 1;

                if ($hasVariants) {
                    $variants = json_decode($request->input('variants_json'), true) ?? [];
                    if (!is_array($variants) || count($variants) === 0) {
                        throw new \Exception('Variants data is invalid or empty.');
                    }
                    $match->variants()->delete();

                    $totalStock = 0;
                    foreach ($variants as $v) {
                        $stock = (int)($v['stock'] ?? 0);
                        $totalStock += $stock;

                        $match->variants()->create([
                            'color' => trim((string)$v['color']),
                            'size'  => trim((string)$v['size']),
                            'price' => ($v['price'] === null || $v['price'] === '') ? null : (float)$v['price'],
                            'stock' => $stock,
                            'image' => null,
                        ]);
                    }

                    $validated['stock'] = $totalStock;

                    if (!isset($validated['price']) || $validated['price'] === null) {
                        $validated['price'] = 0;
                    }
                } else {
                    $match->variants()->delete();
                }

                $match->update($validated);
            });

            return redirect()->route('admin.product.index')
                ->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while updating the product: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(string $id)
    {
        $match = Product::with(["images", "variants"])->find($id);
        if (!$match) {
            return redirect()->route('admin.product.index')
                ->withErrors(['error' => 'Product not found.']);
        }

        try {
            DB::transaction(function () use ($match) {
                Cloudinary::uploadApi()->destroy($match->public_id);
                foreach ($match->images as $image) {
                    Cloudinary::uploadApi()->destroy($image->public_id);
                }
                $match->delete();
            });

            return redirect()->route('admin.product.index')
                ->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while deleting the product: ' . $e->getMessage()]);
        }
    }
}
