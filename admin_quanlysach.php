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
    <link rel="stylesheet" href="quan_ly_sach.css">
    <script src="https://kit.fontawesome.com/19fd129ae2.js" crossorigin="anonymous"></script>
</head>

<body>
    <section id="admin" style="width: 100%; ">
        <aside class="sidebar" style="width:300px;">
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
                
            <h2 class="tiu_de">Quản lý thư viện</h2>
            <nav>
                <ul class="taskbar" style="font-size: 20px;"> 
                    <li><a href="admin.php"><i class="fas fa-home"></i> Trang chủ</a></li> 
                    <li><a href="admin_dashboard.php"><i class="fas fa-chart-bar"></i> Dashboard</a></li> 
                    <li><a href="admin_quanlysach.php"><i class="fas fa-box"></i> Quản lý sách</a></li> 
                    <li><a href="admin_quanlyphieumuon.php"><i class="fas fa-calendar-alt"></i> Quản lý phiếu mượn</a></li>
                </ul>
            </nav>
           
            <nav class="thong_tin_admin">
                <ul>
                    
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
                    <?php 
                    if (isset($_SESSION['username']) && ($_SESSION['username'] != "")) { 
                        require_once "config.php"; 
                        $sql = "SELECT full_name FROM member LEFT JOIN users ON member.student_id = users.username WHERE member.student_id = '".$_SESSION['username']."'";
                        $name = [];
                        $result = mysqli_query($conn, $sql);
                        if ($result) { 
                            $name = $result->fetch_assoc();
                        }
                        $_SESSION['full_name'] = $name; 
                        echo '<li style="color: #002c3e;">Admin: ' . htmlspecialchars($name['full_name']) . '</li>';    
                    }
                    ?>     
                </ul>
            </nav>
        </aside>   

        <main class="main-content" style="width: 100%;"> 
            <header class="header">
                <h2>Quản lý sách</h2>
            </header>
            <hr>
            
            <div>
                <form method="GET" action="admin_quanlysach.php">
                    <select name="category_name" class="list" onchange="this.form.submit()">
                        <option>Chọn thể loại</option>
                        <?php foreach ($list_the_loai as $row) { ?>
                            <option value="<?php echo htmlspecialchars($row['category_name']); ?>" <?php if (isset($_GET['category_name']) && $_GET['category_name'] == $row['category_name']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($row['category_name']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </form>
            </div>

            <div class="table-responsive">
                <table>
                    <tr>
                        <th>STT</th>
                        <th>Tên sách</th>
                        <th>Tác giả</th>
                        <th>Nhà xuất bản</th>
                        <th>Năm xuất bản</th>                        
                        <th>Lượt mượn</th>
                    </tr>
                    <?php 
                    // Lấy danh sách sách
                    if (isset($_GET['category_name']) && $_GET['category_name'] != "") {
                        $category_name = mysqli_real_escape_string($conn, $_GET['category_name']);
                        $sql = "
                        SELECT *  
                        FROM book 
                        JOIN category ON book.category_id = category.category_id 
                        LEFT JOIN book_statistics ON book.book_title = book_statistics.book_title 
                        WHERE category.category_name = '$category_name' ";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            $list_sach = $result->fetch_all(MYSQLI_ASSOC);
                            $i = 1;
                            foreach ($list_sach as $row) {
                                echo "<tr>";
                                echo "<td>" . $i++ . "</td>";
                                echo "<td>" . htmlspecialchars($row['book_title']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['author']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nha_xuat_ban']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['publication_year']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['borrow_count']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Lỗi truy vấn: " . $conn->error . "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Chưa chọn thể loại sách.</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </main>
    </section>

    <footer>
        <p>&copy; 2025 Quản lý Thư viện</p>
    </footer>

</body>
</html>