<?php

namespace Khalyamad\Job15;

require_once __DIR__ . '/../config/config.php';

use Khalyamad\Job15\Abstract\AbstractProduct;
use Khalyamad\Job15\config\ConnectDB;
use Khalyamad\Job15\EntityCollection;



use DateTime;

class Category
{
    private ?int $id;
    private string $name;
    private string $description;
    private DateTime $createdAt;
    private DateTime $updatedAt;
    private EntityCollection $products;

    public function __construct(
        ?int $id = null,
        string $name = 'unknown',
        string $description = 'No description',
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = $createdAt ?? new DateTime();
        $this->updatedAt = $updatedAt ?? new DateTime();
        $this->products = new EntityCollection();
    }

    public function getProducts(): EntityCollection
    {
        if ($this->id === null) {
            return $this->products;
        }

        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare("SELECT * FROM product WHERE category_id = :id");
        $stmt->execute([':id' => $this->id]);
        $all = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $this->products = new EntityCollection();

        foreach ($all as $data) {
            $photos = $data['photos'] ?? '[]';
            $photosArray = json_decode($photos, true);
            if (!is_array($photosArray)) {
                $photosArray = [];
            }

            $product = new class(
                $data['name'],           // string
                $photosArray,            // array
                (float)$data['price'],   // float
                $data['description'],    // string
                (int)$data['quantity'],  // int
                new DateTime($data['created_at']), // DateTime
                new DateTime($data['updated_at']), // DateTime
                (int)$data['category_id']          // int
            ) extends AbstractProduct {
                public function create(): static
                {
                    return $this;
                }
                public function update(): bool
                {
                    return true;
                }
                public function findOneById(int $id): ?static
                {
                    return $this;
                }
                public function findAll(): array
                {
                    return [$this];
                }
            };

            $this->products->add($product);
        }

        return $this->products;
    }
    public function getName(): string
    {
        return $this->name;
    }
}
