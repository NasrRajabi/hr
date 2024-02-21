<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230411102145_employee_education_info_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('employee_education_info');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('employee_id', Types::INTEGER);
        $table->addColumn('academic_degree', Types::SMALLINT);
        $table->addColumn('unviersity', Types::STRING);
        $table->addColumn('major', Types::STRING);
        $table->addColumn('degree', Types::SMALLINT);
        $table->addColumn('edu_start_date', Types::DATE_MUTABLE);
        $table->addColumn('edu_end_date', Types::DATE_MUTABLE);

        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['id']);


        $table->addForeignKeyConstraint('employee_basic_info', ['employee_id'],['id']);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('employee_education_info');
    }
}
