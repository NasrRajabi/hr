<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231105102001_permission_role_seeder2 extends AbstractMigration
{
    public function getDescription(): string
    {
        // this up() migration is auto-generated, please modify it to your needs
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
        INSERT INTO permission_role (permission_id, role_id) VALUES       
        (88, 1),
        (89, 1),
        (90, 1),
        (91, 1),
        (92, 1),
        (93, 1),
        (94, 1),
        (95, 1),
        (96, 1),
        (97, 1),
        (100, 1),
        (101, 1),
        (102, 1),
        (103, 1),
        (104, 1),
        (105, 1),
        (106, 1),
        (107, 1),
        (108, 1),
        (109, 1),
        (110, 1),
        (111, 1),
        (112, 1),
        (113, 1),
        (114, 1),
        (115, 1),
        (116, 1),
        (117, 1),
        (118, 1),
        (119, 1),
        (120, 1),
        (121, 1),
        (122, 1)
        ");
        

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE permission_role');
    }
}
