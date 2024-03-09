<?php
ob_start();
session_start();
if (isset($_POST['submit'])) {
    $targetDirectory = "uploads/";
    $originalFileName = basename($_FILES["adiFile"]["name"]);
    $timestamp = time();
    $targetFile = $targetDirectory . $timestamp . '_' . $originalFileName;
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file is a valid .adi file
    if ($fileType != "adi") {
        echo "Sorry, only .adi files are allowed.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size (adjust as needed)
    if ($_FILES["adiFile"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Move the uploaded file to the target directory
    if ($uploadOk) {
        if (move_uploaded_file($_FILES["adiFile"]["tmp_name"], $targetFile)) {
            echo "The file ". htmlspecialchars($originalFileName). " has been uploaded.";
            // Pass the uploaded file name to the next step
            header("Location: process_data.php?file=$targetFile");
            exit();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
