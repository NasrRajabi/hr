<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230619071629_menu_items_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('menu_items');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('menu_id', Types::INTEGER);
        $table->addColumn('title', Types::STRING);
        $table->addColumn('permission_id', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('icon_class', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('color', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('parent_id', Types::INTEGER)->setNotnull(false)->setDefault(0);
        $table->addColumn('order_no', Types::INTEGER);
        $table->addColumn('parameters', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('url', Types::STRING)->setNotnull(false)->setDefault(null);

        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['id']);

        
        $table->addForeignKeyConstraint('menus', ['menu_id'],['id']);
        $table->addForeignKeyConstraint('permissions', ['permission_id'],['id']);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('menu_items');
    }
}
