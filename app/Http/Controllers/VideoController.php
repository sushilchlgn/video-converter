<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class VideoController extends Controller
{
    public function showUploadForm()
    {
        return view('upload'); // The view for video upload
    }

    public function handleUpload(Request $request)
    {
        $request->validate([
            'video' => 'required|mimes:mp4,avi,mkv,mov,flv,wmv|max:50000', // Max size in KB (50MB in this case)
        ]);

        // Handle the uploaded file and store it temporarily
        $video = $request->file('video');
        $path = $video->storeAs('temp', time() . '.' . $video->extension(), 'public'); // Temporary storage

        // Perform the conversion (to be implemented)
        $convertedVideo = $this->convertVideo($path);

        // After conversion, delete the temporary video
        Storage::disk('public')->delete($path);

        // Return download link to the user
        return back()->with('success', 'Video uploaded and converted successfully!')->with('convertedVideo', $convertedVideo);
    }

    private function convertVideo($path)
    {
        // Use FFmpeg to convert the video here and return the path of the converted video
        // This will be the next step to implement
    }
}
