<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230709065158_att_org_chart_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('att_org_chart');

        $table->addColumn('PARENT_ID', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('NODE_ID', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('NODE_ORDER', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('NODE_LEVEL',  Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('DEPT_TYPE', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('DEPT_VALUE', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('EMP_NUMBERS', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('STATE', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('ACTIVE', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('NODE_ICON', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('NOTE', Types::STRING)->setNotnull(false)->setDefault(null);

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('att_org_chart');
    }
}
