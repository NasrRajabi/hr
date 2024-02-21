<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231031104929_Permissions_seeder2 extends AbstractMigration
{
    public function getDescription(): string
    {
        return "";
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("
        INSERT INTO permissions (
            key,
            group_name
            , description) VALUES

            ('add_os', 'Organization Structural', 'إضافة عنصر على الهيكلية'),
            ('view_os', 'Organization Structural', 'عرض الهيكلية'),
            ('view_os_delegation', 'Organization Structural', 'عرض صفحة التفويض'),
            ('save_os_delegation', 'Organization Structural', 'تفويض موظف'),
            ('edit_user_delegation', 'Organization Structural', 'تفويض موظف'),

            ('view_permissions', 'Permissions', 'عرض صفحة الصلاحيات'),
            ('edit_permission', 'Permissions', 'تعديل صلاحية'),
            ('add_permission', 'Permissions', 'ادخال صلاحية'),
            ('delete_permission', 'Permissions', 'حذف صلاحية'),

            ('view_roles', 'Roles', 'عرض صفحة الأدوار'),
            ('edit_role', 'Roles', 'تعديل دور'),
            ('add_role', 'Roles', 'أضف دور'),
            ('view_role', 'Roles', 'عرض دور'),
            ('delete_role', 'Roles', 'حذف دور'),

            ('view_employee_list', 'Employees', 'عرض قائمة الموظفين'),
            ('add_new_employee', 'Employees', 'اضافة موظف جديد'),
            ('view_employee_profile', 'Employees', 'عرض بيانات الموظف'),
            ('view_profile', 'Employees', 'عرض بيانات الموظف'),
            ('assigne_end_os', 'Employees', 'تعيين أو إنهاء تعيين موظف على الهيكلية'),

            ('view_leave_list', 'Leave', 'عرض صفحة المغادرات'), 
            ('add_leave', 'Leave', 'إضافة مغادرة'),
            ('view_users_leave', 'Leave', 'استعراض مغادرات الموظفين'),  
            ('update_leave_status', 'Leave', 'الموافقة على مغادرة الموظف'),   
            ('search_leaves', 'Leave', 'البحث في المغادرات'), 
            
            ('view_all_users_attendance', 'duration', 'استعراض حضور الموظفين'), 
            ('view_user_attendance', 'duration', 'استعراض حضور الموظف'), 
            ('get_users_attendance_report', 'duration', 'تصدير تقرير حضور الموظفين'), 
            ('view_user_attendance_details', 'duration', 'استعراض حضور الموظف بالتفصيل')
        ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE permissions');

    }
}
