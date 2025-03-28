<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý thư viện</title>
    <link rel="stylesheet" href="style-detail-borrow.css">
    <script src="https://kit.fontawesome.com/19fd129ae2.js" crossorigin="anonymous"></script>
</head>

<body>
    <header class="header">
        <img src="./logo HUB.png" alt="" style="width: 100px; height: 100px; float: left; object-fit: cover; ">
        <h1 style="margin-top: 25px;">QUẢN LÝ THƯ VIỆN</h1> 
    </header>
    
    <section>
            <aside class="sidebar">
            <?php 
            require_once "config.php";

            // Lấy danh sách thể loại
            $sql = "SELECT * FROM category";
            $result = mysqli_query($conn, $sql);
            $list_the_loai = [];
            if ($result) { 
                $list_the_loai = $result->fetch_all(MYSQLI_ASSOC);  
            } else {
                echo "Lỗi truy vấn: " . $conn->error;
            }
            ?>
                
            <h2 >Thể loại sách</h2>
            <table>
                <?php 
                foreach ($list_the_loai as $row) { ?>
                    <tr>
                        <td>
                            <a href="trang_chu.php?category_name=<?php echo $row['category_id']; ?>">
                                <?php echo htmlspecialchars($row["category_name"]); ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>

            <table>
                <h2>Người đọc gần đây</h2>
                <?php 
                // Giả định bạn đã lấy dữ liệu người đọc gần đây
                if (isset($recent_users_result) && !empty($recent_users_result)) {
                    foreach ($recent_users_result as $row) { ?>
                        <tr>
                            <td>
                                <a href="trang_chu.php?full_name=<?php echo $row['full_name']; ?>" style="font-size:larger;">
                                    <?php echo htmlspecialchars($row["full_name"]); ?>
                                </a>
                            </td>
                        </tr>
                    <?php } 
                } ?>
            </table>
            <nav class="infor_user">
                <ul>
                
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li> <br>
                <?php 
                    if(isset($_SESSION['username']) && ($_SESSION['username']!="")){ 
                        require_once "config.php"; 
                        $sql="SELECT full_name FROM member LEFT JOIN users ON member.student_id = users.username WHERE member.student_id = '".$_SESSION['username']."'";
                        $name = [];
                        $result = mysqli_query($conn, $sql);
                        if($result) { 
                            $name = $result -> fetch_assoc();
                        } 
                        $_SESSION['full_name'] = $name; 
                        echo '<li style="color: #002c3e;"> Xin chào: '.implode($_SESSION['full_name']).'</li>';    
                    }
                ?>   
                </ul>
            </nav>
           
            </aside>
            <main>       
    <div class="section2">
            <?php 
    // Thay 'book_id' thành 'id' để khớp với URL của bạn
    if (isset($_GET['id'])) { 
        $id = intval($_GET['id']);
        
        // Chỉnh sửa câu truy vấn sử dụng tên trường đúng
        $sql = "SELECT * FROM book WHERE book_id = $id"; // Không cần dấu nháy đơn quanh biến số
        $result = $conn->query($sql);
        
        if ($result && $result->num_rows > 0) { 
            $book = $result->fetch_assoc(); 
            if ($book) { // Kiểm tra xem có dữ liệu không
    ?>
        <div class="detail" >   
            <div class="img" style="float: left;">
                <img src="./db/image/<?php echo htmlspecialchars($book['file_anh_bia']); ?>" alt="Ảnh bìa" width="200px"> <br>
            </div>
            <div class="content">
                <h2><?php echo htmlspecialchars($book['book_title']); ?></h2>
                <b>Tác giả:</b> <?php echo htmlspecialchars($book['author']); ?> <br>
                <b>Năm phát hành:</b> <?php echo htmlspecialchars($book['publication_year']); ?> <br>
                <b>Số lượng còn lại:</b> <?php echo htmlspecialchars($book['available_quantity']); ?> <br>
                <b>Mô tả: </b><br><i><?php echo htmlspecialchars($book['mo_ta']); ?></i> <br>
                <b>Số lượng còn lại: </b> <?php echo htmlspecialchars($book['available_quantity']) ?> 
                <div>
                    <button id="openModal" class="btn1"><b>Chỉnh sửa</b></button>
                    <button class="btn2"><a href="trang_chu.php"><b>Hủy</b></a></button>
                </div>
            </div>
        </div>
        <div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Đăng ký mượn sách</h2>
        <form action="" class="muon_sach">
            <b>Thông tin cá nhân: </b> <br>
            Họ và tên: <input type="text" placeholder="Họ và tên"> <br>
            Mã sinh viên: <input type="text" placeholder="Mã sinh viên"> <br>
            Ngày mượn: <input type="date"> <br>
            Ngày trả: <input type="date"> <br>
            Số lượng: <input type="number"><br>
            <button class="firm">Xác nhận</button>
            <button class="cancel">Hủy</button>
        </form>
    </div>
</div>

<script>
    // Lấy các phần tử
    var modal = document.getElementById("myModal");
    var btn = document.getElementById("openModal");
    var span = document.getElementsByClassName("close")[0];

    // Khi người dùng nhấn nút, mở cửa sổ nhỏ
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // Khi người dùng nhấn vào nút đóng (x), đóng cửa sổ nhỏ
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Khi người dùng nhấn vào bất kỳ đâu ngoài cửa sổ nhỏ, đóng cửa sổ nhỏ
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
                

    <?php 
            } else {
                echo "Không tìm thấy sách.";
            }
        } else {
            echo "Lỗi truy vấn: " . $conn->error;
        }
    } else {
        echo "Không có ID sách.";
    }
    ?>
            </div>
    </div>
</section>
    </main>

  <footer>
        <p>&copy; 2025 Quản lý Thư viện</p>
  </footer>
</body>
</html>