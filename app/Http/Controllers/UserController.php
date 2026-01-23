<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $users = User::when($search, function ($query, $search) {
                return $query->where('id', $search);
            })->paginate(10);
            return view('admin.user.index', compact("users"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load users: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed',
            ]);

            $validated = $validator->validate();

            User::create([
                'name' => $validated["name"],
                'email' => $validated["email"],
                'password' => Hash::make($validated['password'])
            ]);

            return redirect()->route('admin.user.index')
                ->with('success', 'Added new user successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create user: ' . $e->getMessage()]);
        }
    }

    public function show(int $id)
    {
        $user = User::findOrFail($id);
        return view('user.show')->with('user', $user);
    }

    public function edit(int $id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit')->with('user', $user);
    }

    public function update(Request $request, int $id)
    {
        try {
            $user = User::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'role' => 'required|in:admin,user',
            ]);

            $validated = $validator->validate();

            $user->name = $validated['name'];
            $user->role = $validated['role'];

            $user->save();

            return redirect()->route('admin.user.index')
                ->with("success", "Updated user successfully.");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update user: ' . $e->getMessage()]);
        }
    }

    public function destroy(int $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route("admin.user.index")
                ->with('success', 'Deleted user successfully.');
        } catch (\Exception $e) {
            return redirect()->route("admin.user.index")
                ->withErrors(['error' => 'Failed to delete user: ' . $e->getMessage()]);
        }
    }
}
