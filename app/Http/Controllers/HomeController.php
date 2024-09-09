<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AnimalProfile;

class HomeController extends Controller
{
    /**
     * Display the appropriate homepage based on user type.
     */
    public function userHomepage()
    {
        $user = Auth::user();

        if ($user->usertype === 'user') {
            // Fetch animal profiles
            $animalProfiles = AnimalProfile::where('is_adopted', false)
                ->orderBy('created_at', 'desc')
                ->paginate(1000);

            // Fetch user notifications
            $notifications = $user->notifications;

            // Pass the variables to the view
            return view('user.home', compact('animalProfiles', 'notifications'));
        } else {
            // Redirect to the admin homepage if the user is not a user
            return view('admin.home');
        }
    }

    /**
     * Display the admin homepage.
     */
    public function adminHomepage()
    {
        $user = Auth::user();

        if ($user->usertype === 'admin') {
            // Fetch notifications for admin
            $notifications = $user->notifications;

            // Pass notifications to the admin view
            return view('admin.home');
        } else {
            // Redirect to the user homepage if the user is not an admin
            return view('user.home' , compact('notifications'));
        }
    }

    /**
     * Show a specific animal profile.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = Auth::user();
        $notifications = $user->notifications;

        // Fetch the animal profile by ID
        $animal = AnimalProfile::findOrFail($id);

        // Pass the animal profile and notifications to the view
        return view('user.animalProfile', compact('animal', 'notifications'));
    }
}
