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
    <link rel="stylesheet" href="dashboard.css">
    <script src="https://kit.fontawesome.com/19fd129ae2.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ3QHQABK4fGgCEwEO6Tvh1TiD7CvM1aK3BVRxWqs6jdoHttwtlTbZt4r6FI" crossorigin="anonymous">
</head>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #dee2e6;
        padding: 8px;
        text-align: left;
    }

    thead th {
        background-color: #f8f9fa;
    }
    #pagination {
        display: flex;
        justify-content: flex-end; /* Căn chỉnh các nút sang bên phải */
        margin-top: 30px;
        width:1300px;
        float:right
    }

    #pagination button {
        padding: 10px 20px; /* Tăng kích thước nút */
        font-size: 16px; /* Tăng kích thước font */
        margin: 0 5px; /* Tạo khoảng cách giữa các nút */
        border-radius: 5px; /* Làm tròn các góc */
        border: 1px solid #007bff; /* Viền nút */
        background-color: #007bff; /* Màu nền của nút */
        color: white; /* Màu chữ */
        cursor: pointer;
        transition: background-color 0.3s ease; /* Hiệu ứng chuyển màu */
    }

    #pagination button:hover {
        background-color: #0056b3; /* Màu nền khi hover */
    }

    #pagination button.active {
        background-color: #0056b3; /* Màu nền của nút hiện tại */
        border-color: #003366; /* Màu viền của nút hiện tại */
    }
    .status-bar {
            display: flex;
            justify-content: space-around;
            background-color: #c6d0f5;
            padding: 10px;
            border-radius: 7px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
            
        }

        /* Cấu hình cho mỗi trạng thái */
        .status-item {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
            text-align: center;
        }

        /* Màu sắc mặc định của trạng thái */
        .status-item:hover {
            background-color: #e0e0e0;
        }

        /* Trạng thái active */
        .active {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            width:"200px"
        }
        .inputForm .form-inline {
            margin: 0;
            justify-content: left;
            margin-bottom: 10px;
            gap: 50px; /* Khoảng cách đều giữa các thành phần */
        }

        /* Các select và input bo tròn */
        .inputForm .form-control {
            
            border-radius: 25px; /* Bo tròn */
            padding: 10px 15px; /* Tăng khoảng cách bên trong */
            flex: 1; /* Đặt các thành phần co giãn */
            width: 300px;
            
        }
        

        /* Button màu xanh lá */
        .inputForm .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
            padding: 10px 20px; /* Tăng kích thước nút */
            border-radius: 25px;
            font-weight: bold;
        }

        /* Hover effect cho button */
        .inputForm .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
