<?php

namespace App\Http\Controllers;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use DB;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    public function index()
    {
        try {
            $workshops = DB::table('workshops')->orderByDesc('date')->paginate(10);
            return view('user.workshop.index', compact('workshops'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load workshops: ' . $e->getMessage()]);
        }
    }

    public function indexAdmin(Request $request)
    {
        try {
            $search = $request->input('search');
            $workshops = \App\Models\Workshop::when($search, function ($query, $search) {
                return $query->where('id', $search);
            })->paginate(10);
            return view('admin.workshop.index', compact('workshops'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load workshops: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        try {
            $categories = \App\Models\Category::all();
            return view('admin.workshop.create', compact('categories'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load categories: ' . $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = \Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'date' => 'required|date',
                'time' => 'required',
                'max_participants' => 'required|integer|min:1',
                'price' => 'required|numeric|min:0',
                'location' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            ]);
            $validated = $validator->validate();
            $imageResult = Cloudinary::uploadApi()->upload($request->file('image')->getRealPath(), [
                'folder' => 'workshops'
            ]);
            $validated['image'] = $imageResult['secure_url'];
            $validated['public_id'] = $imageResult['public_id'];
            \App\Models\Workshop::create($validated);
            DB::commit();
            return redirect()->route('admin.workshop.index')->with('success', 'Workshop created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Failed to create workshop: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show(string $id)
    {
        try {
            $workshop = \App\Models\Workshop::findOrFail($id);
            return view('user.workshop.show', compact('workshop'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load workshop: ' . $e->getMessage()]);
        }
    }

    public function edit(string $id)
    {
        try {
            $workshop = \App\Models\Workshop::findOrFail($id);
            $categories = \App\Models\Category::all();
            return view('admin.workshop.edit', compact('workshop', 'categories'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load workshop: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $workshop = \App\Models\Workshop::findOrFail($id);
            $validator = \Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'date' => 'required|date',
                'time' => 'required',
                'max_participants' => 'required|integer|min:1',
                'price' => 'required|numeric|min:0',
                'location' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            ]);
            $validated = $validator->validate();
            if ($request->hasFile('image')) {
                $imageResult = Cloudinary::uploadApi()->upload($request->file('image')->getRealPath(), [
                    'folder' => 'workshops'
                ]);
                if ($workshop->public_id) {
                    Cloudinary::uploadApi()->destroy($workshop->public_id);
                }
                $validated['image'] = $imageResult['secure_url'];
                $validated['public_id'] = $imageResult['public_id'];
            }
            $workshop->update($validated);
            DB::commit();
            return redirect()->route('admin.workshop.index')->with('success', 'Workshop updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Failed to update workshop: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $workshop = \App\Models\Workshop::findOrFail($id);
            Cloudinary::uploadApi()->destroy($workshop->public_id);
            $workshop->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Workshop deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Failed to delete workshop: ' . $e->getMessage()]);
        }
    }
}
