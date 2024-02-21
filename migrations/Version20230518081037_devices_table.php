<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230518081037_devices_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {

               // this up() migration is auto-generated, please modify it to your needs
               $table = $schema->createTable('devices');
               $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
               $table->addColumn('name', Types::STRING);
               $table->addColumn('device_ip', Types::STRING);
            //    $table->addColumn('port', Types::INTEGER);
               $table->addColumn('serial', Types::STRING)->setNotnull(false)->setDefault(null);
               $table->addColumn('area', Types::STRING);
               $table->addColumn('status', Types::BOOLEAN)->setDefault(true);
               $table->setPrimaryKey(['id']);
               $table->addUniqueConstraint(['id']);
        // this up() migration is auto-generated, please modify it to your needs

    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('devices');
        
        // this down() migration is auto-generated, please modify it to your needs

    }
}
