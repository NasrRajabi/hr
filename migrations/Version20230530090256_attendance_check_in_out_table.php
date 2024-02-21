<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230530090256_attendance_check_in_out_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('attendance_check_in_out');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('employee_id', Types::INTEGER);
        $table->addColumn('date', Types::DATE_IMMUTABLE);
        $table->addColumn('check_in', Types::TIME_MUTABLE)->setNotnull(false)->setDefault(null);  // آلية اثبات الحضور 
        $table->addColumn('check_out', Types::TIME_MUTABLE)->setNotnull(false)->setDefault(null); //  حضور / انصراف / وقت اضافي 
        $table->addColumn('device_id', Types::INTEGER);

        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['employee_id','date']);
        //$table->addForeignKeyConstraint('employee_basic_info', ['employee_id'],['id']);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('attendance_check_in_out');
    }
}
