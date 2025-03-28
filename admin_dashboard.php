<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit;
}

//Truy vấn dữ liệu cho biểu đồ
require_once "config.php";

$sql = "SELECT * FROM `book_statistics` 
GROUP BY borrow_count";
$result = mysqli_query($conn, $sql);

$categories = [];
if ($result) { 
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
} else { 
    echo "Lỗi kết nối: " . $conn->error;
}
?> 

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý thư viện</title>
    <link rel="stylesheet" href="dashboard.css">
    <script src="https://kit.fontawesome.com/19fd129ae2.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['category_name', 'number_cate',], 
            <?php 
                foreach($categories as $category) { 
                    echo "['".$category['book_title'] ."' , ".$category['borrow_count'].", ],";
                }
            ?> 
        ]);

        var options = {
            size: 14,
            width: 400
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
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
                        echo '<li style="color: #002c3e;">Admin: '.implode($_SESSION['full_name']).'</li>';    
                    }
                ?>     
                </ul>
            </nav>
            
            </aside>   
        <main class="main-content"> 
            
                <header class="header">
                <h2>Dashboard</h2>
                </header>
                <hr>
                <br style="clear: both;">
                <div class="container">
        <table>
            <tr>
                <td>
                <div class="card">
                    <h3>Tổng sách</h3>
                    <div class="data">
                        <?php 
                            require_once "config.php";

                            $sql = "SELECT SUM(total_quantity) FROM book" ;
                            $result = mysqli_query($conn, $sql);
                            if($result) { 
                                $tong_sach =$result -> fetch_assoc();
                            } else { 
                                "lỗi truy vấn" .$conn -> error;
                            }
                        ?>
                        <span class="value"><?php echo number_format(implode($tong_sach))?></span>
                        <span class="icon"><i class="fas fa-book"></i></span>
                    </div>
                    <div class="chart-container">
                        <canvas class="chart"></canvas>
                    </div>
                </div>
                </td>
                <td>
                <div class="card" >
                    <h3>Số sách đã cho mượn</h3>
                     <div class="data">
                     <?php 
                            require_once "config.php";

                            $sql = "SELECT COUNT(status_book) FROM borrow where status_book = 'borrowed'" ;
                            $result = mysqli_query($conn, $sql);
                            if($result) { 
                                $borrowed =$result -> fetch_assoc();
                            } else { 
                                "lỗi truy vấn" .$conn -> error;
                            }
                        ?>
                        <span class="value"><?php echo number_format(implode($borrowed)) ?></span>
                        <span class="icon"><i class="fas fa-times-circle"></i>  </span>
                    </div>
                    <div class="chart-container">
                        <canvas class="chart"></canvas>
                 </div>
                </div>
                </td>
            </tr>
            <tr>
                <td>
                <div class="card">
                    <h3>Số sách đã trả</h3>           
                    <div class="data">
                    <?php 
                            require_once "config.php";

                            $sql = "SELECT COUNT(status_book) FROM borrow where status_book = 'returned'" ;
                            $result = mysqli_query($conn, $sql);
                            if($result) { 
                                $returned =$result -> fetch_assoc();
                            } else { 
                                "lỗi truy vấn" .$conn -> error;
                            }
                        ?>
                        <span class="value"><?php echo number_format(implode($returned)) ?></span>
                        <span class="icon"><i class="fas fa-check-circle"></i></span>
                    </div>
                    <div class="chart-container">
                        <canvas class="chart"></canvas>
                    </div>
                </div>
                </td>
                <td>
                <div class="card">
                    <h3>Số sách trễ hạn</h3>
                    <div class="data">
                    <?php 
                            require_once "config.php";

                            $sql = "SELECT COUNT(status_book) FROM borrow where status_book = 'overdue'" ;
                            $result = mysqli_query($conn, $sql);
                            if($result) { 
                                $overdue =$result -> fetch_assoc();
                            } else { 
                                "lỗi truy vấn" .$conn -> error;
                            }
                        ?>
                        <span class="value"><?php echo number_format(implode($overdue)) ?></span>
                        <span class="icon"><i class="fas fa-calendar-times"></i></span>
                    </div>
                     <div class="chart-container">
                        <canvas class="chart"></canvas>
                </div>
        </div>
                </td>
            </tr>
       
       
        
       
        </table>
        <div class="card1">
            <h3>Sách có lượt mượn cao nhất</h3>
            <div class="data">
                <span class="value"><div id="donutchart" style="width:100%; margin: 0 auto;"></div></span>
                
            </div>
            <div class="chart-container">
                <canvas class="chart"></canvas>
            </div>
        </div>      
        <br style="clear:both;">
        <div class="card2">
            <h3>Danh sách sinh viên quá hạn</h3> <hr>
            <div class="data">
                <span class="value">
                <table>
                <tr class="list_title">
                    <th>Member Id</th>
                    <th>Họ và tên</th>
                    <th>Lớp học phần</th>
                    <th>Khóa</th>
                    <th>Id mượn sách</th>
                    <th>Id sách</th>
                    <th>Tên sách</th>
                    <th>Ngày mượn</th>
                </tr>
                <?php 
                require_once "config.php";

                    $sql = "SELECT * FROM overdue_members limit 10";
                     $result = mysqli_query($conn, $sql);
                if ($result) { 
                    // Lấy tất cả hàng từ kết quả truy vấn
                     $overdue_members = mysqli_fetch_all($result, MYSQLI_ASSOC);
                } else { 
                echo "Lỗi truy vấn: " . $conn->error; // Sửa để hiển thị lỗi
                }

                // Lặp qua từng thành viên quá hạn
                foreach ($overdue_members as $row) { 
                ?> <tr class="list" style="text-align:center;">
                    <td><?php echo $row['member_id']; ?></td>
                    <td><?php echo $row['full_name']; ?></td>
                    <td><?php echo $row['class']; ?></td>
                    <td><?php echo $row['course_year']; ?></td>
                    <td><?php echo $row['borrow_id']; ?></td>
                    <td><?php echo $row['book_id']; ?></td>
                    <td><?php echo $row['book_title']; ?></td>
                    <td><?php echo $row['borrow_date']; ?></td>
                    </tr>
                <?php 
                }
            ?>
                </table>
                </span>
            </div>
            <div class="chart-container">
                <canvas class="chart"></canvas>
            </div>
        </div>
        <!-- Add more cards as needed -->
    </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Quản lý Thư viện</p>
    </footer>

</body>
</html>