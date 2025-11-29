<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
    <h2 class="mb-4">Danh sách Điểm danh (Từ CSV)</h2>

    <?php
    $filename = '65HTTT_Danh_sach_diem_danh.csv';

    if (file_exists($filename)) {
        echo '<table class="table table-bordered table-striped table-hover">';
        
        if (($handle = fopen($filename, "r")) !== FALSE) {
            // Read the Header Row first
            $headers = fgetcsv($handle, 1000, ",");
            
            echo '<thead class="table-dark"><tr>';
            foreach ($headers as $header) {
                echo "<th>" . htmlspecialchars($header) . "</th>";
            }
            echo '</tr></thead>';
            
            echo '<tbody>';
            // Read the rest of the rows
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                echo '<tr>';
                foreach ($data as $cell) {
                    echo "<td>" . htmlspecialchars($cell) . "</td>";
                }
                echo '</tr>';
            }
            echo '</tbody>';
            
            fclose($handle);
        }
        echo '</table>';
    } else {
        echo '<div class="alert alert-danger">Không tìm thấy file CSV.</div>';
    }
    ?>
</div>

</body>
</html>