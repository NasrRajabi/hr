<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230328095355_permission_role_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('permission_role');
        $table->addColumn('permission_id', Types::INTEGER);
        $table->addColumn('role_id', Types::INTEGER);

        $table->addForeignKeyConstraint('permissions', ['permission_id'],['id']);
        $table->addForeignKeyConstraint('roles', ['role_id'],['id']);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('permission_role');
    }
}