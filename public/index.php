<?php

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../views/users/login.php');
    exit;
}
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: home.php');
    exit;
}

require_once __DIR__ . '/../Models/Product.php';

$product = new Product();

// Proses search
$search = $_GET['search'] ?? '';
if ($search) {
    $books = array_filter($product->getAll(), function ($book) use ($search) {
        return stripos($book['title'], $search) !== false || stripos($book['author'], $search) !== false;
    });
} else {
    $books = $product->getAll();
}

$sort = $_GET['sort'] ?? '';
if ($sort && !empty($books)) {
    usort($books, function($a, $b) use ($sort) {
        // Pastikan field ada, jika tidak, fallback ke string kosong/0
        $valA = $a[$sort] ?? '';
        $valB = $b[$sort] ?? '';
        // Untuk rating dan year, urutkan numerik
        if (in_array($sort, ['rating', 'year'])) {
            return floatval($valB) <=> floatval($valA); // Descending
        }
        return strcasecmp($valA, $valB); // Ascending
    });
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manajemen Buku - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .search-animated:focus-within {
            box-shadow: 0 0 0 3px #4ade80;
            transition: box-shadow 0.3s;
        }

        .search-animated input:focus {
            border-color: #22c55e;
            background: #f0fdf4;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="search"]');
            const rows = document.querySelectorAll('tbody tr');
            searchInput.addEventListener('input', function() {
                const keyword = this.value.toLowerCase();
                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    row.style.display = text.includes(keyword) ? '' : 'none';
                });
            });
        });
    </script>
</head>

<body class="bg-gradient-to-br from-green-100 to-green-200 min-h-screen">
    <div class="container mx-auto px-4 py-10">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-extrabold text-green-900 tracking-tight">Manajemen Buku</h1>
            <a href="create.php" class="flex items-center gap-2 bg-green-700 hover:bg-green-800 text-white px-5 py-2 rounded-lg shadow transition font-semibold">
                <i class="fa fa-plus"></i> Tambah Buku
            </a>
        </div>
        <form method="get" class="mb-6 flex" onsubmit="return false;">
            <div class="relative w-full max-w-xs search-animated rounded-lg shadow transition">
                <input
                    type="text"
                    name="search"
                    value="<?= htmlspecialchars($search) ?>"
                    placeholder="Cari judul atau penulis..."
                    class="w-full pl-10 pr-4 py-2 rounded-lg border border-green-300 focus:outline-none focus:ring-2 focus:ring-green-400 text-green-900 text-base transition"
                    autocomplete="off">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-green-400 text-lg pointer-events-none">
                    <i class="fa fa-search"></i>
                </span>
                <?php if ($search): ?>
                    <a href="index.php" class="absolute right-3 top-1/2 -translate-y-1/2 text-green-400 hover:text-green-700 transition" title="Reset">
                        <i class="fa fa-times-circle"></i>
                    </a>
                <?php endif; ?>
            </div>
            <select name="sort" onchange="this.form.submit()" class="ml-5 px-4 py-2 rounded-lg border border-green-300 bg-white text-green-900 shadow focus:outline-none focus:ring-2 focus:ring-green-400">
                <option value="">Urutkan Berdasarkan</option>
                <option value="title" <?= ($_GET['sort'] ?? '') === 'title' ? 'selected' : '' ?>>Judul</option>
                <option value="author" <?= ($_GET['sort'] ?? '') === 'author' ? 'selected' : '' ?>>Penulis</option>
                <option value="category" <?= ($_GET['sort'] ?? '') === 'category' ? 'selected' : '' ?>>Kategori</option>
                <option value="genre" <?= ($_GET['sort'] ?? '') === 'genre' ? 'selected' : '' ?>>Genre</option>
                <option value="year" <?= ($_GET['sort'] ?? '') === 'year' ? 'selected' : '' ?>>Tahun Terbit</option>
                <option value="rating" <?= ($_GET['sort'] ?? '') === 'rating' ? 'selected' : '' ?>>Rating</option>
            </select>
        </form>
        <div class="overflow-x-auto rounded-lg shadow-lg bg-white">
            <table class="min-w-full divide-y divide-green-200">
                <thead class="bg-green-50">
                    <tr>
                        <th class="py-3 px-4 text-left font-semibold text-green-800">Cover</th>
                        <th class="py-3 px-4 text-left font-semibold text-green-800">Judul</th>
                        <th class="py-3 px-4 text-left font-semibold text-green-800">Penulis</th>
                        <th class="py-3 px-4 text-left font-semibold text-green-800">Deskripsi</th>
                        <th class="py-3 px-4 text-center font-semibold text-green-800">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-green-100">
                    <?php foreach ($books as $book): ?>
                        <tr class="hover:bg-green-50 transition">
                            <td class="py-3 px-4">
                                <?php if ($book['cover']): ?>
                                    <img src="assets/<?= htmlspecialchars($book['cover']) ?>" alt="Cover" class="w-16 h-24 object-cover rounded shadow border border-green-200">
                                <?php else: ?>
                                    <span class="text-gray-400 italic">Tidak ada</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-4 font-semibold text-green-900">
                                <a href="detail.php?id=<?= $book['id'] ?>" class="hover:underline"><?= htmlspecialchars($book['title']) ?></a>
                            </td>
                            <td class="py-3 px-4"><?= htmlspecialchars($book['author']) ?></td>
                            <td class="py-3 px-4"><?= htmlspecialchars($book['description']) ?></td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex flex-col items-start gap-2">
                                    <a href="edit.php?id=<?= $book['id'] ?>" class="flex items-center gap-1 text-yellow-700 hover:text-yellow-900 font-medium" title="Edit">
                                        <i class="fa fa-pen-to-square"></i> <span>Edit</span>
                                    </a>
                                    <a href="delete.php?id=<?= $book['id'] ?>" class="flex items-center gap-1 text-red-700 hover:text-red-900 font-medium" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fa fa-trash"></i> <span>Hapus</span>
                                    </a>
                                    <a href="detail.php?id=<?= $book['id'] ?>" class="flex items-center gap-1 text-green-700 hover:text-green-900 font-medium" title="Detail">
                                        <i class="fa fa-eye"></i> <span>Lihat Detail</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    <?php if (empty($books)): ?>
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-400">Belum ada buku.</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>