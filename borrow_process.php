<?php
session_start();
require_once "config.php";

// Kiểm tra kết nối database
if (!$conn) {
    echo json_encode(["status" => "error", "message" => "Lỗi kết nối database: " . mysqli_connect_error()]);
    exit;
}

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    echo json_encode(["status" => "error", "message" => "Bạn cần đăng nhập để mượn sách."]);
    exit;
}

// Kiểm tra xem request method là POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $book_id = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;
    $student_id = isset($_POST['student_id']) ? $conn->real_escape_string($_POST['student_id']) : ""; // Escaping student_id
    $borrow_date = isset($_POST['borrow_date']) ? $conn->real_escape_string($_POST['borrow_date']) : "";
    $due_date = isset($_POST['due_date']) ? $conn->real_escape_string($_POST['due_date']) : "";
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    // Kiểm tra dữ liệu đầu vào (validation)
    if ($book_id <= 0 || empty($student_id) || empty($borrow_date) || empty($due_date) || $quantity <= 0) { // Thêm kiểm tra due_date
        echo json_encode(["status" => "error", "message" => "Vui lòng nhập đầy đủ thông tin."]);
        exit;
    }

    $conn->begin_transaction();

    try {
        // Kiểm tra xem sách có tồn tại không và số lượng còn đủ không
        $sql_check_book = "SELECT available_quantity FROM book WHERE book_id = ?";
        $stmt = $conn->prepare($sql_check_book);
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result || $result->num_rows == 0) {
            throw new Exception("Sách không tồn tại.");
        }
        $book_data = $result->fetch_assoc();
        if ($book_data['available_quantity'] < $quantity) {
            throw new Exception("Số lượng sách không đủ.");
        }
        $stmt->close();

        // Kiểm tra xem mã sinh viên có tồn tại không (Sử dụng Prepared Statement)
        $sql_check_member = "SELECT member_id FROM member WHERE student_id = ?";
        $stmt = $conn->prepare($sql_check_member);
        $stmt->bind_param("s", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result || $result->num_rows == 0) {
            throw new Exception("Mã sinh viên không tồn tại.");
        }
        $member_id_data = $result->fetch_assoc();
        $member_id = $member_id_data['member_id'];
        $stmt->close();


        // Thêm bản ghi vào bảng borrow (Prepared Statement)
        $sql_borrow = "INSERT INTO borrow (member_id, borrow_date, due_date) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql_borrow);
        $stmt->bind_param("iss", $member_id, $borrow_date, $due_date); // "iss" tương ứng với integer, string, string
        if (!$stmt->execute()) {
            throw new Exception("Lỗi khi thêm lượt mượn: " . $stmt->error);
        }
        $borrow_id = $stmt->insert_id;
        $stmt->close();

        // Thêm bản ghi vào bảng borrowdetails (Prepared Statement)
        $sql_borrow_details = "INSERT INTO borrowdetails (borrow_id, book_id, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql_borrow_details);
        $stmt->bind_param("iii", $borrow_id, $book_id, $quantity); // "iii" tương ứng với integer, integer, integer
        if (!$stmt->execute()) {
            throw new Exception("Lỗi khi thêm chi tiết lượt mượn: " . $stmt->error);
        }
        $stmt->close();

        // Cập nhật số lượng sách có sẵn (Prepared Statement)
        $sql_update_book = "UPDATE book SET available_quantity = available_quantity - ? WHERE book_id = ?";
        $stmt = $conn->prepare($sql_update_book);
        $stmt->bind_param("ii", $quantity, $book_id);
        if (!$stmt->execute()) {
            throw new Exception("Lỗi khi cập nhật số lượng sách: " . $stmt->error);
        }
        $stmt->close();

        // Điều kiện mượn sách (Chưa trả sách --> Không được mượn)
        $sql_check_borrow = "SELECT student_id FROM member 
        INNER JOIN overdue_members ON member.member_id = overdue_members.member_id 
        WHERE member.student_id = ?"; // Thêm điều kiện để kiểm tra student_id
        $stmt = $conn->prepare($sql_check_borrow);
        $stmt->bind_param('s', $student_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Kiểm tra xem có kết quả hay không
        if ($result->num_rows > 0) {
            throw new Exception("Không đủ điều kiện mượn sách: Bạn có sách quá hạn.");
        }

        $stmt->close();
        $conn->commit();

        echo json_encode(["status" => "success", "message" => "Mượn sách thành công."]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["status" => "error", "message" => "Lỗi: " . $e->getMessage()]);
    }

    $conn->close();
}
