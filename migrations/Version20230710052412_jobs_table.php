<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230710052412_jobs_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('jobs');

        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('job_title', Types::STRING);
        $table->addColumn('job_title_e', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('job_desc',  Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('org_job',  Types::STRING)->setNotnull(false)->setDefault(null);

        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['id']);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('jobs');
    }
}
