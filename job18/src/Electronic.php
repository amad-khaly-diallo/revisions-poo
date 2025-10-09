<?php
namespace Khalyamad\Job15;
use PDO;
use DateTime;
use Khalyamad\Job15\Abstract\AbstractProduct;
use Khalyamad\Job15\Interface\StockableInterface;
use Khalyamad\Job15\Interface\EntityInterface;
use Khalyamad\Job15\config\ConnectDB;

class Electronic extends AbstractProduct implements StockableInterface, EntityInterface
{
    private string $brand;
    private int $warranty_fee;

    public function __construct(
        string $name,
        array $photos,
        float $price,
        string $description,
        int $quantity,
        ?DateTime $createdAt,
        ?DateTime $updatedAt,
        int $category_id,
        string $brand,
        int $warranty_fee
    ) {
        parent::__construct($name, $photos, $price, $description, $quantity, $createdAt, $updatedAt, $category_id);
        $this->brand = $brand;
        $this->warranty_fee = $warranty_fee;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    // --- Implémentation de l'interface StockableInterface ---
    public function addStocks(int $stock): self
    {
        $this->setQuantity($this->getQuantity() + $stock);
        return $this;
    }

    public function removeStocks(int $stock): self
    {
        $newQuantity = max(0, $this->getQuantity() - $stock);
        $this->setQuantity($newQuantity);
        return $this;
    }

    // --- Getters spécifiques ---
    public function getBrand(): string { return $this->brand; }
    public function getWarrantyFee(): int { return $this->warranty_fee; }

    // ----- Méthodes abstraites -----
    public function create(): static {
        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare("INSERT INTO product (name, photos, price, description, quantity, created_at, updated_at, category_id) VALUES (:name, :photos, :price, :description, :quantity, :created_at, :updated_at, :category_id)");
        $stmt->execute([
            ':name' => $this->getName(),
            ':photos' => json_encode($this->getPhotos()),
            ':price' => $this->getPrice(),
            ':description' => $this->getDescription(),
            ':quantity' => $this->getQuantity(),
            ':created_at' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            ':updated_at' => $this->getUpdatedAt()->format('Y-m-d H:i:s'),
            ':category_id' => $this->getCategoryId()
        ]);
        $this->id = (int)$pdo->lastInsertId();
        $stmt = $pdo->prepare("INSERT INTO electronic (product_id, brand, warranty_fee) VALUES (:product_id, :brand, :warranty_fee)");
        $stmt->execute([
            ':product_id' => $this->id,
            ':brand' => $this->brand,
            ':warranty_fee' => $this->warranty_fee
        ]);
        $this->product_id = $this->id;
        return $this;
    }
    public function update(): bool{
        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare("UPDATE electronic SET brand=:brand, warranty_fee=:warranty_fee WHERE id=:id");
        return $stmt->execute([
            ':brand' => $this->brand,
            ':warranty_fee' => $this->warranty_fee,
            ':id' => $this->id
        ]);
    }
    public function findOneById(int $id): ?static {
        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare("SELECT * FROM electronic WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) return null;

        return new static(
            (int)$data['id'],
            $data['name'],
            json_decode($data['photos'], true),
            (float)$data['price'],
            $data['description'],
            (int)$data['quantity'],
            new DateTime($data['created_at']),
            new DateTime($data['updated_at']),
            (int)$data['category_id'],
            $data['brand'],
            (int)$data['warranty_fee']
        );
    }
    /** @return static[] */
    public function findAll(): array {
        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->query("SELECT * FROM electronic");
        $results = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = new static(
                (int)$data['id'],
                $data['name'],
                json_decode($data['photos'], true),
                (float)$data['price'],
                $data['description'],
                (int)$data['quantity'],
                new DateTime($data['created_at']),
                new DateTime($data['updated_at']),
                (int)$data['category_id'],
                $data['brand'],
                (int)$data['warranty_fee']
            );
        }
        return $results;
    }
}
