<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>PHT Chương 5 - MVC</title> <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; } 
    </style>
</head>
<body>
    <h2>Thêm Sinh Viên Mới (Kiến trúc MVC)</h2> <form action="" method="post">
        <label>Tên Sinh Viên:</label>
        <input type="text" name="ten_sinh_vien" required>
        <br><br>
        <label>Email:</label>
        <input type="email" name="email" required>
        <br><br>
        <button type="submit">Thêm sinh viên</button>
    </form>
    <hr>

    <h2>Danh Sách Sinh Viên (Kiến trúc MVC)</h2> <table>
        <tr>
            <th>ID</th>
            <th>Tên Sinh Viên</th>
            <th>Email</th>
            <th>Ngày Tạo</th> </tr>
        <?php
        if (isset($danh_sach_sv) && is_array($danh_sach_sv)) {
            foreach ($danh_sach_sv as $sv) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($sv['id']) . "</td>"; 
                echo "<td>" . htmlspecialchars($sv['ten_sinh_vien']) . "</td>";
                echo "<td>" . htmlspecialchars($sv['email']) . "</td>";
                echo "<td>" . (isset($sv['created_at']) ? htmlspecialchars($sv['created_at']) : '') . "</td>"; 
                echo "</tr>";
            }
        }
        ?>
    </table>
</body>
</html>