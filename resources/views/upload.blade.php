<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Video</title>
</head>
<body>
    <!-- Video upload form -->
    <form action="{{ route('upload.video') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="video">Choose a video file:</label>
        <input type="file" name="video" id="video" required><br>

        <label for="format">Select output format:</label>
        <select name="format" id="format" required>
            <option value="mp4">MP4</option>
            <option value="avi">AVI</option>
            <option value="mkv">MKV</option>
            <option value="flv">FLV</option>
            <option value="mov">MOV</option>
        </select><br>

        <button type="submit">Convert</button>
    </form>

    <!-- Display success message and download link if available -->
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if(session('downloadUrl'))
        <p><a href="{{ session('downloadUrl') }}" download>Download Converted Video</a></p>
    @endif
</body>
</html>
