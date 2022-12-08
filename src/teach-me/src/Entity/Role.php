<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\{Collection, ArrayCollection};
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\{Entity, Table, ManyToMany, Column};
use JsonSerializable;

#[
    Entity(repositoryClass: RoleRepository::class),
    Table(name: 'roles'),
]
class Role extends IntIdEntity implements JsonSerializable
{
    /** @var Collection<User> $users */
    #[ManyToMany(targetEntity: User::class, mappedBy: 'roles')]
    private Collection $users;

    /**
     * @param User[] $users
     */
    public function __construct(
        #[Column(type: Types::TEXT)]
        private ?string $name = null,
        array $users = [],
        ?int $id = null,
    ) {
        parent::__construct($id);

        $this->users = new ArrayCollection($users);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return User[]
     */
    public function getUsers(): array
    {
        return $this->users->toArray();
    }

    /**
     * @param User[] $users
     */
    public function setUsers(array $users): self
    {
        $this->users = new ArrayCollection($users);

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
