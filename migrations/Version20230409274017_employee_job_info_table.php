<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230409274017_employee_job_info_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('employee_job_info');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('employee_id', Types::INTEGER);
        $table->addColumn('contract_type', Types::SMALLINT);
        $table->addColumn('Job_title', Types::INTEGER);
        $table->addColumn('general_management', Types::INTEGER);
        $table->addColumn('department', Types::INTEGER);
        $table->addColumn('division', Types::INTEGER);
        $table->addColumn('div', Types::INTEGER);
        $table->addColumn('class', Types::INTEGER);
        $table->addColumn('grade', Types::INTEGER);
        $table->addColumn('job_start_date', Types::DATE_MUTABLE);
        $table->addColumn('job_end_date', Types::DATE_MUTABLE)->setNotnull(false)->setDefault(null);

        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['id']);
        $table->addUniqueConstraint(['employee_id']);

        $table->addForeignKeyConstraint('employee_basic_info', ['employee_id'],['id']);

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('employee_job_info');
    }
}
