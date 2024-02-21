<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230619070854_menu_seeder extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("
           INSERT INTO menus (menu_name, description)
                VALUES
                  ('devTools', 'قائمة تحتوي على جميع الادوات الخاصة بالمبرمجين'),
                  ('شؤون الموظفين', 'قائمة تحتوي على جميع الادوات الخاصة بالشؤون الادارية للموظفين'),
                  ('بورتل الموظف', 'قائمة تحتوي على جميع الادوات اللازمة للموظف'),
                  ('الاعدادات والقوائم الثابتة', 'قائمة تحتوي على اعدادات النظام والقوائم الثابتة'),
                  ('تقارير', 'قائمة تحتوي على التقارير والخلاصات والتحليلات');

            ");
       
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE menus');
    }
}
