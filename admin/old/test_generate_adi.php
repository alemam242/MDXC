<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['event_id'])) {
    echo $eventId = $_POST['event_id'];

    // Database connection
            $servername = "localhost";
            $username = "mdxconirbanbd_qsl";
            $password = "Not4all~";
            $dbname = "mdxconirbanbd_qsl";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

  // Fetch event details
    $eventDetails = array();
    $sql_event = "SELECT event_name, create_date FROM events WHERE id = $eventId";
    $result_event = $conn->query($sql_event);

    if ($result_event->num_rows > 0) {
        $row_event = $result_event->fetch_assoc();
        $eventName = $row_event["event_name"];
        $eventDate = date("Ymd", strtotime($row_event["create_date"]));
    } else {
        echo "Event not found.";
        exit();
    }

    // Fetch files associated with the event
    $adiFiles = array();
    $sql_files = "SELECT file_name FROM user_adfi_files WHERE event_id = $eventId";
    $result_files = $conn->query($sql_files);

    if ($result_files->num_rows > 0) {
        while ($row_files = $result_files->fetch_assoc()) {
            $adiFilePath = "../uploads/" . $row_files["file_name"];
            
            // Read file contents and extract lines between <call...> and <eor>
            $contents = file_get_contents($adiFilePath);
            preg_match_all('/<call:.*?>.*?<eor>/is', $contents, $matches);
            $extractedData = $matches[0];

            foreach ($extractedData as $data) {
                // Add extracted line to array
                $adiFiles[] = $data;
            }
        }
    } else {
        echo "No files uploaded for this event.";
        exit();
    }

    // Create the ADI file
    $adiFileName = "{$eventName}_{$eventDate}.adi";
    $adiFilePath = "../uploads/{$adiFileName}"; // Adjust as needed
    $adiHandle = fopen($adiFilePath, 'w');

    // Write the contents of each file associated with the event into the ADI file
    foreach ($adiFiles as $adiContent) {
        fwrite($adiHandle, $adiContent . PHP_EOL); // Write each line with a line break
    }

    fclose($adiHandle);

    // Display table with extracted data
    echo "<h2>Extracted Data</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Call</th><th>Date</th><th>Time</th><th>Mode</th><th>Band</th><th>Station Call Sign</th></tr>";
    foreach ($adiFiles as $row) {
        // Extract relevant fields from each line
        preg_match('/<call:(.*?)>/', $row, $callMatch);
        preg_match('/<qso_date:(.*?)>/', $row, $dateMatch);
        preg_match('/<time_on:(.*?)>/', $row, $timeMatch);
        preg_match('/<mode:(.*?)>/', $row, $modeMatch);
        preg_match('/<band:(.*?)>/', $row, $bandMatch);
        preg_match('/<station_callsign:(.*?)>/', $row, $stationCallSignMatch);

        $call = isset($callMatch[1]) ? $callMatch[1] : '';
        $date = isset($dateMatch[1]) ? $dateMatch[1] : '';
        $time = isset($timeMatch[1]) ? $timeMatch[1] : '';
        $mode = isset($modeMatch[1]) ? $modeMatch[1] : '';
        $band = isset($bandMatch[1]) ? $bandMatch[1] : '';
        $stationCallSign = isset($stationCallSignMatch[1]) ? $stationCallSignMatch[1] : '';

        // Display the data in the table
        echo "<tr>";
        echo "<td>{$call}</td>";
        echo "<td>{$date}</td>";
        echo "<td>{$time}</td>";
        echo "<td>{$mode}</td>";
        echo "<td>{$band}</td>";
        echo "<td>{$stationCallSign}</td>";
        echo "</tr>";
    }
    echo "</table>";

    // Provide download link for the ADI file
    echo "<p>ADI file generated successfully. <a href='$adiFilePath'>Download ADI file</a></p>";

    $conn->close();
} else {
    echo "Invalid request.";
}
?>