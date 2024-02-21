<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230822083625_job_assigment_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('job_assigment');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('employee_id', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('mission_type', Types::INTEGER);
        $table->addColumn('mission_supject', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('mission_country', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('mission_city', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('hosted_type', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('mission_start_date', Types::DATE_MUTABLE)->setNotnull(false)->setDefault(null);
        $table->addColumn('mission_end_date', Types::DATE_MUTABLE)->setNotnull(false)->setDefault(null);
        $table->addColumn('last_date', Types::DATE_MUTABLE)->setNotnull(false)->setDefault(null);
        $table->addColumn('mission_funded', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('mission_status', Types::INTEGER);
        $table->addColumn('short_description', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('note', Types::STRING)->setNotnull(false)->setDefault(null);    
        $table->addColumn('create_user', Types::INTEGER);
        $table->addColumn('create_date', Types::DATETIME_MUTABLE);
        $table->addColumn('approve_user', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('approve_date', Types::DATETIME_MUTABLE)->setNotnull(false)->setDefault(null);

        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['id']);      
    }



    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('job_assigment');

    }

}