<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function showUploadForm()
    {
        return view('upload'); // The view for video upload
    }

    public function handleUpload(Request $request)
    {
        $request->validate([
            'video' => 'required|mimes:mp4,avi,mkv,mov,flv,wmv|max:50000', // Set max size limit
        ]);

        // Handle the uploaded file
        $video = $request->file('video');
        $videoPath = $video->storeAs('videos', time() . '.' . $video->extension(), 'public');

        return back()->with('success', 'Video uploaded successfully!');
    }
}
