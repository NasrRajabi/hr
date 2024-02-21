<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230409115604_employee_basic_info_seeder extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        //this up() migration is auto-generated, please modify it to your needs
        $pass = '$2y$10$kTrsFn8xeN34o4b7AKyftuveMugs2mCTwTcy0nreA5zS1WoQdx.TG';
        $this->addSql("
       
        INSERT INTO employee_basic_info (employee_no, f_name, s_name, t_name, l_name, en_name, gender, religion, birthday, birthplace, nationality, national_id, passport_no, marital_status, employee_status, disability, disability_desc, attendance_agreements_id, password, active, is_first_login)
VALUES 
  ('168139', 'عاصم', '', '', 'يمك', 'عاصم يمك ', 1, 1, '1990-01-01', 'نابلس', 1, '123456789', 'ABC123', 1, 1, '', '', 1, '$pass', true, true)
 
  ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('TRUNCATE TABLE employee_basic_info');
        // $schema->dropTable('employee_basic_info');
    }
}
/*
      ('123456','محمد', 'محمد', 'محمد', 'محمد', 'test test', 1, 1, '7/5/1993', 'Nablus',  1 , '123456789',  '123456', 2, '', '', 1 ,'$pass' , true ), 
            ('987654', 'John', 'Doe', 'Middle', 'Smith', 'John Smith', 1, 2, '12/15/1985', 'New York', 2, '987654321', 'ABC123', 1, '', '', 1, '$pass', true),
        ('456789', 'Jane', 'Doe', 'Elizabeth', 'Johnson', 'Jane Johnson', 2, 1, '10/20/1990', 'Los Angeles', 3, '654321987', 'DEF456', 2, '', '', 2, '$pass', true),
        ('246813', 'Michael', 'Brown', 'David', 'Taylor', 'Michael Taylor', 1, 1, '3/8/1980', 'Chicago', 1, '789654123', 'GHI789', 1, '', '', 1, '$pass', true),
        ('135792', 'Emily', 'Johnson', 'Rose', 'Davis', 'Emily Davis', 2, 2, '6/12/1995', 'Houston', 2, '321987654', 'JKL012', 3, '', '', 3, '$pass', true),
        ('369258', 'Daniel', 'Wilson', 'Thomas', 'Anderson', 'Daniel Anderson', 1, 1, '9/25/1978', 'San Francisco', 1, '654987321', 'MNO345', 2, '', '', 1, '$pass', true),
        ('785634', 'Sarah', 'Miller', 'Anne', 'Robinson', 'Sarah Robinson', 2, 2, '2/4/1987', 'Seattle', 3, '987123654', 'PQR678', 1, '', '', 1, '$pass', true),
        ('102938', 'Matthew', 'Brown', 'Ryan', 'Lee', 'Matthew Lee', 1, 1, '11/7/1982', 'Miami', 1, '321654987', 'STU901', 2, '', '', 2, '$pass', true),
        ('574930', 'Olivia', 'Walker', 'Grace', 'Thompson', 'Olivia Thompson', 2, 2, '4/22/1992', 'Denver', 2, '654789321', 'VWX234', 1, '', '', 1, '$pass', true),
        ('293847', 'Andrew', 'Clark', 'Benjamin', 'Harris', 'Andrew Harris', 1, 2, '8/16/1989', 'Boston', 3, '987321654', 'YZA567', 2, '', '', 3, '$pass', true),
        ('657483', 'Sophia', 'Adams', 'Emma', 'Martin', 'Sophia Martin', 2, 1, '5/30/1984', 'Phoenix', 1, '654123987', 'BCD890', 1, '', '', 1, '$pass', true)
        
        */
        