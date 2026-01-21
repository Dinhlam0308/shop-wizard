<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        try {
            $categories = Menu::query()
                ->select('category')
                ->whereNotNull('category')
                ->distinct()
                ->pluck('category');

            $specials = Menu::query()
                ->where('is_special', 1)
                ->where('available', 1)
                ->latest()
                ->take(8)
                ->get();

            $featured = Menu::query()
                ->where('is_featured', 1)
                ->where('available', 1)
                ->latest()
                ->take(16)
                ->get();

            // Nếu bạn vẫn muốn giữ filter category cho các slider:
            // ->when($request->filled('category'), fn($q) => $q->where('category', $request->category))

            return view('user.menu.index', compact('categories', 'specials', 'featured'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load menus: ' . $e->getMessage()]);
        }
    }

    public function indexAdmin(Request $request)
    {
        try {
            $search = $request->input('search');
            $menu = Menu::when($search, function ($query, $search) {
                return $query->where('id', $search);
            })->paginate(10);
            return view('admin.menu.index', compact('menu'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load menus: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        try {
            return view('admin.menu.create');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load create menu form: ' . $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'category' => 'nullable|string|max:255',
                'is_featured' => 'nullable|boolean',
                'is_special' => 'nullable|boolean',
                'available' => 'nullable|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            ]);
            $validated = $validator->validate();

            $imageResult = Cloudinary::uploadApi()->upload($request->file('image')->getRealPath(), [
                'folder' => 'menus'
            ]);
            $validated['image'] = $imageResult['secure_url'];
            $validated['public_id'] = $imageResult['public_id'];

            Menu::create($validated);
            DB::commit();
            return redirect()->route('admin.menu.index')
                ->with('success', 'Menu item created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create menu item: ' . $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $menu = Menu::findOrFail($id);
            return view('menu.show', compact('menu'));
        } catch (\Exception $e) {
            return redirect()->route('menu.index')
                ->withErrors(['error' => 'Menu item not found.']);
        }
    }

    public function edit(string $id)
    {
        try {
            $menu = Menu::findOrFail($id);
            return view('admin.menu.edit', compact('menu'));
        } catch (\Exception $e) {
            return redirect()->route('admin.menu.index')
                ->withErrors(['error' => 'Menu item not found.']);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $menu = Menu::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'category' => 'nullable|string|max:255',
                'is_featured' => 'nullable|boolean',
                'is_special' => 'nullable|boolean',
                'available' => 'nullable|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            ]);
            $validated = $validator->validate();

            if ($request->hasFile('image')) {
                if ($menu->public_id) {
                    Cloudinary::uploadApi()->destroy($menu->public_id);
                }

                $imageResult = Cloudinary::uploadApi()->upload($request->file('image')->getRealPath(), [
                    'folder' => 'menus'
                ]);
                $validated['image'] = $imageResult['secure_url'];
                $validated['public_id'] = $imageResult['public_id'];
            }
            foreach (['is_special', 'is_featured', 'available'] as $field) {
                $validated[$field] = $request->boolean($field);
            }

            $menu->update($validated);
            DB::commit();
            return redirect()->route('admin.menu.index')
                ->with('success', 'Menu item updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update menu item: ' . $e->getMessage()]);
        }
    }

    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $menu = Menu::findOrFail($id);
            if ($menu->public_id) {
                Cloudinary::uploadApi()->destroy($menu->public_id);
            }
            $menu->delete();
            DB::commit();
            return redirect()->route('admin.menu.index')
                ->with('success', 'Menu item deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Failed to delete menu item: ' . $e->getMessage()]);
        }
    }
}
