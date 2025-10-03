<?php 
require_once 'Product.php';

$product1 = new Product(1, "Smartphone", ["https://picsum.photos/200/300"], 699.99, "A high-end smartphone with a sleek design.", 50, new DateTime(), new DateTime());

// ----- Vérification des valeurs initiales -----
echo "<h3>Valeurs initiales :</h3>";
echo "<pre>";
var_dump($product1->getProductId());
var_dump($product1->getProductName());
var_dump($product1->getProductPhotos());
var_dump($product1->getProductPrice());
var_dump($product1->getProductDescription());
var_dump($product1->getProductQuantity());
var_dump($product1->getProductCreatedAt());
var_dump($product1->getProductUpdatedAt());
echo "</pre>";

// ----- Modification via les setters -----
$product1->setProductName("Super Smartphone");
$product1->setProductPrice(799.99);
$product1->setProductQuantity(40);
$product1->setProductUpdatedAt(new DateTime()); // simulate update

// ----- Vérification après modification -----
echo "<h3>Valeurs après modification :</h3>";
echo "<pre>";
var_dump($product1->getProductName());
var_dump($product1->getProductPrice());
var_dump($product1->getProductQuantity());
var_dump($product1->getProductUpdatedAt());
echo "</pre>";