<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230521074846_emp_vac_balance_seeder extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("
        INSERT INTO emp_vac_balance (
            employee_id,
            vacation_type,
            start_balance,
            current_balance) VALUES
            (1,1,30,30),
            (1,2,90,90),
            (1,3,30,30),
            (1,6,10,10),
            (689,1,30,30),
            (689,2,90,90),
            (689,3,30,30),
            (689,6,10,10)
        ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE emp_vac_balance');
    }
}
