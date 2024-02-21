<?php

declare(strict_types=1);

namespace HR\Migrations;
use Doctrine\DBAL\Types\Types;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231126104718_invoice_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('invoice');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('vehicle_id', Types::INTEGER);
        $table->addColumn('invoice_date', Types::DATE_MUTABLE);
        $table->addColumn('invoice_type', Types::STRING);
        $table->addColumn('invoice_no', Types::STRING);
        $table->addColumn('invoice_value', Types::STRING);
        $table->addColumn('invoice_status', Types::INTEGER);
        $table->addColumn('invoice_note', Types::STRING);
        $table->addColumn('invoice_note_status', Types::STRING);
        $table->addColumn('invoice_date_paid', Types::DATE_MUTABLE);
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
        $schema->dropTable('movement');
    }
}
