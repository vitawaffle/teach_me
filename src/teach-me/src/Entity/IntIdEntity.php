<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\{MappedSuperclass, Id, GeneratedValue, Column};

#[MappedSuperclass]
class IntIdEntity extends AppEntity
{
    public function __construct(
        #[Id, GeneratedValue, Column]
        protected ?int $id = null,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
