<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        return view('system.profile');
    }

    public function update(UpdateProfileRequest $request)
    {
        /**
         * @var User $user
         */
        $user = Auth::user();

        $validatedData = $request->validated();

        // Update the user's profile
        $user->update($validatedData);

        return redirect()->route('system.profile')->with('success', 'Profile updated successfully.');
    }
}
