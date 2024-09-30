<?php

declare(strict_types=1);

namespace App\Trait;

trait ObjectValueTrait
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function get(string $propertyName)
    {
        return $this->$propertyName ?? null;
    }
}