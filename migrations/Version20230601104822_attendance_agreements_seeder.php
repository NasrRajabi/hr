<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230601104822_attendance_agreements_seeder extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
        INSERT INTO attendance_agreements(
             name, description)
           VALUES ('اتفاقية العمل الاداري العام', '8:00-15:00'),
           ('اتفاقية الدوام المسائي', '22:00-16:00')
         ");
        // this up() migration is auto-generated, please modify it to your needs

    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE TABLE attendance_agreements');
        // this down() migration is auto-generated, please modify it to your needs

    }
}
