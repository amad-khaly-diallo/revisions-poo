<?php
namespace Khalyamad\Job15;
use DateTime;
use Khalyamad\Job15\Abstract\AbstractProduct;
use Khalyamad\Job15\Interface\StockableInterface;
use Khalyamad\Job15\Interface\EntityInterface;
use PDO;
use Khalyamad\Job15\config\ConnectDB;

class Clothing extends AbstractProduct implements StockableInterface, EntityInterface
{
    private string $size;
    private string $color;
    private string $type;
    private int $material_fee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }


    public function __construct(
        string $name,
        array $photos,
        float $price,
        string $description,
        int $quantity,
        ?DateTime $createdAt,
        ?DateTime $updatedAt,
        int $category_id,
        string $size,
        string $color,
        string $type,
        int $material_fee
    ) {
        parent::__construct($name, $photos, $price, $description, $quantity, $createdAt, $updatedAt, $category_id);
        $this->size = $size;
        $this->color = $color;
        $this->type = $type;
        $this->material_fee = $material_fee;
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
    public function getSize(): string { return $this->size; }
    public function getColor(): string { return $this->color; }
    public function getType(): string { return $this->type; }
    public function getMaterialFee(): int { return $this->material_fee; }

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
        $this->product_id = $this->id;
        $stmt = $pdo->prepare("INSERT INTO clothing (product_id, size, color, type, material_fee) VALUES (:product_id, :size, :color, :type, :material_fee)");
        $stmt->execute([
            ':product_id' => $this->product_id,
            ':size' => $this->size,
            ':color' => $this->color,
            ':type' => $this->type,
            ':material_fee' => $this->material_fee
        ]);
        return $this;
    }
    public function update(): bool {
        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare("UPDATE clothing SET size = :size, color = :color, type = :type, material_fee = :material_fee WHERE id = :id");
        return $stmt->execute([
            ':id' => $this->id,
            ':size' => $this->size,
            ':color' => $this->color,
            ':type' => $this->type,
            ':material_fee' => $this->material_fee
        ]);
    }
    public function findOneById(int $id): ?static {
        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare("SELECT * FROM clothing WHERE id = :id");
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
            $data['size'],
            $data['color'],
            $data['type'],
            (int)$data['material_fee']
        );
    }
    /** @return static[] */
    public function findAll(): array {
        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare("SELECT * FROM clothing");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $clothes = [];
        foreach ($data as $item) {
            $clothes[] = new static(
                (int)$item['id'],
                $item['name'],
                json_decode($item['photos'], true),
                (float)$item['price'],
                $item['description'],
                (int)$item['quantity'],
                new DateTime($item['created_at']),
                new DateTime($item['updated_at']),
                (int)$item['category_id'],
                $item['size'],
                $item['color'],
                $item['type'],
                (int)$item['material_fee']
            );
        }
        return $clothes;
    }
    
}
