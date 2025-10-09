<?php

namespace Khalyamad\Job15\Interface;

interface StockableInterface
{
    public function addStocks(int $stock): self;
    public function removeStocks(int $stock): self;
}
