<?php
namespace Khalyamad\Job15;
use Khalyamad\Job15\Interface\EntityCollectionInterface;
use Khalyamad\Job15\Interface\EntityInterface;

class EntityCollection implements EntityCollectionInterface
{
    private array $entities = [];

    public function add(EntityInterface $entity): self
    {
        $this->entities[] = $entity;
        return $this;
    }

    public function remove(EntityInterface $entity): self
    {
        $index = array_search($entity, $this->entities, true);
        if ($index === false) {
            throw new \InvalidArgumentException("Entity not found in collection.");
        }
        array_splice($this->entities, $index, 1);
        return $this;
    }

    public function retrieve(): self
    {
        return $this;
    }

    public function getAll(): array
    {
        return $this->entities;
    }
}