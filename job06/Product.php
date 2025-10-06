<?php 

require_once 'config.php';

class Product {
    private $id;
    private $name;
    private $photos;
    private $price;
    private $description;
    private $quantity;
    private $createdAt;
    private $updatedAt;
    private $category_id;

    public function __construct($id = null, $name = 'unknown', $photos = ["https://picsum.photos/200/300"], $price = 0.0, $description = 'No description', $quantity = 0, $createdAt = new DateTime(), $updatedAt = new DateTime(), $category_id = null)
    {
        $this -> id = $id ?? time();
        $this -> name = $name;
        $this -> photos = $photos;
        $this -> price = $price;
        $this -> description = $description;
        $this -> quantity = $quantity;
        $this -> createdAt = $createdAt;
        $this -> updatedAt = $updatedAt;
        $this -> category_id = $category_id;
    }
    // product id
    public function getId(){
        return $this->id;
    }
    public function setId($newId){
        $this->id = $newId;
    }
    // product name
    public function getName(){
        return $this -> name;
    }
    public function setName($name){
        $this -> name = $name;
    }
    // product photos
    public function getPhotos(){
        return $this -> photos;
    }
    public function setPhotos($photos) {
        $this -> photos = $photos;
    }
    // product price
    public function getPrice(){
        return $this -> price;  
    }
    public function setPrice($price){
        $this -> price = $price;
    }
    // product description
    public function getDescription(){
        return $this -> description;
    }
    public function setDescription($description){
        $this -> description = $description;
    }
    // product quantity
    public function getQuantity(){
        return $this -> quantity;
    }
    public function setQuantity($quantity){
        $this -> quantity = $quantity;
    }
    // product created at
    public function getCreatedAt(){
        return $this -> createdAt;
    }
    public function setCreatedAt($createdAt){
        $this -> createdAt = $createdAt;
    }
    // product updated at
    public function getUpdatedAt(){
        return $this -> updatedAt;
    }
    public function setUpdatedAt($updatedAt){
        $this -> updatedAt = $updatedAt;
    }
    // product category id
    public function getCategoryId(){
        return $this -> category_id;
    }
    public function setCategoryId($category_id){
        $this -> category_id = $category_id;
    }

    public function getCategory() {
        if ($this->category_id === null) {
            return null;
        }

        $sql = "SELECT * FROM category WHERE id = :category_id";
        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
        $stmt->execute();
        $categoryData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($categoryData) {
            return new Category(
                $categoryData['id'],
                $categoryData['name'],
                $categoryData['description'],
                new DateTime($categoryData['created_at']),
                new DateTime($categoryData['updated_at'])
            );
        }

        return null;
    }
    
}


class Category {
    private $id;
    private $name;
    private $description;
    private $createdAt;
    private $updatedAt;

    public function __construct($id = null, $name = 'unknown', $description = 'No description', $createdAt = new DateTime(), $updatedAt = new DateTime()) {
        $this->id = $id ?? time();
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getProducts() {
        $sql = "SELECT * FROM product WHERE category_id = :category_id";
        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':category_id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        $productsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = [];
        foreach ($productsData as $productData) {
            $products[] = new Product(
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
        }

        return $products;
    }

    // ----- Getters -----
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    public function getCreatedAt() { return $this->createdAt; }
    public function getUpdatedAt() { return $this->updatedAt; }

    // ----- Setters -----
    public function setId($id) { $this->id = $id; }
    public function setName($name) { $this->name = $name; }
    public function setDescription($description) { $this->description = $description; }
    public function setCreatedAt($createdAt) { $this->createdAt = $createdAt; }
    public function setUpdatedAt($updatedAt) { $this->updatedAt = $updatedAt; }
}
 