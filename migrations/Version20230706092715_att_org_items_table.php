<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230706092715_att_org_items_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('att_org_items');
        $table->addColumn('ITEM_TYPE', Types::INTEGER);
        $table->addColumn('ITEM_ID', Types::INTEGER);
        $table->addColumn('ITEM_A_NAME', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('ITEM_L_NAME',  Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('ITEM_DESC', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('USER_NO', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('TIME_STAMP', Types::DATE_MUTABLE)->setNotnull(false)->setDefault(null);
        $table->addColumn('TEMP', Types::STRING)->setNotnull(false)->setDefault(null);

   //     $table->setPrimaryKey(['ITEM_ID']);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('att_org_items');
    }
}
