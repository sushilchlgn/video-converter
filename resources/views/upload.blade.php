<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Video</title>
</head>
<body>
    <form action="{{ route('upload.video') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="video">Choose a video file:</label>
        <input type="file" name="video" id="video" required>
        <button type="submit">Upload Video</button>
    </form>
</body>
</html>
