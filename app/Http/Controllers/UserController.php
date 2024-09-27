<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // List all users (Only for admin)
    public function index()
    {
        $page_title = 'All Users';
        $page_description = $this->description();
        $users = User::where('id', '!=', 1)->paginate(10);
        return view('pages.users.index', compact('users', 'page_title', 'page_description'));
    }

    // Show form to create a new user (Only for admin)
    public function create()
    {
        $page_title = 'Create User';
        $page_description = $this->description();
        return view('pages.users.create', compact('page_title', 'page_description'));
    }

    // Store new user (Only for admin)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,user',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Display user information
    public function show(User $user)
    {
        $page_title = 'Profile';
        $page_description = $this->description();
        return view('pages.users.show', compact('user', 'page_title', 'page_description'));
    }

    // Edit user (Admins can edit any user, users can only edit themselves)
    public function edit(User $user)
    {
        $page_title = 'Edit User';
        $page_description = $this->description();
        return view('pages.users.edit', compact('user', 'page_title', 'page_description'));
    }

    // Update user (Admins can update any user, users can only update themselves)
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

        // Update user data
        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);
        if (auth()->user()->role == 'user') {
            return redirect()->route('users.show', $user->id)->with('success', 'User updated successfully.');
        }
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Delete user (Only for admin)
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    private function description()
    {
        return 'Bunker plate is an open-source Laravel application';
    }
}
