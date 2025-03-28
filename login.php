<?php
session_start();
ob_start();

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

   
    if (empty($username) || empty($password)) {
        echo "Tên tài khoản và mật khẩu không được để trống.";
        exit;
    }

   
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

        
            if ($password === $user['password_hash']) { 
            
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
            
            if ($user['role'] === 'admin') {
                header("Location: admin.php"); // Trang cho admin
            } else {
                header("Location: trang_chu.php"); // Trang cho user
            }
            exit;            
            }
} else {

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Tên tài khoản đã tồn tại. Vui lòng chọn tên khác.";
    } else {
        // $hashed_password = password_hash($password, PASSWORD_DE FAULT); 
        $role = 'student';
        $sql = "INSERT INTO users (username, password_hash, role) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $password, $role);
        if ($stmt->execute()) {
            echo "Đăng ký thành công. Bạn có thể đăng nhập ngay bây giờ.";
        } else {
            echo "Đăng ký thất bại. Vui lòng thử lại.";
        }
    }
    $stmt->close();
}
        }

$conn->close();
?>
