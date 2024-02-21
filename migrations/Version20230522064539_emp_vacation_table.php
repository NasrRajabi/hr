<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230522064539_emp_vacation_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('emp_vacation');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('employee_id', Types::INTEGER);
        $table->addColumn('vacation_type', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('annual_vac_type', Types::INTEGER);
        $table->addColumn('start_date', Types::DATE_MUTABLE);
        $table->addColumn('end_date', Types::DATE_MUTABLE);
        $table->addColumn('address', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('mobile', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('phone', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('notes', Types::TEXT)->setNotnull(false)->setDefault(null);
        $table->addColumn('vacation_status', Types::INTEGER);
        $table->addColumn('substitute_employee', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('create_user', Types::INTEGER);
        $table->addColumn('create_date', Types::DATETIME_MUTABLE);
        $table->addColumn('approve_user', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('approve_date', Types::DATETIME_MUTABLE)->setNotnull(false)->setDefault(null);

        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['id']);
      
        $table->addForeignKeyConstraint('employee_basic_info', ['employee_id'],['id']);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('emp_vacation');
    }
}
