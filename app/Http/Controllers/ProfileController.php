<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10'
        ]);
        
        $user = Auth::user();
        $user->update($request->all());
        
        return redirect()->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }
    
    public function editAddress()
    {
        return view('profile.address');
    }
    
    public function updateAddress(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10'
        ]);
        
        $user = Auth::user();
        $user->update($request->all());
        
        return redirect()->route('profile.address')
            ->with('success', 'Alamat berhasil diperbarui!');
    }
}