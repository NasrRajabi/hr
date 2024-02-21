<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230521074203_emp_vac_balance_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $table = $schema->createTable('emp_vac_balance');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('employee_id', Types::INTEGER);
        $table->addColumn('vacation_type', Types::INTEGER);
        $table->addColumn('start_balance', Types::INTEGER);
        $table->addColumn('current_balance', Types::INTEGER);

        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['id']);
      
        $table->addForeignKeyConstraint('employee_basic_info', ['employee_id'],['id']);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('emp_vac_balance');
    }
}
