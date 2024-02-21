<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230607081413_attendance_agreement_employee_actions_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('attendance_agreement_employee_actions');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);    
        $table->addColumn('employee_id', Types::INTEGER); // الموظف
        $table->addColumn('agreement_id', Types::INTEGER); //  الاتفاقية 
        $table->addColumn('start_date', Types::DATE_IMMUTABLE); // بداية تطبيق الاتفاقية
        $table->addColumn('end_date', Types::DATE_MUTABLE)->setNotnull(false)->setDefault(null); // نهاية تطبيق الاتفاقية 


        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['id']);

        

        $table->addForeignKeyConstraint('attendance_agreements', ['agreement_id'],['id']);
        $table->addForeignKeyConstraint('employee_basic_info', ['employee_id'],['id']);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('attendance_agreement_employee_actions');
    }
}
