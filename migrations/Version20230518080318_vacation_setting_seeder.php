<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230518080318_vacation_setting_seeder extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
        {
            $this->addSql(" INSERT INTO vacation_setting (vacation_type,contract_type,from_age,to_age,from_service_years,to_service_years,vac_days,max_days,max_move_days, seq,vac_years)
                            VALUES
                            (20,2,0,100,0,100,365,365,1,3,1),
                            (8,2,0,100,0,100,365,365,4,1,4),
                            (20,6,0,100,0,100,365,365,1,2,1),
                            (20,3,0,100,0,100,365,365,1,4,1),
                            (8,6,0,100,0,100,365,365,4,2,4),
                            (8,1,0,100,0,100,365,365,4,3,4),
                            (8,3,0,100,0,100,365,365,4,4,4),
                            (1,7,0,100,0,5,14,28,28,17,1),
                            (6,7,0,100,0,100,14,14,0,7,1),
                            (12,2,0,100,0,100,30,30,30,2,1),
                            (12,3,0,100,0,100,30,30,30,3,1),
                            (9,1,0,100,0,100,90,90,0,1,1),
                            (9,2,0,100,0,100,90,90,0,2,1),
                            (9,3,0,100,0,100,90,90,0,3,1),
                            (9,4,0,100,0,100,70,70,0,4,1),
                            (9,5,0,100,0,100,70,70,0,5,1),
                            (12,1,0,100,0,100,30,30,30,1,1),
                            (15,4,0,100,0,100,3,6,0,2,1),
                            (12,6,0,100,5,100,30,30,30,4,1),
                            (15,5,0,100,0,100,3,6,0,1,1),
                            (1,2,50,100,0,10,30,60,60,14,1),
                            (7,2,0,100,0,100,10,10,0,2,1),
                            (7,1,0,100,0,100,10,10,0,1,1),
                            (7,3,0,100,0,100,10,10,0,3,1),
                            (6,4,0,100,0,100,14,14,0,1,1),
                            (6,5,0,100,0,100,90,90,0,2,3),
                            (6,6,0,100,0,100,14,14,0,3,1),
                            (6,1,0,100,0,100,90,90,0,4,3),
                            (6,2,0,100,0,100,90,90,0,5,3),
                            (6,3,0,100,0,100,90,90,0,6,3),
                            (15,6,0,100,0,100,3,6,0,3,1),
                            (1,1,0,100,0,5,14,28,28,12,1),
                            (1,3,0,100,0,0.5,0,0,0,15,1),
                            (1,2,0,50,0,100,30,60,60,1,1),
                            (20,1,0,100,0,100,365,365,1,1,1),
                            (1,2,50,100,9.99,50,35,60,60,16,1),
                            (1,1,0,100,5,100,21,42,42,4,1),
                            (1,4,0,100,0,5,14,28,28,5,1),
                            (1,4,0,100,5,100,21,42,42,6,1),
                            (1,5,0,100,0,5,30,60,60,7,1),
                            (1,5,0,100,5,100,30,60,60,8,1),
                            (1,6,0,100,0,5,14,28,28,9,1),
                            (1,6,0,100,5,100,21,42,42,10,1),
                            (1,3,0,100,0.5,100,30,60,30,11,1),
                            (11,1,0,100,0,100,1,365,0,1,1),
                            (9,6,0,100,0,100,70,70,0,7,1),
                            (12,3,0,100,6,100,30,30,30,5,1),
                            (7,6,0,100,0,100,10,10,0,4,1),
                            (11,2,0,100,0,100,1,365,0,2,1),
                            (11,6,0,100,0,100,1,365,0,3,1),
                            (11,3,0,100,0,100,1,365,0,4,1),
                            (10,2,0,100,0,100,3,3,0,1,1),
                            (10,3,0,100,0,100,3,3,0,2,1)

                    ");

       // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(" UPDATE vacation_setting 
                        SET contract_type = (CASE contract_type 
                                                WHEN  1  THEN  3
                                                WHEN  2  THEN  1
                                                WHEN  3  THEN  2
                                                ELSE contract_type
                                            END)

                        ,   vacation_type = (CASE vacation_type 
                                                WHEN  1     THEN  1
                                                WHEN  6     THEN  2
                                                WHEN  12    THEN  3
                                                WHEN  9     THEN  4
                                                WHEN  10    THEN  5
                                                WHEN  7     THEN  6
                                                WHEN  8     THEN  7
                                                WHEN  11    THEN  8
                                                WHEN  15    THEN  9
                                                WHEN  20    THEN  10
                                                ELSE vacation_type
                                            END)
                     ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE vacation_setting');

    }
}
