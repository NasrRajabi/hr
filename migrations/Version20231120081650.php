<?php

declare(strict_types=1);

namespace HR\Migrations;
use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231106081438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('movement');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('vehicle_id', Types::INTEGER);
        $table->addColumn('itinerary', Types::STRING);
        $table->addColumn('movement_date', Types::DATE_MUTABLE);
        $table->addColumn('driver', Types::INTEGER);
        $table->addColumn('starting_hour', Types::STRING);
        $table->addColumn('end_hour', Types::STRING);
        $table->addColumn('star_counter_no', Types::STRING);
        $table->addColumn('end_counter_no', Types::STRING);
        $table->addColumn('created_by', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('created_at', Types::DATE_MUTABLE)->setNotnull(false)->setDefault(null);
        $table->addColumn('updated_by',   Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('updated_at',      Types::DATE_MUTABLE)->setNotnull(false)->setDefault(null);
        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('movement');
        // this down() migration is auto-generated, please modify it to your needs

    }
}
