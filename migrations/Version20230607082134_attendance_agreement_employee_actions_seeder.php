<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230607082134_attendance_agreement_employee_actions_seeder extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO public.attendance_agreement_employee_actions(
                            employee_id, agreement_id, start_date, end_date)
                            VALUES (1, 1, '2023-06-02', null)
                            ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE attendance_agreement_employee_actions');
    }
}
