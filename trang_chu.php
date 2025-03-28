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
    <link rel="stylesheet" href="style_trang_chu.css">
    <script src="https://kit.fontawesome.com/19fd129ae2.js" crossorigin="anonymous"></script>
</head>

<body>
    <header class="header">
        <img src="./logo HUB.png" alt="" style="width: 100px; height: 100px; float: left; object-fit: cover; ">
        <h1 style="margin-top: 25px; color:#444">QUẢN LÝ THƯ VIỆN</h1>
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

            <h2>Thể loại sách</h2>
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
                    if (isset($_SESSION['username']) && ($_SESSION['username'] != "")) {
                        require_once "config.php";
                        $sql = "SELECT full_name FROM member LEFT JOIN users ON member.student_id = users.username WHERE member.student_id = '" . $_SESSION['username'] . "'";
                        $name = [];
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            $name = $result->fetch_assoc();
                        }
                        $_SESSION['full_name'] = $name;
                        echo '<li style="color: #002c3e;"> Xin chào: ' . implode($_SESSION['full_name']) . '</li>';
                    }
                    ?>
                </ul>
            </nav>

        </aside>
        <main>
            <div class="section2">
                <header>
                    <form method="GET" action="trang_chu.php" style="float:left; margin-bottom: 15px;">
                        <input type="text" name="search" placeholder="Tìm kiếm sách" class="input" style=" width: 300px; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                        <button type="submit" style="padding: 10px 15px; background-color: #444; color: #ffffff; border: none; border-radius: 4px; cursor: pointer;"><b>Tìm kiếm</b></button>
                    </form>

                    <?php

                    // Xử lý tìm kiếm
                    if (isset($_GET['search'])) {
                        $search = $conn->real_escape_string($_GET['search']);
                        $search_query = "SELECT book_id, book_title, file_anh_bia FROM book WHERE book_title LIKE '%$search%'";
                        $search_result = $conn->query($search_query);

                        // Chỉ hiển thị các sách liên quan đến tìm kiếm
                        $books_to_show = [];
                        if ($search_result && $search_result->num_rows > 0) {
                            while ($row = $search_result->fetch_assoc()) {
                                $books_to_show[] = $row['book_id']; // Lưu lại id sách tìm được
                            }
                        }
                        echo '<section class="search-results">';
                        echo '<div class="books">';
                        // Hiển thị các sách liên quan đến tìm kiếm
                        $sql = "SELECT book_id, book_title, file_anh_bia FROM book";
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $book_id = $row['book_id'];
                                $display_class = in_array($book_id, $books_to_show) ? '' : 'hidden';
                                echo '<div class="book ' . $display_class . '">';
                                echo '<a href="./borrow_detail.php?id=' . $row['book_id'] . '">';
                                echo '<img src="./db/image/' . htmlspecialchars($row['file_anh_bia']) . '" alt="Ảnh bìa ' . htmlspecialchars($row['book_title']) . '">';
                                echo '<p>' . htmlspecialchars($row['book_title']) . '</p>';
                                echo '</a>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>Không có sách nào trong cơ sở dữ liệu.</p>';
                        }
                        echo '</div>';
                        echo '</section>';
                    } else {
                        // Nếu không có tìm kiếm, hiển thị tất cả sách
                        $sql = "SELECT book_id, book_title, file_anh_bia FROM book LIMIT 10";
                        if (isset($_GET["category_name"])) {
                            $category_name = intval($_GET["category_name"]);
                            $sql = "SELECT book_id, book_title, author, publication_year, file_anh_bia, category_id, available_quantity
                                    FROM book
                                    WHERE publication_year IS NOT NULL AND category_id = ?
                                LIMIT 10";
                        }
                        // Sử dụng prepared statement để tránh SQL injection
                        $stmt = $conn->prepare($sql);
                        if (isset($category_name)) {
                            $stmt->bind_param("i", $category_name);
                        }

                        $stmt->execute();
                        $result = $stmt->get_result();

                        echo '<section class="search-results">';
                        echo '<div class="books">';

                        if ($result) {
                            $book = $result->fetch_all(MYSQLI_ASSOC);
                            if (!empty($book)) {
                                echo '<div id="availableBooks">';
                                echo '<div class="container">';
                                foreach ($book as $row) {
                    ?>
                                    <div class="card">
                                        <a href="./borrow_detail.php?id=<?php echo $row['book_id']; ?>" target="_blank">
                                            <img src="./db/image/<?php echo htmlspecialchars($row["file_anh_bia"]); ?>" alt="Ảnh bìa sách">
                                            <h2><?php echo htmlspecialchars($row["book_title"]); ?></h2>
                                            <h3><?php echo isset($row["publication_year"]) ? htmlspecialchars($row["publication_year"]) : ''; ?></h3> <!-- Sửa lỗi tại đây -->
                                        </a>
                                    </div>
                    <?php
                                }
                                echo '</div>'; // Kết thúc container
                                echo '</div>'; // Kết thúc availableBooks
                            } else {
                                echo '<p>Không có sách nào trong thể loại này.</p>';
                            }
                        } else {
                            echo "Lỗi kết nối: " . $conn->error;
                        }

                        echo '</div>'; // Kết thúc books
                        echo '</section>';
                    }
                    ?>
                </header>
                <br style="clear: both;">

                <?php
                $sql = "SELECT * from book order by available_quantity desc limit 10";
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
                    <!-- <div id="availableBooks">
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
                    </div> -->
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
<style>
    .hidden {
        display: none;
    }
</style>