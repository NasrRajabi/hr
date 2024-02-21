<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230601104700_attendance_agreements_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        
        $table = $schema->createTable('attendance_agreements');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);    
        $table->addColumn('name', Types::STRING); // اسم الاتفاقية        
        $table->addColumn('description', Types::STRING); // وصف الاتفاقية والفئة المستهدفة 

        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['id']);
       
        // this up() migration is auto-generated, please modify it to your needs

    }

    public function down(Schema $schema): void
    {

        $schema->dropTable('attendance_agreements');
        // this down() migration is auto-generated, please modify it to your needs

    }
}
