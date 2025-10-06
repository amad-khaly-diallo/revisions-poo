<?php
require_once 'Product.php';
$category1 = new Category(1, "Smartphones", "Tous les smartphones", new DateTime(), new DateTime());

$product1 = new Product(
    1,
    "Super Smartphone",
    ["https://picsum.photos/200/300", "https://picsum.photos/200/301"],
    799.99,
    "A high-end smartphone with a sleek design.",
    40,
    new DateTime(),
    new DateTime(),
    $category1->getId()
);

// Afficher la catégorie du produit
echo "Product Category ID: " . $product1->getCategoryId();
