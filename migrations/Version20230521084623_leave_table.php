<?php

declare(strict_types=1);

namespace HR\Migrations;
use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230521084623_leave_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('leave');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('employee_id', Types::INTEGER);
        $table->addColumn('leave_type', Types::INTEGER);
        $table->addColumn('leave_dir',  Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('leave_date', Types::DATE_MUTABLE);
        $table->addColumn('leave_start', Types::STRING);
        $table->addColumn('leave_end', Types::STRING);
        $table->addColumn('leave_minit', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('need_car', Types::SMALLINT)->setDefault(0);
        $table->addColumn('leave_not',  Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('leave_status', Types::INTEGER);
        $table->addColumn('created_by', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('created_at', Types::DATE_MUTABLE)->setNotnull(false)->setDefault(null);
        $table->addColumn('updated_by',   Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('updated_at',      Types::DATE_MUTABLE)->setNotnull(false)->setDefault(null);
        $table->addColumn('approve_user', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('approve_date', Types::DATETIME_MUTABLE)->setNotnull(false)->setDefault(null);

        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['id']);
        $table->addForeignKeyConstraint('employee_basic_info', ['employee_id'],['id']);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('leave');
    }
}
