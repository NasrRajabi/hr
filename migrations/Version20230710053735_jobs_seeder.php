<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230710053735_jobs_seeder extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        
        $this->addSql("INSERT INTO jobs (org_job, job_title, job_title_e, job_desc)
                       VALUES
                            ('91','مدير عام',NULL,NULL),
                            ('92','مدير',NULL,NULL),
                            ('93','رئيس قسم',NULL,NULL),
                            ('94','رئيس شعبة',NULL,NULL),
                            ('95','مبرمج',NULL,NULL),
                            ('96','مساعد رئيس شعبة',NULL,NULL),
                            ('97','نائب مدير عام',NULL,NULL),
                            ('98','رئيس',NULL,NULL),
                            ('99','مستشار للوزير',NULL,NULL),
                            ('910','مدير مكتب',NULL,NULL),
                            ('911','مهندس',NULL,NULL),
                            ('912','مهندس اتصالات',NULL,NULL),
                            ('913','مهندس حاسوب',NULL,NULL),
                            ('914','مهندس كهرباء',NULL,NULL),
                            ('915','مبرمج جامعي',NULL,NULL),
                            ('916','مدير بريد فئة أ',NULL,NULL),
                            ('917','مدير بريد فئة ب',NULL,NULL),
                            ('918','مدير بريد فئة ج',NULL,NULL),
                            ('919','موزع بريد',NULL,NULL),
                            ('920','مسؤول شباك بريد',NULL,NULL),
                            ('921','مساعد اداري',NULL,NULL),
                            ('922','موظف اداري',NULL,NULL),
                            ('923','محاسب',NULL,NULL),
                            ('924','موظف حاسوب',NULL,NULL),
                            ('925','موظف فرز',NULL,NULL),
                            ('926','موظف صيانه',NULL,NULL),
                            ('927','مامور تسهيلات',NULL,NULL),
                            ('928','اداري',NULL,NULL),
                            ('929','سائق',NULL,NULL),
                            ('930','سائق ومرافق',NULL,NULL),
                            ('931','مساعد قانوني',NULL,NULL),
                            ('932','مستشار قانوني مساعد',NULL,NULL),
                            ('933','مراسل',NULL,NULL),
                            ('934','سكرتاريا',NULL,NULL),
                            ('935','كاتب',NULL,NULL),
                            ('936','مدخل بيانات',NULL,NULL),
                            ('937','امين مستودع',NULL,NULL),
                            ('938','باحث ميداني',NULL,NULL),
                            ('939','موظف اعلام',NULL,NULL),
                            ('940','موظف استعلامات',NULL,NULL),
                            ('941','موظف مواصفات',NULL,NULL),
                            ('942','موظف مالي',NULL,NULL),
                            ('943','موظف تسويق',NULL,NULL),
                            ('944','مهندس الكتروني واتصالات',NULL,NULL),
                            ('945','مراقب',NULL,NULL),
                            ('946','مهني أ',NULL,NULL),
                            ('947','بدون',NULL,NULL),
                            ('948','ق.أ مدير عام',NULL,NULL),
                            ('949','عامل تنظيفات',NULL,NULL),
                            ('950',' مدير',NULL,NULL),
                            ('951','نائب مدير',NULL,NULL),
                            ('952','ق.أ رئيس',NULL,NULL),
                            ('953','ق.أ وكيل الوزارة',NULL,NULL),
                            ('954','مأمور فرز',NULL,NULL),
                            ('955','خبير بريدي',NULL,NULL),
                            ('956','خبير اتصالات',NULL,NULL),
                            ('957','خبير IT',NULL,NULL),
                            ('958','موظف ارشيف',NULL,NULL),
                            ('959','موظف خدمات إدارية',NULL,NULL),
                            ('960','عامل',NULL,NULL),
                            ('961','مهندس ميكاترونكس',NULL,NULL),
                            ('962','موظف علاقات عامة',NULL,NULL),
                            ('963','ق. أ. الوكيل',NULL,NULL),
                            ('964','ق.ا مدير',NULL,NULL),
                            ('965','ق.ا نائب',NULL,NULL),
                            ('966','مستشار الوزير لشؤون الاتصالات',NULL,NULL),
                            ('967','مشرف',NULL,NULL),
                            ('968','ق.أ وحدة النوع الاجتماعي',NULL,NULL),
                            ('9100','وزير',NULL,NULL),
                            ('9101','مستشار قانوني',NULL,NULL),
                            ('9102','نائب رئيس',NULL,NULL),
                            ('9103','فني تكييف وتبريد',NULL,NULL),
                            ('9104','فني صيانة',NULL,NULL),
                            ('9105','موظف استقبال',NULL,NULL),
                            ('9106','مترجم',NULL,NULL),
                            ('9107','رئيس وحدة البنك الدولي',NULL,NULL),
                            ('9108','باحث اقتصادي',NULL,NULL),
                            ('9109','باحث قانوني',NULL,NULL),
                            ('9110','ق. أ. نائب مدير عام',NULL,NULL),
                            ('9111','فني كمال اجسام',NULL,NULL),
                            ('101','وكيل',NULL,NULL),
                            ('102','مدير عام',NULL,NULL),
                            ('103','نائب مدير عام',NULL,NULL),
                            ('104','مدير دائرة',NULL,NULL),
                            ('105','نائب مدير',NULL,NULL),
                            ('106','رئيس قسم',NULL,NULL),
                            ('107','مساعد رئيس قسم',NULL,NULL),
                            ('108','رئيس شعبة',NULL,NULL),
                            ('109','مساعد رئيس شعبة',NULL,NULL),
                            ('1010','مبرمج',NULL,NULL),
                            ('1011','رئيس وحدة',NULL,NULL),
                            ('1012','مستشار الوزير',NULL,NULL),
                            ('1013','مدير مكتب',NULL,NULL),
                            ('1014','مدير',NULL,NULL),
                            ('1015','ق.أ الادارة العامة',NULL,NULL),
                            ('1016','موظف اداري',NULL,NULL),
                            ('1017','بدون',NULL,NULL),
                            ('1018','مهندس حاسوب',NULL,NULL),
                            ('1019','مدير مكتب بريد فرعي (أ), نائب مدير',NULL,NULL),
                            ('1020','مدير مكتب بريد فرعي (ب), رئيس قسم',NULL,NULL),
                            ('1021','مدير مكتب بريد فرعي(ج), رئيس شعبة',NULL,NULL),
                            ('1022','مساعد اداري',NULL,NULL),
                            ('1023','سائق',NULL,NULL),
                            ('1024','مراسل',NULL,NULL),
                            ('1025','عامل نظافة',NULL,NULL),
                            ('10100','وزير',NULL,NULL),
                            ('10106','ق.أ الادارة العامة للحكومة الالكترونية',NULL,'لغايات العمل على المذكرات الداخلية'),
                            ('10107','ق.أ الادارة العامة للحاسوب الحكومي',NULL,'لغايات العمل على المذكرات الداخلية'),
                            ('10108','ق.أ الادارة العامة للبريد',NULL,'لغايات العمل على المذكرات الداخلية'),
                            ('10109','ق.أ نائب الادارة العامة للتراخيص',NULL,'لغايات العمل على المذكرات الداخلية')
                        "
        );
        
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE jobs');
    }
}
