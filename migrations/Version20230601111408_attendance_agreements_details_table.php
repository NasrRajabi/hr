<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230601111408_attendance_agreements_details_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('attendance_agreements_details');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);    
        $table->addColumn('agreement_id', Types::INTEGER); //  الاتفاقية 
        $table->addColumn('day', Types::STRING); // اليوم
        $table->addColumn('att_status', Types::INTEGER); // دوام 3 - 5عطلة  
        $table->addColumn('start_time', Types::TIME_MUTABLE); // بداية الدوام
        $table->addColumn('end_time', Types::TIME_MUTABLE); // نهاية الدوام 
        $table->addColumn('check_in_end', Types::TIME_MUTABLE); // نهاية فترة احتساب بصمة الدخول 
        $table->addColumn('allowed_time_check_in', Types::INTEGER); // بالدقائق فترة السماح لبصمة الحضور
        $table->addColumn('allowed_time_check_out', Types::INTEGER); //  بالدقائق فترة السماح لبصمة الانصراف 
        $table->addColumn('allowed_p_leave_hours', Types::INTEGER); // الحد الأعلى المسموح به للمغادرات الخاصة 


        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['id']);

        $table->addUniqueConstraint(['agreement_id','day']);

        $table->addForeignKeyConstraint('attendance_agreements', ['agreement_id'],['id']);
        // this up() migration is auto-generated, please modify it to your needs

    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('attendance_agreements_details');
        // this down() migration is auto-generated, please modify it to your needs

    }
}
