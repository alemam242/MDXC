<?php
require_once '../config.php';
ob_start();
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['event_id'])) {
     $eventId = $_POST['event_id'];


    // Fetch event details
    $eventDetails = array();
    $sql_event = "SELECT event_name, create_date FROM events WHERE id = $eventId";
    $result_event = $conn->query($sql_event);

    if ($result_event->num_rows > 0) {
        $row_event = $result_event->fetch_assoc();
        $eventName = $row_event["event_name"];
        $eventDate = date("Ymd", strtotime($row_event["create_date"]));
    } else {
        $print_data=2;
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
            $extractedData = implode("\n", $matches[0]);

            $adiFiles[] = $extractedData;
        }
    } else {
        $print_data=2;
    }
    $gen_date=date("Y_m_d_h_i_sa");
    // Create the ADI file
    $adiFileName = "{$gen_date}_{$eventName}_{$eventDate}.adi";
    $adiFilePath = "../uploads/{$adiFileName}"; // Adjust as needed
    $adiHandle = fopen($adiFilePath, 'w');

    // Write the contents of each file associated with the event into the ADI file
    foreach ($adiFiles as $adiContent) {
        fwrite($adiHandle, $adiContent);
    }

    fclose($adiHandle);

    $print_data= 1;

    $conn->close();
} else {
   $print_data=2;
}
?>


<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard | MDXC ADI Management System</title>
    <link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/master.css" rel="stylesheet">
    <link href="assets/vendor/flagiconcss/css/flag-icon.min.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
       <?php include("menu.php"); ?>
        <div id="body" class="active">
            <!-- navbar navigation component -->
            
            <nav class="navbar navbar-expand-lg navbar-white bg-white">
                <button type="button" id="sidebarCollapse" class="btn btn-light">
                    <i class="fas fa-bars"></i><span></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    
                </div>
            </nav>
            <!-- end of navbar navigation -->
            <div class="content">
                <div class="container-fluid">
                    <div class="page-title">
                        <h3>ADI Generation Report</h3>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <?php if ($print_data==1){?>
                                        <h5 class="card-header"><?=$eventName?></h5>
                                        <div class="card-body">
                                            <h5 class="card-title"></h5>
                                            <p class="card-text">ADI file generated successfully.</p>
                                            <a href="<?=$adiFilePath?>" class="btn btn-primary">Download</a>
                                        </div>
                                        <?php }else{?>
                                        
                                        <h5 class="card-header">No Event Name</h5>
                                        <div class="card-body">
                                            <h5 class="card-title"></h5>
                                            <p class="card-text">Try Again</p>
                                            
                                        </div>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>