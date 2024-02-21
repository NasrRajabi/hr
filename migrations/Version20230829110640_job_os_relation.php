<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Types\Types;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230829110640_job_os_relation extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->getTable('jobs');
        $table->addColumn('is_sup', Types::BOOLEAN)->setDefault(false);

        $table = $schema->getTable('employee_os');
        $table->addColumn('job_id', Types::INTEGER)->setDefault(1);
        $table->addForeignKeyConstraint('jobs', ['job_id'],['id']);
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable('jobs');
        $table->dropColumn('is_sup');

        $table = $schema->getTable('jobs');
        $table->dropColumn('job_id');
    }
}