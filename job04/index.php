<?php
require_once 'Product.php';
require_once 'config.php';

$sql = "SELECT * FROM product WHERE id = 17";

try {
    $db = new ConnectDB();
    $pdo = $db->connect();
    $stmt = $pdo->query($sql);
    $productData = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

// instantiate a Product object using the fetched data
$product = new Product(
    $productData['id'],
    $productData['name'],
    json_decode($productData['photos'], true),
    $productData['price'],
    $productData['description'],
    $productData['quantity'],
    new DateTime($productData['created_at']),
    new DateTime($productData['updated_at']),
    $productData['category_id']
);
// display product details
echo "<pre>";
var_dump($product->getName());
var_dump($product->getPhotos());
var_dump($product->getPrice());
var_dump($product->getDescription());
var_dump($product->getQuantity());
var_dump($product->getCreatedAt());
var_dump($product->getUpdatedAt());
var_dump($product->getCategoryId());
echo "</pre>";
