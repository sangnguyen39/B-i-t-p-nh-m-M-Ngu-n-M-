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

function get_phieu_muon()
{
    global $conn; // Sử dụng biến $conn toàn cục
    $sql = "SELECT borrow.*, member.full_name, book.book_title
            FROM borrow
            JOIN member ON borrow.member_id = member.member_id
            JOIN book ON borrow.borrow_id = book.book_id";
    $result = mysqli_query($conn, $sql);

    // Kiểm tra lỗi truy vấn
    if (!$result) {
        return "Lỗi truy vấn: " . $conn->error;
    }

    // Chuyển đổi dữ liệu thành mảng
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

function get_phieu_muon_filter(){
    $status = $_GET['status'];
    global $conn; // Sử dụng biến $conn toàn cục
    $sql = "SELECT borrow.*, member.full_name, book.book_title
        FROM borrow
        JOIN member ON borrow.member_id = member.member_id
        JOIN book ON borrow.borrow_id = book.book_id
        WHERE borrow.status_book = '$status'";
    $result = mysqli_query($conn, $sql);

    // Kiểm tra lỗi truy vấn
    if (!$result) {
        return "Lỗi truy vấn: " . $conn->error;
    }

    // Chuyển đổi dữ liệu thành mảng
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}
function get_phieu_muon_search()
{
    $search = $_GET['search'];
    global $conn; // Sử dụng biến $conn toàn cục
    $sql = "SELECT borrow.*, member.full_name, book.book_title
          FROM borrow
          JOIN member ON borrow.member_id = member.member_id
          JOIN book ON borrow.borrow_id = book.book_id
          WHERE borrow.member_id LIKE '%$search%'";
    $result = mysqli_query($conn, $sql);

    // Kiểm tra lỗi truy vấn
    if (!$result) {
        return "Lỗi truy vấn: " . $conn->error;
    }

    // Chuyển đổi dữ liệu thành mảng
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Kiểm tra xem tham số 'action' có được gửi không
    $action = $_GET['action'] ?? '';

    // Dựa trên action, gọi hàm tương ứng
    if ($action === 'get_phieu_muon') {
        $response = get_phieu_muon(); // Gọi hàm trực tiếp
        echo json_encode(['success' => true, 'data' => $response]);
    } else if($action === 'fillter') {
        $response = get_phieu_muon_filter(); // Gọi hàm trực tiếp
        echo json_encode(['success' => true, 'data' => $response]);
    }else if($action === 'search') {
        $response = get_phieu_muon_search(); // Gọi hàm trực tiếp
        echo json_encode(['success' => true, 'data' => $response]);
    }else {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
    exit; // Kết thúc xử lý
}

?>