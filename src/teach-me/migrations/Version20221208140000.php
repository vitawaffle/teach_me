<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221128110947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE roles (
                id BIGSERIAL NOT NULL PRIMARY KEY,
                name TEXT NOT NULL UNIQUE
            )
        ');

        $this->addSql('
            CREATE TABLE users (
                id BIGSERIAL NOT NULL PRIMARY KEY,
                username TEXT NOT NULL UNIQUE,
                password TEXT NOT NULL
            )
        ');

        $this->addSql('
            CREATE TABLE users_roles (
                user_id BIGINT NOT NULL,
                role_id BIGINT NOT NULL,
                PRIMARY KEY(user_id, role_id),
                CONSTRAINT users_roles_user_id_fkey FOREIGN KEY(user_id)
                    REFERENCES users (id) ON DELETE CASCADE,
                CONSTRAINT users_roles_role_id_fkey FOREIGN KEY(role_id)
                    REFERENCES roles (id) ON DELETE CASCADE
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE users_roles');
    }
}
