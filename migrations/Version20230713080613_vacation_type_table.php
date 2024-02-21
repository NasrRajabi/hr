<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230713080613_vacation_type_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs      
    
        $table = $schema->createTable('vacation_type');

        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('vacation_name', Types::STRING);
        $table->addColumn('vacation_symbol', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('vac_in_sal', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('user_id', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('time_stamp', Types::DATE_MUTABLE)->setNotnull(false)->setDefault(null);
        $table->addColumn('vac_name_e', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('note', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('vac_type', Types::STRING)->setNotnull(false)->setDefault(null);// يتم تدويرها لسنة لاحقة
        $table->addColumn('vac_days', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('show_slip', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('add_holiday', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('religion', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('from_year', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('to_year', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('percent_vac', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('without_sal_vac_process_way', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('gender', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('selected', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('vacation_symbol_e', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('show_on_in_out_sheet', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('vac_years', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('show_on_portal', Types::INTEGER)->setNotnull(false)->setDefault(null);

        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['id']);      
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('vacation_type');
    }

}
