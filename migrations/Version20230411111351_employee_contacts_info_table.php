<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230411111351_employee_contacts_info_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('employee_contacts_info');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('employee_id', Types::INTEGER);
        $table->addColumn('p_email', Types::STRING)->setNotnull(false);
        $table->addColumn('p_mobile', Types::STRING)->setNotnull(false);
        $table->addColumn('p_telephone', Types::STRING)->setNotnull(false);
        $table->addColumn('g_email ', Types::STRING);
        $table->addColumn('g_mobile', Types::STRING);
        $table->addColumn('g_telephone', Types::STRING);

        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['id']);
        $table->addUniqueConstraint(['employee_id']);

        $table->addForeignKeyConstraint('employee_basic_info', ['employee_id'], ['id']);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('employee_contacts_info');
    }
}
