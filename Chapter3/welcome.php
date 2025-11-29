<?php

session_start();

if (isset($_SESSION['logged_user'])) {


    $loggedInUser = $_SESSION['logged_user'];


    echo "<h1>Chào mừng trở lại, $loggedInUser!</h1>";
    echo "<p>Bạn đã đăng nhập thành công.</p>";

    echo '<a href="login.html">Đăng xuất (Tạm thời)</a>';

} else {
    header('Location: login.html');
    exit;
}
?>