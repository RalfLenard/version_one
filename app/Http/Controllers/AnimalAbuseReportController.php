<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnimalAbuseReport;
use Illuminate\Support\Facades\Auth;

use App\Events\AnimalAbuseReportSubmitted;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnimalAbuseReportController extends Controller
{
    
    public function create()
    {
         $user = auth()->user();
         $notifications = $user->notifications;
        return view('user.AnimalAbuseReporting', compact('notifications'));
    }



public function store(Request $request)
{
    $request->validate([
        'description' => 'nullable|string',
        'photos1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'photos2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'photos3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'photos4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'photos5' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'videos1' => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg|max:20480',
        'videos2' => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg|max:20480',
        'videos3' => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg|max:20480',
    ]);

    $photos = [];
    $videos = [];

    foreach (['photos1', 'photos2', 'photos3', 'photos4', 'photos5'] as $photo) {
        if ($request->hasFile($photo)) {
            $photos[$photo] = $request->file($photo)->store('photos', 'public');
        }
    }

    foreach (['videos1', 'videos2', 'videos3'] as $video) {
        if ($request->hasFile($video)) {
            $videos[$video] = $request->file($video)->store('videos', 'public');
        }
    }

    try {
        $report = AnimalAbuseReport::create([
            'user_id' => Auth::id(),
            'description' => $request->description,
            'photos1' => $photos['photos1'] ?? null,
            'photos2' => $photos['photos2'] ?? null,
            'photos3' => $photos['photos3'] ?? null,
            'photos4' => $photos['photos4'] ?? null,
            'photos5' => $photos['photos5'] ?? null,
            'videos1' => $videos['videos1'] ?? null,
            'videos2' => $videos['videos2'] ?? null,
            'videos3' => $videos['videos3'] ?? null,
        ]);

        // Dispatch the event
        event(new AnimalAbuseReportSubmitted($report));

        return redirect()->route('report.abuse.form')->with('success', 'Report submitted successfully.');
    } catch (\Exception $e) {
        \Log::error('Animal Abuse Report Submission Failed: ' . $e->getMessage());
        return redirect()->route('report.abuse.form')->with('error', 'Failed to submit the report.');
    }
}



  
    public function index()
    {
        // Fetch all animal abuse reports
        $abuses = AnimalAbuseReport::all();
        return view('admin.AnimalAbuseReporting', compact('abuses'));
    }
}
