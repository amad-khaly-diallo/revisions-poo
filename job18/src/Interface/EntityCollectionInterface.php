<?php

namespace Khalyamad\Job15\Interface;


interface EntityCollectionInterface
{
    public function add(EntityInterface $entity): self;
    public function remove(EntityInterface $entity): self;
    public function retrieve(): self;
}
