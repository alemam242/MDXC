<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADI File Upload</title>
</head>
<body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select .adi file to upload:
        <input type="file" name="adiFile" accept=".adi">
        <input type="submit" value="Upload" name="submit">
    </form>
</body>
</html>
