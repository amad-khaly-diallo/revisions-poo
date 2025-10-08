<?php
require __DIR__ . '/vendor/autoload.php';

use Khalyamad\Job15\Clothing;
use Khalyamad\Job15\Electronic;

$shirt = new Clothing(
    null,
    "T-shirt noir",
    ["https://picsum.photos/200"],
    19.99,
    "T-shirt 100% coton",
    10,
    null,
    null,
    1,
    "L",
    "Noir",
    "T-shirt",
    5
);

$phone = new Electronic(
    null,
    "Smartphone XYZ",
    ["https://picsum.photos/201"],
    499.99,
    "Smartphone avec écran HD",
    15,
    null,
    null,
    2,
    "BrandY",
    24
);

echo "<h1>Gestion des stocks</h1>";
echo "<h2>Stock initial (T-shirt) : " . $shirt->getQuantity() . "</h2>";

$shirt->addStocks(5)->removeStocks(3);

echo "<h2>Stock après opérations : " . $shirt->getQuantity() . "</h2>";

echo "<h2>Stock initial (Smartphone) : " . $phone->getQuantity() . "</h2>";

$phone->addStocks(10)->removeStocks(5);

echo "<h2>Stock après opérations : " . $phone->getQuantity() . "</h2>";
