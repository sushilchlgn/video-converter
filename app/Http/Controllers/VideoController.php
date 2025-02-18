<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use FFMpeg\FFMpeg;

class VideoController extends Controller
{
    public function showUploadForm()
    {
        return view('upload'); // The view for video upload
    }

    public function handleUpload(Request $request)
    {
        $request->validate([
            'video' => 'required|mimes:mp4,avi,mkv,mov,flv,wmv|max:50000', // Max size limit
            'format' => 'required|in:mp4,avi,mkv,flv,mov', // Validate selected format
        ]);

        // Handle the uploaded file and store it temporarily
        $video = $request->file('video');
        $tempPath = $video->storeAs('temp', time() . '.' . $video->extension(), 'public');

        // Get the selected format
        $format = $request->input('format');

        // Convert the video
        $convertedVideo = $this->convertVideo($tempPath, $format);

        // Delete the temporary video file
        Storage::disk('public')->delete($tempPath);

        // Return success message and converted video path
        return back()->with('success', 'Video uploaded and converted successfully!')->with('downloadUrl', url('storage/' . $convertedVideo));
    }

    private function convertVideo($tempPath, $format)
    {
        try {
            // Initialize FFmpeg
            $ffmpeg = FFMpeg::create([
                'ffmpeg.binaries' => storage_path('app/ffmpeg/ffmpeg'),
                'ffprobe.binaries' => storage_path('app/ffmpeg/ffprobe'),
            ]);

            // Get the file name and extension
            $videoName = pathinfo($tempPath, PATHINFO_FILENAME);
            $convertedPath = 'videos/' . $videoName . '.' . $format; // Use the selected format

            // Perform the conversion (input file: $tempPath, output file: $convertedPath)
            $ffmpeg->open(storage_path('app/' . $tempPath))
                ->save(new \FFMpeg\Format\Video\X264(), storage_path('app/public/' . $convertedPath));

            return $convertedPath;
        } catch (\Exception $e) {
            // Log the error for debugging and return a friendly message
            return 'Video conversion failed. Please try again later.';
        }
    }
}
