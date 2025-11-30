<?php
// === THIẾT LẬP KẾT NỐI PDO ===
$host = 'localhost';
$dbname = 'cse485_web'; 
$username = 'root';
$password = '123321';

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage()); // [cite: 45, 46]
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ten_sinh_vien'])) {
    
    // TODO 3
    $ten = $_POST['ten_sinh_vien'];
    $email = $_POST['email'];

    // TODO 4
    $sql = "INSERT INTO sinhvien (ten_sinh_vien, email) VALUES (?, ?)";

    // TODO 5
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$ten, $email]);

    // TODO 6
    header('Location: chapter4.php');
    exit;
}

// === LOGIC LẤY DANH SÁCH SINH VIÊN (SELECT) ===
// TODO 7
$sql_select = "SELECT * FROM sinhvien ORDER BY ngay_tao DESC";

// TODO 8
$stmt_select = $pdo->query($sql_select);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>PHT Chương 4 Website hướng dữ liệu</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { color: #333; }
        form { margin-bottom: 30px; padding: 20px; border: 1px solid #ccc; background: #f9f9f9; }
        input { padding: 5px; margin-right: 10px; }
        button { padding: 5px 15px; cursor: pointer; }
    </style>
</head>
<body>

    <h2>Thêm Sinh Viên Mới (Chủ đề 4.3)</h2>
    <form action="chapter4.php" method="POST">
        Tên sinh viên: <input type="text" name="ten_sinh_vien" required>
        Email: <input type="email" name="email" required>
        <button type="submit">Thêm</button>
    </form>

    <h2>Danh Sách Sinh Viên (Chủ đề 4.2)</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Tên Sinh Viên</th>
            <th>Email</th>
            <th>Ngày Tạo</th>
        </tr>
        <?php
        // TODO 9
        while ($row = $stmt_select->fetch(PDO::FETCH_ASSOC)) {
            // TODO 10
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['ten_sinh_vien']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['ngay_tao']) . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

</body>
</html>