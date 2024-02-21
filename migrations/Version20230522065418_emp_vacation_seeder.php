<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230522065418_emp_vacation_seeder extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {

        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("
        INSERT INTO emp_vacation (
            employee_id,
            vacation_type,
            annual_vac_type,
            start_date,
            end_date,
            address,
            mobile,
            phone,
            notes,
            vacation_status,
            substitute_employee,
            create_user, 
            create_date,
            approve_user,
            approve_date) VALUES
            (1, 1, 1, '01-05-2023', '01-05-2023', 'Nablus', '152364897', '12548795', 'Whatever', 1, 'Enas Qadous', 1, '01-31-2023',NULL,NULL)
        ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE emp_vacation');
    }
}
