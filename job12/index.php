<?php
require_once 'Classe.php'; // ton fichier principal contenant Product, Clothing, Electronic, Category, ConnectDB

// --- Exemple 1 : Créer un vêtement ---
$tshirt = new Clothing(
    null,                       
    "T-shirt Nike",             
    ["https://picsum.photos/200/300", "https://picsum.photos/200/300"], 
    29.99,                      
    "T-shirt de sport confortable", 
    100,                        
    null,                       
    null,                       
    1,                          
    "L",                        
    "Bleu",                     
    "Sport",                     
    5                           
);

// Enregistrer en BDD
$newTshirt = $tshirt->create();

// Affichage initial
// echo "<h2>Vêtement créé</h2>";
// echo "<strong>Nom :</strong> " . htmlspecialchars($newTshirt->getName()) . "<br>";
// echo "<strong>Taille :</strong> " . htmlspecialchars($newTshirt-> getSize()) . "<br>";
// echo "<strong>Couleur :</strong> " . htmlspecialchars($newTshirt->getColor()) . "<br>";
// echo "<strong>Type :</strong> " . htmlspecialchars($newTshirt->getType()) . "<br>";
// echo "<strong>Prix :</strong> $" . number_format($newTshirt->getPrice(), 2) . "<br>";
// echo "<strong>Quantité :</strong> " . $newTshirt->getQuantity() . "<br>";

// // Afficher les photos
// echo "<h3>Photos :</h3>";
// foreach ($newTshirt->getPhotos() as $photo) {
//     echo "<img src='" . htmlspecialchars($photo) . "' alt='Photo produit' style='width:150px;margin:5px;'>";
// }

// --- Exemple 2 : Créer un produit électronique ---
$phone = new Electronic(
    null,                       // id
    "iPhone 15",                // name
    ["https://picsum.photos/200/300", "https://picsum.photos/200/300"], // photos
    1200.00,                    // price
    "Dernier modèle Apple",     // description
    20,                         // quantity
    null,                       // createdAt
    null,                       // updatedAt
    2,                          // category_id
    "Apple",                    // brand
    24                          // warranty_fee (mois)
);

// Enregistrer en BDD
//$newPhone = $phone->create();

// Affichage
// echo "<h2>Produit électronique créé</h2>";
// echo "<strong>Nom :</strong> " . htmlspecialchars($newPhone->getName()) . "<br>";
// echo "<strong>Marque :</strong> " . htmlspecialchars($newPhone->getBrand()) . "<br>";
// echo "<strong>Garantie :</strong> " . $newPhone->getWarrantyFee() . " mois<br>";
// echo "<strong>Prix :</strong> $" . number_format($newPhone->getPrice(), 2) . "<br>";
// echo "<strong>Quantité :</strong> " . $newPhone->getQuantity() . "<br>";

// Afficher les photos
// echo "<h3>Photos :</h3>";
// foreach ($newPhone->getPhotos() as $photo) {
//     echo "<img src='" . htmlspecialchars($photo) . "' alt='Photo produit' style='width:150px;margin:5px;'>";
// }

echo '<pre>';
print_r($tshirt->findAll());
print_r($phone->findAll());
echo '</pre>';