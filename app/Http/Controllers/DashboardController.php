<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // dd(!is_null(Auth::user()->staff));
        $user = Auth::user()->staff;
        return view('fitur.dashboard', [
            'section' => 'Dashboard',
            'title' => 'Dashboard',
            'user' => $user,
        ]);
    }

    public function profile()
    {
        $user = Auth::user();
        return view('fitur.profile.index', [
            'section' => 'Dashboard',
            'title' => 'Profile',
            'user' => $user,
        ]);
    }

    public function profilePost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'phone' => 'required',
            'job' => 'required|string|max:255',
            'address' => 'required|string|max:500',
        ]);
        // dd($request->all());

        // Upload atau update gambar jika ada
        $data = Auth::user();

        // Simpan atau perbarui data
        $data->update(
            [
                'name' => $request->name, 
                'phone' => $request->phone,
                'address' => $request->address,
                'job' => $request->job,
                'date_of_birth' => $request->date_of_birth,
            ]
        );

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }
}
