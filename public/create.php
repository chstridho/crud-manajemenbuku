<?php

require_once __DIR__ . '/../Models/Product.php';

$product = new Product();

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: home.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $description = $_POST['description'] ?? '';
    $cover = null;

    if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);
        $cover = uniqid('cover_') . '.' . $ext;
        move_uploaded_file($_FILES['cover']['tmp_name'], __DIR__ . '/assets/' . $cover);
    }

    if ($product->create($title, $author, $description, $cover)) {
        header('Location: index.php');
        exit;
    } else {
        $error = "Gagal menambah buku.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tambah Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Tambah Buku</h1>
        <?php if (!empty($error)): ?>
            <div class="bg-red-200 text-red-800 px-4 py-2 rounded mb-4"><?= $error ?></div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            <div class="mb-4">
                <label class="block mb-1">Judul</label>
                <input type="text" name="title" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Penulis</label>
                <input type="text" name="author" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Deskripsi</label>
                <textarea name="description" class="w-full border px-3 py-2 rounded"></textarea>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Cover Buku</label>
                <input type="file" name="cover" accept="image/*" class="w-full border px-3 py-2 rounded">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            <a href="index.php" class="ml-2 text-gray-600">Kembali</a>
        </form>
    </div>
</body>

</html>