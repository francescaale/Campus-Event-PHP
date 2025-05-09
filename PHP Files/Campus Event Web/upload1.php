<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
</head>
<body>
    <h2>Upload an Image</h2>
    <form action='upload.php' method="post" enctype="multipart/form-data">
        Select Image: <input type="file" name="file" accept="image/*" required><br><br>
        <input type="submit" name="submit" value="Upload">
    </form>
</body>
</html>
