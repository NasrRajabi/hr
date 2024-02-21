<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230619071632_menu_items_seeder extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO menu_items (id, menu_id, permission_id, title, icon_class, color, parent_id, order_no, parameters, url)
VALUES
  (1, 1, 1, 'أدوات المطورين', 'bi bi-tools', '#000000', 1, 1, NULL, '/menus'),
  (2, 1, 1, 'بناء القوائم', 'bi bi-hammer', '#000000', 1, 1, NULL, '/roles'),
  (3, 1, 1, 'الأدوار', 'bi bi-gear-wide-connected', '#000000', 1, 1, NULL, '/permissions'),
  (4, 1, 1, 'الصلاحيات', 'bi bi-wrench-adjustable-circle', '#000000', 1, 1, NULL, '/permissions'),
  (5, 2, 1, 'مراقبة الدوام', 'bi bi-incognito ps-2 ', '#050ba8', 0, 1, NULL, '/attendance/monitoring'),
  (6, 2, 7, 'ساعات الدوام', 'bi bi-clock-fill ps-2', '#9f1e1e', 0, 2, NULL, '/attendance/devices'),
  (7, 2, 7, 'الحضور والانصراف', 'bi bi-clock-fill ps-2', '#9f1e1e', 0, 2, NULL, '/duration/attendance'),
  (8, 2, 1, 'اتفاقيات الدوام', 'bi bi-clipboard2-fill ps-2', '#000000', 0, 3, NULL, '/attendance_agreements/agreement_list'),
  (9, 2, 1, 'الموظفين', 'bi bi-people-fill ps-2', '#6b2424', 0, 4, NULL, NULL),
  (10, 2, 1, 'قائمة', 'bi bi-people ps-2', '#35750b', 9, 1, NULL, '/employee/all'),
  (11, 2, 1, 'اضافة موظف', 'bi bi-person-fill-add ps-2', '#8c2121', 9, 2, NULL, '/employee/add'),
  (12, 2, 1, 'تكليف', 'bi bi-stars ps-2', '#02d92d', 9, 3, NULL, '/employee/assigne_position/0'),
  (13, 2, 1, 'الهيكلية', 'bi bi-diagram-3-fill ps-2', '#911818', 0, 5, NULL, NULL),
  (14, 2, 1, 'عرض', 'bi bi-display-fill', '#000000', 13, 1, NULL, '/os/view'),
  (15, 4, 12, 'اعدادات الاجازات', 'bi bi-airplane-fill', '#000000', 0, 1, NULL, '/setting/vacationList'),
  (16, 2, 1, 'سجلات الوصول الرسمي', 'bi bi-person-rolodex', '#000000', 0, 6, NULL, '/official_reach/gov_email'),
  (17, 2, 3, 'سجل البريد الالكتروني', 'bi bi-clipboard2-fill ps-2', '#000000', 16, 1, NULL, '/official_reach/gov_email'),
  (18, 2, 1, 'سجل الأرقام الخليوية', 'bi bi-clipboard2-fill ps-2', '#000000', 16, 2, NULL, '/official_reach/gov_mobile'),
  (19, 2, 3, 'سجل الأرقام الداخلية', 'bi bi-clipboard2-fill ps-2', '#000000', 16, 3, NULL, '/official_reach/gov_tel'),
  (20, 3, 3, 'الدوام', 'bi bi-door-open-fill ps-2', '#000000', 0, 1, NULL, NULL),
  (21, 3, 3, 'الحضور', 'bi bi-door-open-fill ps-2', '#000000', 20, 1, NULL, '/duration/attendance'),
  (22, 3, 5, 'اجازات', 'bi bi-door-open-fill ps-2', '#000000', 0, 2, NULL, '/duration/attendance'),
  (23, 3, 3, 'ارصدة', 'bi bi-door-open-fill ps-2', '#000000', 22, 1, NULL, '/vacation/listEmpVacBalance'),
  (24, 3, 1, 'اضافة', 'bi bi-door-open-fill ps-2', '#000000', 22, 2, NULL, '/vacation/addEmpVacation'),
  (25, 3, 1, 'قائمة', 'bi bi-door-open-fill ps-2', '#000000', 22, 3, NULL, '/vacation/listEmpVacation'),
  (26, 3, 1, 'طلبات الموظفين', 'bi bi-door-open-fill ps-2', '#000000', 22, 4, NULL, '/vacation/listManTOEmp'),
  (27, 3, 1, 'مغادرات', 'bi bi-door-open-fill ps-2', '#000000', 0, 3, NULL, NULL),
  (28, 3, 1, 'قائمة', 'bi bi-door-open-fill ps-2', '#000000', 27, 1, NULL, '/leave/list'),
  (29, 3, 1, 'اضافة', 'bi bi-door-open-fill ps-2', '#000000', 27, 2, NULL, '/leave/add'),
  (30, 3, 1, 'طلبات الموظفين', 'bi bi-door-open-fill ps-2', '#000000', 27, 3, NULL, '/leave/addemp'),
  (31, 2, 1, 'ترصيد الاجازات', 'bi bi-door-open-fill ps-2', '#000000', 0, 1, NULL, '/vacations_crediting/add'),
  (32, 3, 1, 'مهمات العمل', 'bi bi-door-open-fill ps-2', '#000000', 0, 1, NULL,  NULL),
  (33, 3, 1, ' مهمات العمل الداخليه', 'bi bi-door-open-fill ps-2', '#000000', 32, 1, NULL, '/job_assignment/add'),
  (34, 3, 1, 'مهمات العمل الخارجيه', 'bi bi-door-open-fill ps-2', '#000000', 32, 2, NULL, '/job_assignment/add'),
  (35, 3, 1, 'جميع المهمات', 'bi bi-door-open-fill ps-2', '#000000', 32, 3, NULL, '/job_assignment/list')
  ;

 ");
    }
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE menu_items');
    }
}
