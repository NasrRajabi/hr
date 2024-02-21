<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230411101036_employee_addresses_info_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('employee_addresses_info');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('employee_id', Types::INTEGER);
        $table->addColumn('address', Types::STRING);
        $table->addColumn('city', Types::SMALLINT);
        $table->addColumn('region', Types::STRING);
        $table->addColumn('street', Types::STRING);
        $table->addColumn('postal_code', Types::STRING);

        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['id']);
        $table->addUniqueConstraint(['employee_id']);

        $table->addForeignKeyConstraint('employee_basic_info', ['employee_id'],['id']);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('employee_addresses_info');
    }
}
