<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230518082229_devices_seeder extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
        INSERT INTO devices( name, device_ip,  serial, area ) VALUES
        ( 'ساعة المقر الرئيسي' , '10.98.67.31' , '316134800016', 'محافظة رام الله والبيرة')
        
        ");
        // this up() migration is auto-generated, please modify it to your needs

    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE TABLE devices');
        // this down() migration is auto-generated, please modify it to your needs

    }
}
