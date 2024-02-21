<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230411111353_employee_contacts_info_seeder extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
        INSERT INTO employee_contacts_info (
             employee_id, p_email, p_mobile, p_telephone, g_email, g_mobile, g_telephone
        )
        VALUES
            ( 1, 'a@mail.com', '0321456987', '9876543210', 'abc@mtit.gov.ps', '0562314789', '123')
            ");
        // this up() migration is auto-generated, please modify it to your needs

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
    /*
    ( 2, 'employee2@example.com', '1111111111', '2222222222', 'guardian2@example.com', '4444444444', '7777777777'),
    ( 3, 'employee3@example.com', '9999999999', '8888888888', 'guardian3@example.com', '3333333333', '6666666666')
    */
    // ( 2, 'b@mail.com', '0321456987', '9876543210', 'abc@mtit.gov.ps', '0562314789', '123'),
    // ( 3, 'c@mail.com', '0321456987', '9876543210', 'abc@mtit.gov.ps', '0562314789', '123'),
    // ( 4, 'd@mail.com', '0321456987', '9876543210', 'abc@mtit.gov.ps', '0562314789', '123'),
    // ( 5, 'e@mail.com', '0321456987', '9876543210', 'abc@mtit.gov.ps', '0562314789', '123');