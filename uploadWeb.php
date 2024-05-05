<?php
// Kiểm tra xem người dùng đã tải lên tệp hay chưa
if(isset($_FILES['file'])) {
    $upload_directory = 'uploads/'; // Thư mục để lưu trữ tệp tải lên
    $file_name = $_FILES['file']['name']; // Lấy tên của tệp
    $file_type = $_FILES['file']['type']; // Lấy loại của tệp
    $file_size = $_FILES['file']['size']; // Lấy kích thước của tệp
    $file_tmp_name = $_FILES['file']['tmp_name']; // Đường dẫn tạm thời của tệp

    // Di chuyển tệp tải lên vào thư mục uploads
    move_uploaded_file($file_tmp_name, $upload_directory.$file_name);
}

// Lấy danh sách tệp trong thư mục uploads
$files = scandir('uploads/');

// Loại bỏ "." và ".." khỏi danh sách
$files = array_diff($files, array('.', '..'));

// Sắp xếp danh sách tệp theo tên tệp hoặc ngày tải lên
if(isset($_GET['sort']) && $_GET['sort'] == 'date') {
    usort($files, function($a, $b) {
        return filemtime('uploads/'.$a) < filemtime('uploads/'.$b);
    });
} else {
    sort($files);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload and Display</title>
</head>
<body>
    <h1>File Upload and Display</h1>

    <!-- Form để tải lên tệp -->
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <input type="submit" value="Upload">
    </form>

    <br>

    <!-- Bảng hiển thị thông tin chi tiết của các tệp đã tải lên -->
    <table border="1">
        <tr>
            <th><a href="?sort=name">Tên tệp</a></th>
            <th>Loại</th>
            <th><a href="?sort=date">Ngày tải lên</a></th>
            <th>Kích thước</th>
        </tr>
        <?php foreach($files as $file): ?>
            <tr>
                <td><?= $file ?></td>
                <td><?= mime_content_type('uploads/'.$file) ?></td>
                <td><?= date("Y-m-d H:i:s", filemtime('uploads/'.$file)) ?></td>
                <td><?= filesize('uploads/'.$file) ?> bytes</td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
