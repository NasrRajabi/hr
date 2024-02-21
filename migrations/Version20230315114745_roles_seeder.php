<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230315114745_roles_seeder extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("
        INSERT INTO roles (
            role_name,
            description) VALUES
            ('DEV', 'DEV'),
            ('Post office manager', 'Office-Manager'),
            ('Post Officer', 'Office-Man'),
            ('public treasury of stamps', 'Public-Treasury-Sta'),
            ('receiving committee', 'Receiving-Comm'),
            ('Post Office Treasury', 'Office-Treasury'),
            ('Barrier', 'Barrier'),
            ('Administrator', 'Admin'),
            ('PO Treasury Manager', 'po-manager-treasury'),
            ('PO Treasury Manager Barrier', 'po-treasury-manager-barrier'),
            ('PO Treasury Barrier', 'po-treasury-barrier')
           
        ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('TRUNCATE TABLE roles');
    }
}
