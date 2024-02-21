<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230518075234_vacation_setting_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {

        // this up() migration is auto-generated, please modify it to your needs

        $table = $schema->createTable('vacation_setting');

        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('vacation_type', Types::INTEGER);
        $table->addColumn('contract_type', Types::INTEGER);   
         $table->addColumn('from_age', Types::INTEGER);
        $table->addColumn('to_age', Types::INTEGER);
        $table->addColumn('from_service_years', Types::INTEGER);
        $table->addColumn('to_service_years', Types::INTEGER);
        $table->addColumn('vac_days', Types::INTEGER);
        $table->addColumn('max_days', Types::INTEGER);
        $table->addColumn('max_move_days', Types::INTEGER);
        $table->addColumn('seq', Types::INTEGER);
        $table->addColumn('vac_years', Types::INTEGER);

        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['id']);
       
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('vacation_setting');
    }
}
