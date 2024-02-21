<?php
declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230919114322_crediting_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('crediting');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('year_credi', Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('create_user', Types::INTEGER);
        $table->addColumn('create_date', Types::DATETIME_MUTABLE);
        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['id']);      
    }



    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('crediting');

    }

}