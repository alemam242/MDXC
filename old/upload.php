<?php
ob_start();
session_start();

if (isset($_POST['submit'])) {
    $targetDirectory = "uploads/";
    $adiFileName = "all_data.adi"; // Fixed file name
    $targetFile = $targetDirectory . $adiFileName;
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file is a valid .adi file
    if ($fileType != "adi") {
        echo "Sorry, only .adi files are allowed.";
        $uploadOk = 0;
    }

    // Check file size (adjust as needed)
    if ($_FILES["adiFile"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Append the uploaded data to the existing .adi file, extracting relevant lines
    if ($uploadOk) {
        $uploadedData = file_get_contents($_FILES["adiFile"]["tmp_name"]);

        // Extract lines between <call...> and <eor> and concatenate them
        preg_match_all('/<call:.*?>.*?<eor>/is', $uploadedData, $matches);
        $extractedData = implode("\n", $matches[0]);

        // Append the extracted data to the existing .adi file
        if (file_put_contents($targetFile, $extractedData, FILE_APPEND | LOCK_EX) !== false) {
            echo "The file has been uploaded.";
            
            echo "<a href='/$targetFile'>Download File</a>";
            // Redirect to the processing page with the link to the file
            //header("Location: process_data.php?file=$targetFile");
            exit();
        } else {
            echo "Sorry, there was an error appending your data.";
        }
    }
}
?>

