<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406071856_employee_basic_info_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('employee_basic_info');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('employee_no', Types::INTEGER);
        $table->addColumn('f_name', Types::STRING);
        $table->addColumn('s_name', Types::STRING);
        $table->addColumn('t_name', Types::STRING);
        $table->addColumn('l_name', Types::STRING);
        $table->addColumn('en_name', Types::STRING);
        $table->addColumn('gender', Types::INTEGER);
        $table->addColumn('religion', Types::SMALLINT);
        $table->addColumn('birthday', Types::DATE_MUTABLE);
        $table->addColumn('birthplace', Types::STRING);
        $table->addColumn('nationality', Types::SMALLINT);
        $table->addColumn('national_id', Types::STRING);
        $table->addColumn('passport_no', Types::STRING);
        $table->addColumn('marital_status', Types::SMALLINT);
        $table->addColumn('employee_status', Types::SMALLINT)->setNotnull(false);

        $table->addColumn('disability', Types::STRING);
        $table->addColumn('disability_desc', Types::STRING);

        $table->addColumn('attendance_agreements_id', Types::INTEGER);

        
        $table->addColumn('avatar',                     Types::STRING)->setDefault('/img/users/default.png');
        $table->addColumn('password',                   Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('secret_key',                 Types::STRING)->setNotnull(false);
        $table->addColumn('active',                     Types::BOOLEAN)->setDefault(false);
        $table->addColumn('lock',                       Types::SMALLINT)->setDefault(0);
        $table->addColumn('is_first_login',             Types::BOOLEAN)->setDefault(true);
        


        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['id']);
        $table->addUniqueConstraint(['employee_no']);

       // $table->addForeignKeyConstraint('attendance_agreements', ['attendance_agreements_id'],['id']);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('employee_basic_info');
    }
}