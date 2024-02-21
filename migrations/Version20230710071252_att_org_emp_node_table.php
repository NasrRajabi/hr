<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230710071252_att_org_emp_node_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('att_org_emp_node');

        $table->addColumn('COUNTER', Types::INTEGER);
        $table->addColumn('EMP_ID', Types::STRING);
        $table->addColumn('NODE_ID', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('ACTIVE',  Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('ACTIVE_DATE',  Types::DATE_MUTABLE)->setNotnull(false)->setDefault(null);
        $table->addColumn('USER_NO',  Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('TIME_STAMP',  Types::DATE_MUTABLE)->setNotnull(false)->setDefault(null);
        $table->addColumn('NOTE',  Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('JOB_NO',  Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('EMP_NODE_TYPE',  Types::STRING)->setNotnull(false)->setDefault(null);


        $table->setPrimaryKey(['COUNTER']);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('att_org_emp_node');
    }
}
