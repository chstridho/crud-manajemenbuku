<?php
require_once __DIR__ . '/../../Controllers/UserController.php';

$userController = new UserController();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if ($userController->register($username, $password)) {
        $message = 'Registrasi berhasil! Silakan login.';
    } else {
        $message = 'Registrasi gagal. Username mungkin sudah digunakan.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-400 to-purple-400 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-purple-700">Register</h2>
        <?php if ($message): ?>
            <div class="mb-4 text-center text-sm text-red-600"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Username</label>
                <input type="text" name="username" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-purple-400" required>
            </div>
            <div class="mb-6">
                <label class="block mb-1 font-semibold">Password</label>
                <input type="password" name="password" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-purple-400" required>
            </div>
            <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded hover:bg-purple-700 transition">Register</button>
        </form>
        <div class="mt-4 text-center">
            <a href="login.php" class="text-blue-600 hover:underline">Sudah punya akun? Login</a>
        </div>
    </div>
</body>
</html>