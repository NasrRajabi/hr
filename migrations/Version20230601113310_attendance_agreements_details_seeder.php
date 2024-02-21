<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230601113310_attendance_agreements_details_seeder extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
        INSERT INTO attendance_agreements_details(
           agreement_id, day, att_status , start_time, end_time, check_in_end, allowed_time_check_in, allowed_time_check_out, allowed_p_leave_hours)
            VALUES 
            ( 1, 'Sun', 3 , '08:00:00', '15:00:00', '11:00:00', '15', '15', 3), 
            ( 1, 'Mon',  3 , '08:00:00', '15:00:00', '11:00:00', '15', '15', 3), 
            ( 1, 'Tue',  3 , '08:00:00', '15:00:00', '11:00:00', '15', '15', 3), 
            ( 1, 'Wed',  3 , '08:00:00', '15:00:00', '11:00:00', '15', '15', 3), 
            ( 1, 'Thu', 3 ,  '08:00:00', '15:00:00', '11:00:00', '15', '15', 3), 
            ( 1, 'Fri', 5 ,  '00:00:00', '00:00:00', '00:00:00', '00', '00', 0), 
            ( 1, 'Sat',  5 , '00:00:00', '00:00:00', '00:00:00', '00', '00', 0) 
            ");

    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE TABLE attendance_agreements_details');
        // this down() migration is auto-generated, please modify it to your needs

    }
}
