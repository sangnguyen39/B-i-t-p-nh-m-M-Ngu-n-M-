<?php 
    $servername ="localhost";
    $username ="ngusan1_thu_vien";
    $password = "123nhom2";
    $dbname = "ngusan1_thu_vien";
    //Tao ket noi
    $conn = new mysqli($servername, $username, $password, $dbname);
    //kiem tra ket noi 
    if($conn -> connect_error){
        die("ket noi that bai: " .$conn->connect_error);
    }
    // Truy vấn sách yêu thích (category_id = 1)
$favorites_query = "SELECT book_title, file_anh_bia FROM book WHERE category_id = 1";
$favorites_result = $conn->query($favorites_query);

// Truy vấn sách mới (category_id = 2)
$new_books_query = "SELECT book_title, file_anh_bia FROM book WHERE category_id = 2";
$new_books_result = $conn->query($new_books_query);

// Truy vấn danh sách thể loại từ bảng book
$categories_query = "SELECT  category_name FROM category";
$categories_result = $conn->query($categories_query);

// Truy vấn danh sách người đọc gần đây từ bảng member
$recent_users_query = "SELECT full_name FROM member ORDER BY student_id DESC LIMIT 8";
$recent_users_result = $conn->query($recent_users_query);

    $conn -> set_charset("utf8");
?>