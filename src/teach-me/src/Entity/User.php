<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\{Collection, ArrayCollection};
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\{
    Entity,
    Table,
    ManyToMany,
    JoinTable,
    JoinColumn,
    InverseJoinColumn,
    Column,
};
use JsonSerializable;

#[
    Entity(repositoryClass: UserRepository::class),
    Table(name: 'users')
]
class User extends IntIdEntity implements JsonSerializable
{
    /** @var Collection<Role> $roles */
    #[
        ManyToMany(targetEntity: Role::class, inversedBy: 'users'),
        JoinTable(name: 'users_roles'),
        JoinColumn(name: 'user_id', referencedColumnName: 'id'),
        InverseJoinColumn(name: 'role_id', referencedColumnName: 'id'),
    ]
    private Collection $roles;

    /**
     * @param Role[] $roles
     */
    public function __construct(
        #[Column(type: Types::TEXT)]
        private ?string $username = null,
        #[Column(type: Types::TEXT)]
        private ?string $password = null,
        array $roles = [],
        ?int $id = null,
    ) {
        parent::__construct($id);

        $this->roles = new ArrayCollection($roles);
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = new ArrayCollection($roles);

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'roles' => $this->roles->toArray(),
        ];
    }
}
