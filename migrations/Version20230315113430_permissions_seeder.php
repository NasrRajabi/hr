<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230315113430_permissions_seeder extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("
        INSERT INTO permissions (
            key,
            group_name
            , description) VALUES
            ('browse_menus', 'menus', '2021-04-06 03:47:36'),
            ('read_menus', 'menus', '2021-04-06 03:47:36'),
            ('edit_menus', 'menus', '2021-04-06 03:47:36'),
            ('add_menus', 'menus', '2021-04-06 03:47:36'),
            ('browse_roles', 'roles', '2021-04-06 03:47:36'),
            ('read_roles', 'roles', '2021-04-06 03:47:36'),
            ('edit_roles', 'roles', '2021-04-06 03:47:36'),
            ('add_roles', 'roles', '2021-04-06 03:47:36'),
            ('browse_users', 'users', '2021-04-06 03:47:36'),
            ('read_users', 'users', '2021-04-06 03:47:36'),
            ('edit_users', 'users', '2021-04-06 03:47:36'),
            ('add_users', 'users', '2021-04-06 03:47:36'),

            ('view_devices', 'Attendance Devices',  'عرض جدول ساعات الدوام'),
            ('add_device', 'Attendance Devices', 'اضافة ساعة دوام جديدة'),
            ('edit_device', 'Attendance Devices', 'تعديل بيانات ساعة الدوام'),
            ('transfer_data', 'Attendance Devices', 'سحب الدوام'),
            ('check_connect', 'Attendance Devices', 'فحص اتصال ساعة الدوام'),
            ('set_time', 'Attendance Devices', 'مزامة وقت الساعات'),
            ('get_user', 'Attendance Devices', 'عرض الموظفين على الساعة'),
            ('set_user', 'Attendance Devices', 'اضافة موظف على الساعة'),
            ('restart', 'Attendance Devices', 'اعادة تشغيل الساعة'),
            ('check_voice', 'Attendance Devices', 'فحص صوت الساعة'),    
           
            ('remove_user', 'Attendance Devices', 'حذف موظف عن الساعة'),           

            ('browse_currencies', 'currencies', '2021-04-20 06:50:22'),
            ('edit_currencies', 'currencies', '2021-04-20 06:50:22'),
            ( 'add_currencies', 'currencies', '2021-04-20 06:50:22'),
            ( 'browse_all_stamps', 'all', '2021-04-21 04:26:34'),
            ( 'browse_all_sheets', 'all', '2021-04-21 04:26:34'),
            ( 'browse_all_packs', 'all', '2021-05-05 06:21:08'),
            ( 'browse_permissions', 'permissions', '2021-05-06 06:16:22'),
            ( 'read_permissions', 'permissions', '2021-05-06 06:16:22'),
            ( 'edit_permissions', 'permissions', '2021-05-06 06:16:22'),
            ( 'add_permissions', 'permissions', '2021-05-06 06:16:22'),
            ( 'builder_menus', 'menu_items', '2021-05-30 05:52:25'),
            ( 'approve_committee', 'all', '2021-06-27 11:35:32'),
            ( 'approve_treasury', 'all', '2021-06-27 11:35:45'),
            ( 'read_office_orders', 'office_orders', '2021-08-04 11:17:53'),
            ( 'add_office_orders', 'office_orders', '2021-08-04 11:18:08'),
            ( 'browse_office_orders', 'office_orders', '2021-08-04 11:22:45'),
            ( 'A_office_browse_orders', 'orders_A', '2021-08-08 10:09:02'),
            ( 'A_office_prepare_orders', 'orders_A', '2021-08-08 10:09:13'),
            ( 'A_office_read_orders', 'orders_A', '2021-08-08 10:09:27'),
            ( 'A_office_edit_orders', 'orders_A', '2021-08-08 10:09:46'),
            ( 'treasury_details', 'treasury', '2021-09-21 08:03:28'),
            ( 'edit_profile', 'profile', '2021-09-28 06:02:26'),
            ( 'A_office_reject_orders', 'orders_A', '2021-09-29 07:12:05'),
            ( 'change_password_profile', 'profile', '2021-11-04 06:41:36'),
            ( 'change_password_users', 'users', '2021-11-04 06:53:10'),
            ( 'browse_profile', 'profile', '2021-11-04 06:54:27'),
            ( '2fa_profile', 'profile', '2021-11-08 06:52:33'),
            ( 'receipt_office_orders', 'office_orders', '2021-11-30 08:39:50'),
            ( 'A_office_receipt_orders', 'orders_A', '2021-08-08 10:09:13'),
            ( 'add_governorates', 'governorates', '2021-12-28 10:00:43'),
            ( 'browse_governorates', 'governorates', '2021-12-28 10:03:45'),
            ( 'read_governorates', 'governorates', '2021-12-28 10:04:49'),
            ( 'edit_governorates', 'governorates', '2021-12-28 10:05:27'),
            ( 'browse_postoffice', 'PostOffice', '2021-12-28 11:10:17'),
            ( 'add_postoffice', 'PostOffice', '2021-12-28 12:00:30'),
            ( 'edit_postoffice', 'PostOffice', '2021-12-28 12:22:41'),
            ( 'browse_fixidstamp', 'fixedstamp', '2021-12-28 16:57:49'),
            ( 'edit_fixidstamp', 'fixedstamp', '2021-12-28 17:10:48'),
            ( 'browse_bank', 'bank', '2021-12-28 23:03:30'),
            ( 'add_bank', 'bank', '2021-12-28 23:03:53'),
            ( 'edit_bank', 'bank', '2021-12-28 23:30:13'),
            ( 'browse_treasuries', 'treasuries', '2022-01-02 12:10:41'),
            ( 'add_treasuries', 'treasuries', '2022-01-02 12:11:30'),
            ( 'edit_treasuries', 'treasuries', '2022-01-02 12:11:56'),
            ( 'treasuries_details', 'treasuries', '2022-01-03 06:40:43'),
            ( 'browse_barriers', 'barriers', '2022-01-03 07:37:50'),
            ( 'add_barriers', 'barriers', '2022-01-03 07:38:15'),
            ( 'edit_barriers', 'barriers', '2022-01-03 07:38:39'),
            ( 'browse_stocks', 'stocks', '2022-01-03 09:04:02'),
            ( 'add_stocks', 'stocks', '2022-01-03 10:06:09'),
            ( 'edit_stocks', 'stocks', '2022-01-03 10:06:30'),
            ( 'Fetch_QR', 'all', '2022-01-03 12:08:28'),
            ( 'edit_boxes', 'all', '2022-01-18 09:57:11'),
            ( 'browse_office_treasuries', 'Office Treasuries', '2022-02-03 05:43:42'),
            ( 'add_user_to_barrier', 'Office Treasuries', '2022-02-03 06:30:20'),
            ( 'edit_user_office_treasuries', 'Office Treasuries', '2022-02-03 08:57:54'),
            ( 'inventory_office_treasuries', 'Office Treasuries', '2022-02-03 09:21:19'),
            ( 'close_day_treasuries', 'Office Treasuries', '2022-02-14 10:57:41'),
            ( 'start_day_treasuries', 'Office Treasuries', '2022-02-14 11:05:47'),
            ( 'sale', 'barriers', '2022-02-15 07:19:24'),
            ( 'close_day_barriers', 'barriers', '2022-02-15 07:27:30'),
            ( 'start_day_barriers', 'barriers', '2022-02-15 07:27:50'),
            ( 'sales_report', 'reports', '2022-08-16 10:39:30'),
            ( 'bank_report', 'reports', '2022-08-23 07:15:32'),
            ( 'MOI', 'MOI', '2022-09-04 06:17:07'),
            ( 'treasury_report', 'reports', '2022-09-14 06:29:44'),
            ('list_emp_vac_balance','emp_vac_balance','عرض أرصدة اجازات الموظف'),
            ('add_emp_vac','emp_vacatiion','إضافة اجازة للموظف'),
            ('edit_emp_vac','emp_vacatiion','تعديل اجازة الموظف'),
            ('list_emp_vac','emp_vacatiion','عرض قائمة الاجازات للموظف'),
            ('approve_emp_vac','emp_vacatiion','تأكيد حالة الاجازة للموظف')
        
        ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
       $this->addSql('TRUNCATE TABLE permissions');
    }
}
