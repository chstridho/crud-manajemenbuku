<?php

session_start();
require_once __DIR__ . '/../Models/Product.php';

$product = new Product();

// Proses search
$search = $_GET['search'] ?? '';
if ($search) {
    $books = array_filter($product->getAll(), function($book) use ($search) {
        return stripos($book['title'], $search) !== false || stripos($book['author'], $search) !== false;
    });
} else {
    $books = $product->getAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Pengunjung</title>
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
<body class="bg-gradient-to-br from-green-50 to-green-200 min-h-screen">
    <div class="container mx-auto px-4 py-10">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-green-900 mb-2">Selamat Datang di Perpustakaan Digital!</h1>
            <p class="text-green-800 text-lg">Silakan telusuri koleksi buku yang tersedia di bawah ini.</p>
        </div>
        <form method="get" class="mb-8 flex justify-center" onsubmit="return false;">
            <div class="relative w-full max-w-md search-animated rounded-lg shadow transition">
                <input
                    type="text"
                    name="search"
                    value="<?= htmlspecialchars($search) ?>"
                    placeholder="Cari judul atau penulis..."
                    class="w-full pl-12 pr-4 py-3 rounded-lg border border-green-300 focus:outline-none focus:ring-2 focus:ring-green-400 text-green-900 text-lg transition"
                    autocomplete="off"
                >
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-green-400 text-xl pointer-events-none">
                    <i class="fa fa-search"></i>
                </span>
                <?php if ($search): ?>
                    <a href="home.php" class="absolute right-4 top-1/2 -translate-y-1/2 text-green-400 hover:text-green-700 transition" title="Reset">
                        <i class="fa fa-times-circle"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>
        <div class="overflow-x-auto rounded-lg shadow-lg bg-white">
            <table class="min-w-full divide-y divide-green-200">
                <thead class="bg-green-100">
                    <tr>
                        <th class="py-3 px-4 text-left font-semibold text-green-800">Cover</th>
                        <th class="py-3 px-4 text-left font-semibold text-green-800">Judul</th>
                        <th class="py-3 px-4 text-left font-semibold text-green-800">Penulis</th>
                        <th class="py-3 px-4 text-left font-semibold text-green-800">Deskripsi</th>
                        <th class="py-3 px-4 text-center font-semibold text-green-800">Detail</th>
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
                            <td class="py-3 px-4 font-semibold text-green-900"><?= htmlspecialchars($book['title']) ?></td>
                            <td class="py-3 px-4"><?= htmlspecialchars($book['author']) ?></td>
                            <td class="py-3 px-4"><?= htmlspecialchars($book['description']) ?></td>
                            <td class="py-3 px-4 text-center">
                                <a href="detail.php?id=<?= $book['id'] ?>" class="inline-flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded shadow transition font-medium" title="Lihat Detail">
                                    <i class="fa fa-eye"></i> <span>Lihat Detail</span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    <?php if (empty($books)): ?>
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-400">Buku tidak ditemukan.</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>