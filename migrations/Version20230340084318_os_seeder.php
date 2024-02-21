<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230340084318_os_seeder extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
        INSERT INTO os(id, parent_id, node_level, dept_type, name ) VALUES
            (1,0, 1, 1, 'الوزير')
        ");
    }

    public function down(Schema $schema): void
    {
        // $this->addSql('TRUNCATE TABLE os');
    }
}
