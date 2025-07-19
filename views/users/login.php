<?php
require_once __DIR__ . '/../../Controllers/UserController.php';

$userController = new UserController();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $user = $userController->login($username, $password);
    if ($user) {
    session_start();
    $_SESSION['user'] = $user;
    if ($user['role'] === 'admin') {
        header('Location: ../../public/index.php');
    } else {
        header('Location: ../../public/home.php');
    }
    exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-400 to-blue-400 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-700">Login</h2>
        <?php if ($message): ?>
            <div class="mb-4 text-center text-sm text-red-600"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Username</label>
                <input type="text" name="username" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div class="mb-6">
                <label class="block mb-1 font-semibold">Password</label>
                <input type="password" name="password" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">Login</button>
        </form>
        <div class="mt-4 text-center">
            <a href="register.php" class="text-purple-600 hover:underline">Belum punya akun? Register</a>
        </div>
    </div>
</body>
</html>