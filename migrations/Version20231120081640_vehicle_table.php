<?php

declare(strict_types=1);

namespace HR\Migrations;
use Doctrine\DBAL\Types\Types;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231120081640_vehicle_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('vehicle');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('vehicle_no', Types::INTEGER);
        $table->addColumn('vehicle_name', Types::STRING);
        $table->addColumn('vehicle_type', Types::STRING);
        $table->addColumn('chassis_no', Types::STRING);
        $table->addColumn('engine_no', Types::INTEGER);
        $table->addColumn('engine_capacity', Types::INTEGER);
        $table->addColumn('vehicle_model', Types::STRING);
        $table->addColumn('fuel_type', Types::STRING);
        $table->addColumn('lime_type', Types::STRING);
        $table->addColumn('vehicle_color', Types::INTEGER);
        $table->addColumn('created_by', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('created_at', Types::DATE_MUTABLE)->setNotnull(false)->setDefault(null);
        $table->addColumn('updated_by',   Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('updated_at',      Types::DATE_MUTABLE)->setNotnull(false)->setDefault(null);
        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['id']);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('vehicle');
    }
}
