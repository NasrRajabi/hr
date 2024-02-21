<?php


declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231011181135_job_assigment_emp_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('job_assigment_emp');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('job_assigment_id', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('employee_id', Types::INTEGER);
        $table->addColumn('dep_id', Types::INTEGER);
        $table->addColumn('approve_user', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('approve_date', Types::DATETIME_MUTABLE)->setNotnull(false)->setDefault(null);
        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['id']);

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('job_assigment_emp');

    }
}
