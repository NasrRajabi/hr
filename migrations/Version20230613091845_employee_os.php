<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230613091845_employee_os extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('employee_os');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('employee_id', Types::INTEGER);
        $table->addColumn('os_id', Types::INTEGER);
        $table->addColumn('role_id', Types::INTEGER);
        $table->addColumn('is_delegate', Types::BOOLEAN)->setNotnull(false)->setDefault(false);
        $table->addColumn('start_date', Types::DATE_MUTABLE);
        $table->addColumn('end_date', Types::DATE_MUTABLE)->setNotnull(false)->setDefault(null);

        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['id']);

        $table->addForeignKeyConstraint('employee_basic_info', ['employee_id'],['id']);
        $table->addForeignKeyConstraint('os', ['os_id'],['id']);
        $table->addForeignKeyConstraint('roles', ['role_id'],['id']);

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('employee_os');

    }
}
