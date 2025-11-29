<?php
$flowers = [
    [
        'name' => 'Đỗ Quyên',
        'description' => 'Mang vẻ đẹp kiêu sa, hương thơm nồng nàn, thích hợp trồng cổng ngõ, hàng rào.',
        'image' => 'images/doquyen.jpg'
    ],
    [
        'name' => 'Hải Dương',
        'description' => 'Loài hoa rực rỡ, dễ trồng, chịu hạn tốt, nở rộ vào mùa hè tạo bóng mát.',
        'image' => 'images/haiduong.jpg'
    ],
    [
        'name' => 'Mai',
        'description' => 'Nhỏ nhắn, xinh xắn, nở rộ vào khoảng 10 giờ sáng, rất dễ chăm sóc.',
        'image' => 'images/mai.jpg'
    ],
    [
        'name' => 'Tường Vy',
        'description' => 'Màu sắc đa dạng, sai hoa, thường được trồng trong chậu treo rủ xuống rất đẹp.',
        'image' => 'images/tuongvy.jpg'
    ]
];

$view = isset($_GET['view']) ? $_GET['view'] : 'guest';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sắc Hoa Xuân Hè - Giao Diện Mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #ff9a9e;
            --secondary-color: #fad0c4;
            --accent-color: #11998e;
            --bg-color: #fff9f9;
        }

        body { 
            background-color: var(--bg-color); 
            font-family: 'Nunito', sans-serif; 
            color: #555;
        }

        /* Header Style */
        .hero-section {
            background: linear-gradient(120deg, #a1c4fd 0%, #c2e9fb 100%); /* Blue gradient */
            background: linear-gradient(to right, #ffecd2 0%, #fcb69f 100%); /* Peach gradient - dùng cái này cho ấm */
            padding: 60px 0 80px;
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(255, 154, 158, 0.2);
        }

        .hero-title {
            font-family: 'Dancing Script', cursive;
            font-size: 3.5rem;
            color: #d63384;
            text-shadow: 2px 2px 0px #fff;
        }

        /* Navigation Bar */
        .control-bar {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            padding: 15px 25px;
            margin-top: -60px; /* Đẩy lên đè vào header */
            position: relative;
            z-index: 10;
        }

        /* Guest Card Style */
        .flower-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            background: white;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .flower-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(255, 154, 158, 0.3);
        }

        .card-img-top {
            height: 220px;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .flower-card:hover .card-img-top {
            transform: scale(1.05);
        }

        .card-body { padding: 20px; }
        
        .flower-name {
            font-weight: 700;
            color: #d63384;
            font-size: 1.25rem;
        }

        .btn-flower {
            background-image: linear-gradient(to right, #ff9a9e 0%, #fecfef 99%, #fecfef 100%);
            border: none;
            color: white;
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
        }
        .btn-flower:hover {
            background-image: linear-gradient(to right, #fecfef 0%, #ff9a9e 100%);
            color: white;
        }

        /* Admin Table Style */
        .admin-panel {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            overflow: hidden;
            border: none;
        }

        .admin-header {
            background: #fff;
            padding: 20px 30px;
            border-bottom: 2px solid #f0f0f0;
        }

        .table-custom thead th {
            background-color: #f8f9fa;
            color: #666;
            font-weight: 700;
            border: none;
            text-transform: uppercase;
            font-size: 0.85rem;
            padding: 15px;
        }

        .table-custom tbody td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }
        
        .action-btn {
            border-radius: 8px;
            padding: 5px 12px;
            font-size: 0.85rem;
            margin: 0 2px;
        }

        /* Footer */
        footer { font-size: 0.9rem; color: #999; }
    </style>
</head>
<body>

    <div class="hero-section text-center">
        <div class="container">
            <h1 class="hero-title">🌸 Sắc Hoa Xuân Hè 🌸</h1>
            <p class="lead text-muted fw-bold">Tuyển tập những loài hoa rực rỡ nhất cho khu vườn của bạn</p>
        </div>
    </div>

    <div class="container mb-5">
        
        <div class="control-bar d-flex justify-content-between align-items-center mb-5">
            <div class="d-flex align-items-center">
                <span class="text-muted me-2">Chế độ đang xem:</span>
                <?php if($view == 'admin'): ?>
                    <span class="badge rounded-pill bg-danger px-3 py-2"><i class="bi bi-shield-lock-fill"></i> Quản Trị Viên</span>
                <?php else: ?>
                    <span class="badge rounded-pill bg-success px-3 py-2"><i class="bi bi-person-fill"></i> Khách Xem</span>
                <?php endif; ?>
            </div>

            <div class="nav-buttons">
                <a href="?view=guest" class="btn <?php echo $view == 'guest' ? 'btn-success text-white' : 'btn-outline-secondary'; ?> rounded-pill me-2">
                    <i class="bi bi-grid-fill"></i> Gallery
                </a>
                <a href="?view=admin" class="btn <?php echo $view == 'admin' ? 'btn-danger text-white' : 'btn-outline-secondary'; ?> rounded-pill">
                    <i class="bi bi-list-task"></i> Quản Lý
                </a>
            </div>
        </div>

        <?php if ($view == 'guest'): ?>
            <div class="row g-4">
                <?php foreach ($flowers as $flower): ?>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="card flower-card h-100">
                            <div class="position-relative overflow-hidden">
                                <img src="<?php echo $flower['image']; ?>" class="card-img-top" alt="<?php echo $flower['name']; ?>">
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-white text-dark shadow-sm">Hot</span>
                                </div>
                            </div>
                            <div class="card-body text-center d-flex flex-column">
                                <h5 class="flower-name mb-2"><?php echo $flower['name']; ?></h5>
                                <p class="card-text text-muted small flex-grow-1"><?php echo $flower['description']; ?></p>
                                <div class="mt-3">
                                    <button class="btn btn-flower w-100 shadow-sm">
                                        Xem chi tiết <i class="bi bi-arrow-right-short"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        
        <?php elseif ($view == 'admin'): ?>
            <div class="card admin-panel">
                <div class="admin-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0 fw-bold text-dark">Danh Sách Hoa</h4>
                        <small class="text-muted">Quản lý kho dữ liệu hiển thị</small>
                    </div>
                    <button class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="bi bi-plus-lg"></i> Thêm mới
                    </button>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-custom table-hover mb-0">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center" width="5%">#</th>
                                <th scope="col" width="10%">Hình ảnh</th>
                                <th scope="col" width="20%">Tên loài hoa</th>
                                <th scope="col">Mô tả ngắn</th>
                                <th scope="col" class="text-center" width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($flowers as $index => $flower): ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted"><?php echo $index + 1; ?></td>
                                    <td>
                                        <img src="<?php echo $flower['image']; ?>" class="rounded-3 shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark"><?php echo $flower['name']; ?></span>
                                    </td>
                                    <td class="text-muted small"><?php echo $flower['description']; ?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-primary action-btn" title="Sửa"><i class="bi bi-pencil-square"></i></button>
                                        <button type="button" class="btn btn-outline-danger action-btn" title="Xóa"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white border-top-0 py-3 text-end">
                    <span class="text-muted small">Tổng cộng: <strong><?php echo count($flowers); ?></strong> loài hoa</span>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <footer class="text-center py-5 mt-5 border-top bg-white">
        <p class="mb-0 text-muted">&copy; 2025 Thế Giới Các Loài Hoa. Designed with <span class="text-danger">❤</span> for Spring.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>