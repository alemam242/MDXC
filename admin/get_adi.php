<?php
ob_start();
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}
// Include database connection file
require_once('../config.php');

$selected_event_id = $_GET['event_id'] ?? '';

// Fetch QSO data based on the selected event ID using prepared statement
$query = "SELECT * FROM user_qsl WHERE event_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $selected_event_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any rows returned
if ($result->num_rows === 0) {
    echo "No records found for this event.";
    exit();
}

// Initialize an empty array to store QSO data
$qso_data = [];

// Fetch data rows from the result set
while ($row = $result->fetch_assoc()) {
    // Add each row to the QSO data array
    $qso_data[] = $row;
}

// Generate ADI file content
$adi_file_content = '';
foreach ($qso_data as $qso) {
    // Format each QSO entry in ADI format and append to the ADI file content
    $adi_file_content .= '<CALL:' . strlen($qso['call']) . '>' . $qso['call'] . ' ';
    $adi_file_content .= '<BAND:' . strlen($qso['band']) . '>' . $qso['band'] . ' ';
    $adi_file_content .= '<MODE:' . strlen($qso['mode']) . '>' . $qso['mode'] . ' ';
    $adi_file_content .= '<QSO_DATE:8>' . preg_replace('/[^0-9]/', '', $qso['qso_date']) . ' ';
    $adi_file_content .= '<TIME_ON:6>' . preg_replace('/[^0-9]/', '', $qso['time_on']) . ' ';
    $adi_file_content .= '<FREQ:9>' . preg_replace('/[^0-9]/', '', $qso['freq']) . ' ';
    $adi_file_content .= '<OPERATOR:' . strlen($qso['operator']) . '>' . $qso['operator'] . ' ';
    $adi_file_content .= '<RST_SENT:3>' . $qso['rst_sent'] . '<EOR>' . "\n";
}

// Export the ADI file
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="eventQSOData.adi"');
echo $adi_file_content;

// End the script to prevent any further output
exit();
?>
