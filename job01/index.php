<?php 
require_once 'Product.php';

$product1 = new Product(1, "Smartphone", ["https://picsum.photos/200/300"], 699.99, "A high-end smartphone with a sleek design.", 50, new DateTime(), new DateTime());

// ----- Vérification des valeurs initiales -----
echo "<h3>Valeurs initiales :</h3>";
echo "<pre>";
var_dump($product1->getId());
var_dump($product1->getName());
var_dump($product1->getPhotos());
var_dump($product1->getPrice());
var_dump($product1->getDescription());
var_dump($product1->getQuantity());
var_dump($product1->getCreatedAt());
var_dump($product1->getUpdatedAt());
echo "</pre>";

// ----- Modification via les setters -----
$product1->setName("Super Smartphone");
$product1->setPrice(799.99);
$product1->setQuantity(40);
$product1->setUpdatedAt(new DateTime()); // simulate update

// ----- Vérification après modification -----
echo "<h3>Valeurs après modification :</h3>";
echo "<pre>";
var_dump($product1->getName());
var_dump($product1->getPrice());
var_dump($product1->getQuantity());
var_dump($product1->getUpdatedAt());
echo "</pre>";