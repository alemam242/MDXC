<?php
// Read .adi file
$file = $_GET['file'];
$adiContent = file_get_contents($file);

// Parse multiple sets of ADI data
preg_match_all('/<call:(\d+)>(.*?)<eor>/i', $adiContent, $matches, PREG_SET_ORDER);

// Process each set of data
foreach ($matches as $match) {
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
    </head>
    <body>
        <h2>ADI File Data</h2>
        <table>
            <tr>
                <th>Field</th>
                <th>Value</th>
            </tr>
            <?php
            foreach ($data as $field => $value) {
                echo "<tr><td>$field</td><td>$value</td></tr>";
            }
            ?>
        </table>
        <hr>
    </body>
    </html>

    <?php
}
?>
