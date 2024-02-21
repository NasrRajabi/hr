<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230338075707_os_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('os');
        $table->addColumn('id', Types::INTEGER);//->setAutoincrement(true);
        $table->addColumn('parent_id', Types::INTEGER);
        $table->addColumn('node_level', Types::INTEGER);
        $table->addColumn('dept_type', Types::INTEGER);
        $table->addColumn('name', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('status', Types::BOOLEAN)->setDefault(true);


        $table->setPrimaryKey(['id']);
       // $table->addUniqueConstraint(['id']);

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('os');

    }
}