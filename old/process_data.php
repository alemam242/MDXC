<?php
$file = $_GET['file'];

if (!empty($file) && file_exists($file)) {
    $adiContent = file_get_contents($file);

    // Parse multiple sets of ADI data
    preg_match_all('/<call:(\d+)>(.*?)<eor>/i', $adiContent, $matches, PREG_SET_ORDER);

    // Display links to individual sets
    foreach ($matches as $index => $match) {
        echo "<p><a href='#' onclick='showData($index)'>Set $index</a></p>";
    }

    // Process each set of data
    foreach ($matches as $index => $match) {
        // Parse ADI data (this is a simplified example, adjust as needed)
        $set = $match[2];
        $matches = [];
        preg_match_all('/<([^:]+):(\d+)>([^<]+)\s*/', $set, $matches);

        $data = array_combine($matches[1], $matches[3]);
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>ADI File Data</title>
            <style>
                table {
                    border-collapse: collapse;
                    width: 100%;
                }

                th, td {
                    border: 1px solid #dddddd;
                    text-align: left;
                    padding: 8px;
                }
            </style>
            <script>
                function showData(index) {
                    window.alert("Set " + index + " data:\n\n<?php echo addslashes($set); ?>");
                }
            </script>
        </head>
        <body>
            <hr>
        </body>
        </html>

        <?php
    }
} else {
    echo "File not found.";
}
?>
