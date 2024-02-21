<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230411100949_employee_job_info_seeder extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {

       /* $this->addSql("
        
            INSERT INTO employee_job_info(
             employee_id, contract_type, job_title, general_management, department, division, div, class, grade, job_start_date, job_end_date)
            VALUES (
                1, 
                1, 
                1,
                1, 
                2,
                3,
                4,
                5,
                5, 
                '2023-06-21', 
                NULL
            ),
           (
                2, 
                1, 
                1,
                1, 
                2,
                3,
                4,
                5,
                5, 
                '2023-06-21', 
                NULL
            );
        
        ");
        ");*/
        // this up() migration is auto-generated, please modify it to your needs

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
/*
, (
                2, 
                2, 
                1,
                1, 
                2,
                3,
                4,
                5,
                5, 
                '2023-06-15', 
                '2023-12-31'
            ), (
                3, 
                3, 
                1,
                1, 
                2,
                3,
                4,
                5,
                5, 
                '2023-06-10', 
                NULL
            );*/