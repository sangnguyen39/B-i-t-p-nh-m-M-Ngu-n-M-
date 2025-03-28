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
    <link rel="stylesheet" href="style_admin.css">
    <script src="https://kit.fontawesome.com/19fd129ae2.js" crossorigin="anonymous"></script>
</head>

<body>

    
        <section id="admin">
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
                
            <h2 class="tiu_de">Quản lý thư viện</h2>
            <nav>
                <ul class="taskbar"> 
                    <li><a href="admin.php" ><i class="fas fa-home"></i> Trang chủ</a></li> <br> 
                    <li><a href="admin_dashboard.php" ><i class="fas fa-chart-bar"></i> Dashboard</a></li> <br> 
                    <li><a href="admin_quanlysach.php" ><i class="fas fa-box"></i> Quản lý sách</a></li> <br>
                    <li><a href="admin_quanlyphieumuon.php" ><i class="fas fa-calendar-alt"></i> Quản lý phiếu mượn</a></li><br>
                  
                </ul>
            </nav>
           
            <nav class="thong_tin_admin">
                <ul>
                    
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
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
                        echo '<li style="color: #002c3e;">Admin: '.htmlspecialchars(implode($_SESSION['full_name'])).'</li>';    
                    }
                ?>     
                </ul>
            </nav>
            
            </aside>   
        <main class="main-content"> 
            
                <header class="header">
                <form method="GET" action="trang_chu.php" style="float:left;">
                    <input type="text" name="search" placeholder=" Tìm kiếm sách" class="input" style=" width: 300px; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                    <button type="submit" style="padding: 10px 15px; background-color: #444; color: #ffffff; border: none; border-radius: 4px; cursor: pointer;">Tìm kiếm</button>
                </form>
                
                <?php
                // Xử lý tìm kiếm
                if (isset($_GET['search'])) {
                    $search = $conn->real_escape_string($_GET['search']);
                    $search_query = "SELECT book_id, book_title, file_anh_bia FROM book WHERE book_title LIKE '%$search%'";
                    $search_result = $conn->query($search_query);

                    echo '<section class="search-results">';                 
                    echo '<div class="books">';

                    if ($search_result && $search_result->num_rows > 0) {
                        while ($row = $search_result->fetch_assoc()) {
                            echo '<div class="book">';
                            echo '<a href="./borrow_detail_admin.php?id=' . $row['book_id'] . '">';
                            echo '<img src="./db/image/' . htmlspecialchars($row['file_anh_bia']) . '" alt="Ảnh bìa ' . htmlspecialchars($row['book_title']) . '">';
                            echo '<p>' . htmlspecialchars($row['book_title']) . '</p>';
                            echo '</a>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>Không tìm thấy sách phù hợp.</p>';
                    }

                    echo '</div>';
                    echo '</section>';
                }
                ?>
                </header>
                <br style="clear: both;">
                <div class="section2">
                    <h2 style="font-size: 24px;">Sách yêu thích nhất</h2>
                <?php
                $sql= "SELECT * from book order by available_quantity desc limit 10";
                if (isset($_GET["category_name"])) {
                    $category_name = intval($_GET["category_name"]);
                    $sql = "SELECT book_id, book_title, author, publication_year, file_anh_bia, category_id, available_quantity
                            FROM book
                            WHERE publication_year IS NOT NULL AND category_id = $category_name
                            LIMIT 10";
                }
                    $result = $conn->query($sql);
                    if ($result) {
                        $book = $result->fetch_all(MYSQLI_ASSOC);
                ?>
                <div id="availableBooks">
                    <div class="container">
                    <?php 
                    if (!empty($book)) { 
                        foreach ($book as $row) { ?>
                            <div class="card">
                                <a href="./borrow_detail.php?id=<?php echo $row['book_id']; ?>" target="_blank">
                                    <img src="./db/image/<?php echo htmlspecialchars($row["file_anh_bia"]); ?>" alt="Ảnh bìa sách">
                                    <h2><?php echo htmlspecialchars($row["book_title"]); ?></h2>
                                    <h3><?php echo htmlspecialchars($row["publication_year"]); ?></h3>
                                </a>
                            </div>
                        <?php } 
                    } else {
                        echo '<p>Không có sách nào trong thể loại này.</p>';
                    } ?>              
                    </div>
                </div>
                <?php } else {
                    echo "Lỗi kết nối: " . $conn->error;
                }
                ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Quản lý Thư viện</p>
    </footer>

</body>
</html>