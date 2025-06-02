<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // User dashboard
    public function dashboard()
    {
        $user = Auth::user();
        $quizAttempts = QuizAttempt::where('user_id', $user->id)
            ->with('quiz')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('user.dashboard', compact('user', 'quizAttempts'));
    }

    // Update profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    // Change password
    public function changePassword(Request $request)
{
    
    $validated = $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
    ]);

  
    $user = auth()->user();

    // Verify current password
    if (!Hash::check($validated['current_password'], $user->password)) {
        return back()->withErrors(['current_password' => 'The current password is incorrect']);
    }

    // Update password
    $user->password = Hash::make($validated['new_password']);
    $user->save();

    return back()->with('success', 'Password changed successfully!');
}
}