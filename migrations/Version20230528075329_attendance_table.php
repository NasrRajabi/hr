<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230528075329_attendance_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('attendance');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('employee_id', Types::INTEGER);
        $table->addColumn('date', Types::DATETIME_IMMUTABLE);
        $table->addColumn('state', Types::INTEGER);  // آلية اثبات الحضور 
        $table->addColumn('type', Types::INTEGER); //  حضور / انصراف / وقت اضافي 
        $table->addColumn('device_id', Types::INTEGER);


        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['id']);
        $table->addForeignKeyConstraint('employee_basic_info', ['employee_id'],['id']);
        // this up() migration is auto-generated, please modify it to your needs

    }

    public function down(Schema $schema): void
    {

        $schema->dropTable('attendance');
        // this down() migration is auto-generated, please modify it to your needs

    }
}
