<?php

session_start();
require_once __DIR__ . '/../Models/Product.php';

$product = new Product();
$id = $_GET['id'] ?? null;
$book = $product->getById($id);

if (!$book) {
    header('Location: index.php');
    exit;
}

// Contoh dummy jika field belum ada di database (hapus jika sudah ada di database)
$book['isbn'] = $book['isbn'] ?? '978-602-03-1234-5';
$book['category'] = $book['category'] ?? 'Filsafat';
$book['genre'] = $book['genre'] ?? 'Non-Fiksi';
$book['year'] = $book['year'] ?? '2020';
$book['rating'] = $book['rating'] ?? '4.5';
$book['synopsis'] = $book['synopsis'] ?? $book['description'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-green-50 to-green-200 min-h-screen">
    <div class="container mx-auto px-4 py-10">
        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-8 flex flex-col md:flex-row gap-8">
            <div class="flex-shrink-0 flex flex-col items-center">
                <?php if ($book['cover']): ?>
                    <img src="assets/<?= htmlspecialchars($book['cover']) ?>" alt="Cover Buku" class="w-48 h-64 object-cover rounded shadow mb-4">
                <?php else: ?>
                    <div class="w-48 h-64 bg-gray-200 flex items-center justify-center rounded mb-4 text-gray-400">Tidak ada cover</div>
                <?php endif; ?>
                <div class="mt-2 text-center">
                    <span class="inline-block bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-semibold">
                        <?= htmlspecialchars($book['category']) ?>
                    </span>
                </div>
            </div>
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-green-900 mb-2"><?= htmlspecialchars($book['title']) ?></h1>
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="inline-flex items-center gap-1 text-sm text-gray-600">
                        <i class="fa fa-user"></i> <?= htmlspecialchars($book['author']) ?>
                    </span>
                    <span class="inline-flex items-center gap-1 text-sm text-gray-600">
                        <i class="fa fa-calendar"></i> <?= htmlspecialchars($book['year']) ?>
                    </span>
                    <span class="inline-flex items-center gap-1 text-sm text-gray-600">
                        <i class="fa fa-barcode"></i> ISBN: <?= htmlspecialchars($book['isbn']) ?>
                    </span>
                    <span class="inline-flex items-center gap-1 text-sm text-gray-600">
                        <i class="fa fa-tags"></i> Genre: <?= htmlspecialchars($book['genre']) ?>
                    </span>
                    <span class="inline-flex items-center gap-1 text-sm text-yellow-600">
                        <i class="fa fa-star"></i> <?= htmlspecialchars($book['rating']) ?>/5
                    </span>
                </div>
                <div class="mb-4">
                    <h2 class="font-semibold text-green-800 mb-1">Sinopsis</h2>
                    <p class="text-gray-700"><?= nl2br(htmlspecialchars($book['synopsis'])) ?></p>
                </div>
                <div class="mb-4">
                    <h2 class="font-semibold text-green-800 mb-1">Deskripsi</h2>
                    <p class="text-gray-700"><?= nl2br(htmlspecialchars($book['description'])) ?></p>
                </div>
                <div class="flex flex-wrap gap-3 mt-6">
                    <a href="index.php" class="inline-flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow transition">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                        <a href="edit.php?id=<?= $book['id'] ?>" class="inline-flex items-center gap-1 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow transition">
                            <i class="fa fa-pen-to-square"></i> Edit Buku
                        </a>
                        <a href="delete.php?id=<?= $book['id'] ?>" onclick="return confirm('Yakin ingin menghapus buku ini?')" class="inline-flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow transition">
                            <i class="fa fa-trash"></i> Hapus Buku
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>