</style>
<body>
    <section style="min-width:100%;max-width: none;" id="admin">
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
            <nav style="width:250px">
                <ul class="taskbar"> 
                    <li><a href="admin.php" ><i class="fas fa-home"></i> Trang chủ</a></li> <br> 
                    <li><a href="admin_dashboard.php" ><i class="fas fa-chart-bar"></i> Dashboard</a></li> <br> 
                    <li><a href="admin_quanlysach.php" ><i class="fas fa-box"></i> Quản lý sách</a></li> <br>
                    <li><a href="" ><i class="fas fa-calendar-alt"></i> Quản lý phiếu mượn</a></li><br>
                   
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
        <main style="width: 100%" > 
            <header class="header">
            <h2>Quản lí phiếu mượn</h2>
            </header>
            <hr>
            <div class="container">
                <div style="width:100%" class="status-bar">
                    <div class="status-item" id="all" onclick="setActiveStatus('all')">Tất cả</div>
                    <div class="status-item" id="borrowed" onclick="setActiveStatus('borrowed')">Đang mượn</div>
                    <div class="status-item" id="returned" onclick="setActiveStatus('returned')">Đã trả</div>
                    <div class="status-item" id="overdue" onclick="setActiveStatus('overdue')">Quá hạn</div>
                </div>
                
              

              
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Họ và tên</th>
                            <th scope="col">Mã sinh viên</th>
                            <th scope="col">Ngày mượn</th>
                            <th scope="col">Ngày trả</th>
                            <th scope="col">Mã sách</th>
                            <th scope="col">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody id="phieuMuons">
                        <!-- Data will be populated here -->
                    </tbody>
                </table>
                <div id="pagination" >
                    <!-- Các nút phân trang sẽ hiển thị ở đây -->
                </div>
            </div>
        </main>
        <!-- Thêm liên kết đến Bootstrap JS và Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-VP//xEx+0w8F27cr1FwXkR7B6gktgA3bl5n3gH4FnQ3Edyty5hvf0qEYb9RgyVV" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0FF9FJdXw7nxhFf6X9gGvOtxTrN4WZp9C8wtvMTeD3gb6zI" crossorigin="anonymous"></script>
    </section>
    <footer>
        <p>&copy; 2025 Quản lý Thư viện</p>
    </footer>
    <script>
        // Lấy danh sách phiếu mượn từ API
        let currentPage = 1; // Trang hiện tại
        const itemsPerPage = 10; // Số mục mỗi trang

        fetch('http://quanlythuvien.zapto.org/api_phieu_muon.php?action=get_phieu_muon')
            .then(response => response.json()) // Giả sử API trả về JSON
            .then(data => {
                const tbody = document.getElementById('phieuMuons');
                const pagination = document.getElementById('pagination'); // Thêm phần tử để hiển thị phân trang
                // Kiểm tra dữ liệu trả về
                if (data.data && Array.isArray(data.data)) {
                    // Tính toán số trang
                    const totalItems = data.data.length;
                    const totalPages = Math.ceil(totalItems / itemsPerPage);

                    function renderTable(page) {
                        tbody.innerHTML = ''; // Xóa nội dung bảng trước khi thêm dữ liệu mới
                        const startIndex = (page - 1) * itemsPerPage;
                        const endIndex = Math.min(startIndex + itemsPerPage, totalItems);

                        // Duyệt qua danh sách và tạo các dòng cho bảng
                        for (let i = startIndex; i < endIndex; i++) {
                            const phieu = data.data[i];
                            let statusText = '';
                            let statusColor = ''; // Biến để lưu màu sắc

                            switch (phieu.status_book) {
                                case 'returned':
                                    statusText = 'Đã trả';
                                    statusColor = 'green'; 
                                    break;
                                case 'overdue':
                                    statusText = 'Quá hạn';
                                    statusColor = 'red'; 
                                    break;
                                case 'borrowed':
                                    statusText = 'Đang mượn';
                                    statusColor = 'blue'; 
                                    break;
                                default:
                                    statusText = 'Chưa xác định';
                                    statusColor = 'gray'; // Màu xám nếu không xác định
                            }

                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <th scope="row">${i + 1}</th>
                                <td>${phieu.full_name}</td>
                                <td>${phieu.member_id}</td>
                                <td>${phieu.borrow_date}</td>
                                <td>${phieu.return_date}</td>
                                <td>${phieu.book_title}</td>
                                <td style="color: ${statusColor}; font-weight: bold;">${statusText}</td> <!-- Áp dụng màu sắc và in đậm -->
                            `;
                            tbody.appendChild(row);
                        }
                    }

                    // Hiển thị các nút phân trang
                    function renderPagination() {
                        pagination.innerHTML = ''; // Xóa các nút phân trang hiện tại
                        for (let page = 1; page <= totalPages; page++) {
                            const pageBtn = document.createElement('button');
                            pageBtn.textContent = page;
                            pageBtn.classList.add('btn', 'btn-primary', 'mx-1');
                            if (page === currentPage) {
                                pageBtn.classList.add('active'); // Đánh dấu trang hiện tại
                            }
                            pageBtn.addEventListener('click', () => {
                                currentPage = page;
                                renderTable(currentPage); // Cập nhật bảng với dữ liệu của trang đã chọn
                                renderPagination(); // Cập nhật phân trang
                            });
                            pagination.appendChild(pageBtn);
                        }
                    }

                    renderTable(currentPage); // Hiển thị dữ liệu của trang đầu tiên
                    renderPagination(); // Hiển thị các nút phân trang
                } else {
                    // Nếu không có dữ liệu hoặc không phải mảng, thông báo lỗi
                    tbody.innerHTML = '<tr><td colspan="7" class="text-center">Không có dữ liệu</td></tr>';
                }
            }).catch(error => {
                console.error('Lỗi khi lấy dữ liệu:', error);
                const tbody = document.getElementById('phieuMuons');
                tbody.innerHTML = '<tr><td colspan="7" class="text-center">Có lỗi xảy ra, không thể tải dữ liệu.</td></tr>';
            });
            

        function setActiveStatus(status) {
            // Xóa class active khỏi tất cả các trạng thái
            document.querySelectorAll('.status-item').forEach(item => {
                item.classList.remove('active');
            });

            // Thêm class active cho trạng thái được click
            document.getElementById(status).classList.add('active');

            // Gọi API với tham số trạng thái đã chọn
            fetchData(status);
        }

        function onchane_search(search){
            let apiUrl = `http://quanlythuvien.zapto.org/api_phieu_muon.php?action=search`;
            // Kiểm tra trạng thái và thêm tham số vào URL
            if (search !== '') {
                apiUrl += `&search=${search}`;
            }else{
                apiUrl = 'http://quanlythuvien.zapto.org/api_phieu_muon.php?action=get_phieu_muon'
            }

            fetch(apiUrl)
            .then(response => response.json()) // Giả sử API trả về JSON
            .then(data => {
                const tbody = document.getElementById('phieuMuons');
                const pagination = document.getElementById('pagination'); // Thêm phần tử để hiển thị phân trang
                // Kiểm tra dữ liệu trả về
                if (data.data && Array.isArray(data.data)) {
                    // Tính toán số trang
                    const totalItems = data.data.length;
                    const totalPages = Math.ceil(totalItems / itemsPerPage);

                    function renderTable(page) {
                        tbody.innerHTML = ''; // Xóa nội dung bảng trước khi thêm dữ liệu mới
                        const startIndex = (page - 1) * itemsPerPage;
                        const endIndex = Math.min(startIndex + itemsPerPage, totalItems);

                        // Duyệt qua danh sách và tạo các dòng cho bảng
                        for (let i = startIndex; i < endIndex; i++) {
                            const phieu = data.data[i];
                            let statusText = '';
                            let statusColor = ''; // Biến để lưu màu sắc

                            switch (phieu.status_book) {
                                case 'returned':
                                    statusText = 'Đã trả';
                                    statusColor = 'green';
                                    break;
                                case 'overdue':
                                    statusText = 'Quá hạn';
                                    statusColor = 'red'; 
                                    break;
                                case 'borrowed':
                                    statusText = 'Đang mượn';
                                    statusColor = 'blue';
                                    break;
                                default:
                                    statusText = 'Chưa xác định';
                                    statusColor = 'gray'; 
                            }

                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <th scope="row">${i + 1}</th>
                                <td>${phieu.full_name}</td>
                                <td>${phieu.member_id}</td>
                                <td>${phieu.borrow_date}</td>
                                <td>${phieu.return_date}</td>
                                <td>${phieu.book_title}</td>
                                <td style="color: ${statusColor}; font-weight: bold;">${statusText}</td> <!-- Áp dụng màu sắc và in đậm -->
                            `;
                            tbody.appendChild(row);
                        }
                    }

                    // Hiển thị các nút phân trang
                    function renderPagination() {
                        pagination.innerHTML = ''; // Xóa các nút phân trang hiện tại
                        for (let page = 1; page <= totalPages; page++) {
                            const pageBtn = document.createElement('button');
                            pageBtn.textContent = page;
                            pageBtn.classList.add('btn', 'btn-primary', 'mx-1');
                            if (page === currentPage) {
                                pageBtn.classList.add('active'); // Đánh dấu trang hiện tại
                            }
                            pageBtn.addEventListener('click', () => {
                                currentPage = page;
                                renderTable(currentPage); // Cập nhật bảng với dữ liệu của trang đã chọn
                                renderPagination(); // Cập nhật phân trang
                            });
                            pagination.appendChild(pageBtn);
                        }
                    }

                    renderTable(currentPage); // Hiển thị dữ liệu của trang đầu tiên
                    renderPagination(); // Hiển thị các nút phân trang
                } else {
                    // Nếu không có dữ liệu hoặc không phải mảng, thông báo lỗi
                    tbody.innerHTML = '<tr><td colspan="7" class="text-center">Không có dữ liệu</td></tr>';
                }
            }).catch(error => {
                console.error('Lỗi khi lấy dữ liệu:', error);
                const tbody = document.getElementById('phieuMuons');
                tbody.innerHTML = '<tr><td colspan="7" class="text-center">Có lỗi xảy ra, không thể tải dữ liệu.</td></tr>';
            });
        }    


        //hàm fetch
        function fetchData(status) {
            let apiUrl = `http://quanlythuvien.zapto.org/api_phieu_muon.php?action=fillter`;

            // Kiểm tra trạng thái và thêm tham số vào URL
            if (status !== 'all') {
                apiUrl += `&status=${status}`;
            }else{
                apiUrl = 'http://quanlythuvien.zapto.org/api_phieu_muon.php?action=get_phieu_muon'
            }

            fetch(apiUrl)
            .then(response => response.json()) // Giả sử API trả về JSON
            .then(data => {
                const tbody = document.getElementById('phieuMuons');
                const pagination = document.getElementById('pagination'); // Thêm phần tử để hiển thị phân trang
                // Kiểm tra dữ liệu trả về
                if (data.data && Array.isArray(data.data)) {
                    // Tính toán số trang
                    const totalItems = data.data.length;
                    const totalPages = Math.ceil(totalItems / itemsPerPage);

                    function renderTable(page) {
                        tbody.innerHTML = ''; // Xóa nội dung bảng trước khi thêm dữ liệu mới
                        const startIndex = (page - 1) * itemsPerPage;
                        const endIndex = Math.min(startIndex + itemsPerPage, totalItems);

                        // Duyệt qua danh sách và tạo các dòng cho bảng
                        for (let i = startIndex; i < endIndex; i++) {
                            const phieu = data.data[i];
                            let statusText = '';
                            let statusColor = ''; // Biến để lưu màu sắc

                            switch (phieu.status_book) {
                                case 'returned':
                                    statusText = 'Đã trả';
                                    statusColor = 'green'; // Màu xanh lá
                                    break;
                                case 'overdue':
                                    statusText = 'Quá hạn';
                                    statusColor = 'red'; // Màu đỏ
                                    break;
                                case 'borrowed':
                                    statusText = 'Đang mượn';
                                    statusColor = 'blue';
                                    break;
                                default:
                                    statusText = 'Chưa xác định';
                                    statusColor = 'gray'; // Màu xám nếu không xác định
                            }

                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <th scope="row">${i + 1}</th>
                                <td>${phieu.full_name}</td>
                                <td>${phieu.member_id}</td>
                                <td>${phieu.borrow_date}</td>
                                <td>${phieu.return_date}</td>
                                <td>${phieu.book_title}</td>
                                <td style="color: ${statusColor}; font-weight: bold;">${statusText}</td> <!-- Áp dụng màu sắc và in đậm -->
                            `;
                            tbody.appendChild(row);
                        }
                    }

                    // Hiển thị các nút phân trang
                    function renderPagination() {
                        pagination.innerHTML = ''; // Xóa các nút phân trang hiện tại
                        for (let page = 1; page <= totalPages; page++) {
                            const pageBtn = document.createElement('button');
                            pageBtn.textContent = page;
                            pageBtn.classList.add('btn', 'btn-primary', 'mx-1');
                            if (page === currentPage) {
                                pageBtn.classList.add('active'); // Đánh dấu trang hiện tại
                            }
                            pageBtn.addEventListener('click', () => {
                                currentPage = page;
                                renderTable(currentPage); // Cập nhật bảng với dữ liệu của trang đã chọn
                                renderPagination(); // Cập nhật phân trang
                            });
                            pagination.appendChild(pageBtn);
                        }
                    }

                    renderTable(currentPage); // Hiển thị dữ liệu của trang đầu tiên
                    renderPagination(); // Hiển thị các nút phân trang
                } else {
                    // Nếu không có dữ liệu hoặc không phải mảng, thông báo lỗi
                    tbody.innerHTML = '<tr><td colspan="7" class="text-center">Không có dữ liệu</td></tr>';
                }
            }).catch(error => {
                console.error('Lỗi khi lấy dữ liệu:', error);
                const tbody = document.getElementById('phieuMuons');
                tbody.innerHTML = '<tr><td colspan="7" class="text-center">Có lỗi xảy ra, không thể tải dữ liệu.</td></tr>';
            });
        }
    </script>

</body>

</html>