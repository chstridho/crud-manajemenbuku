<?php

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../views/users/login.php');
    exit;
}

require_once __DIR__ . '/../Models/Product.php';

$product = new Product();
$id = $_GET['id'] ?? null;

if ($id) {
    $product->delete($id);
}

header('Location: index.php');
exit;