<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $class = $_POST['class'];
    $course_year = (string)$_POST['course_year']; 
    $password = $_POST['password'];

    if (empty($student_id) || empty($full_name) || empty($email) || empty($class) || empty($course_year) || empty($password)) {
        echo "Vui lòng điền đầy đủ thông tin.";
        exit;
    }

    $sql = "SELECT * FROM member WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email đã tồn tại. Vui lòng chọn email khác.";
    } else {
        $sql = "INSERT INTO member (student_id, full_name, email, class, course_year, password_hash) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $student_id, $full_name, $email, $class, $course_year, $password);
        if ($stmt->execute()) {
            $role = 'student'; 
            $sql_users = "INSERT INTO users (username, password_hash, role) VALUES (?, ?, ?)";
            $stmt_users = $conn->prepare($sql_users);
            $stmt_users->bind_param("sss", $student_id, $password, $role);

            if ($stmt_users->execute()) {
                echo "Đăng ký thành công. Bạn có thể đăng nhập ngay bây giờ. <br>"; 
                echo "<form action='index.html'><button type='submit'>Quay lại</button></form>";
            } else {
                echo "Lỗi khi thêm vào bảng users.";
            }
        } else {
            echo "Lỗi khi thêm vào bảng member.";
        }
    }
    $stmt->close();
}

$conn->close();
?>
