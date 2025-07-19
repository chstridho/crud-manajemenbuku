<?php

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../views/users/login.php');
    exit;
}

require_once __DIR__ . '/../Models/Product.php';

$product = new Product();
$id = $_GET['id'] ?? null;
$book = $product->getById($id);

if (!$book) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $description = $_POST['description'] ?? '';
    if ($product->update($id, $title, $author, $description)) {
        header('Location: index.php');
        exit;
    } else {
        $error = "Gagal mengedit buku.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Edit Buku</h1>
        <?php if (!empty($error)): ?>
            <div class="bg-red-200 text-red-800 px-4 py-2 rounded mb-4"><?= $error ?></div>
        <?php endif; ?>
        <form method="post" class="bg-white p-6 rounded shadow">
            <div class="mb-4">
                <label class="block mb-1">Judul</label>
                <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Penulis</label>
                <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Deskripsi</label>
                <textarea name="description" class="w-full border px-3 py-2 rounded"><?= htmlspecialchars($book['description']) ?></textarea>
            </div>
            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Update</button>
            <a href="index.php" class="ml-2 text-gray-600">Kembali</a>
        </form>
    </div>
</body>
</html>