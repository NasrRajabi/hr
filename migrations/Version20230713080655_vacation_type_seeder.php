<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230713080655_vacation_type_seeder extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
       
        $this->addSql("INSERT INTO vacation_type 
                        (vacation_name
                        ,vacation_symbol
                        ,vac_in_sal
                        ,user_id
                        ,time_stamp
                        ,vac_name_e
                        ,note
                        ,vac_type
                        ,vac_days
                        ,show_slip
                        ,add_holiday
                        ,religion
                        ,from_year
                        ,to_year
                        ,percent_vac
                        ,without_sal_vac_process_way
                        ,gender
                        ,selected
                        ,vacation_symbol_e
                        ,show_on_in_out_sheet
                        ,vac_years
                        ,show_on_portal)
                        Values
                        ('اجازة سنوية','اجازة ع','N','1',NULL,'طلب اجازة عادية 30 يوم',NULL,'1',0,'0','1','0','0','60','100',4,'0',NULL,'L',1,1,1),
                        ('اجازه مرضيه','مرضيه','N','1',NULL,NULL,NULL,'2',14,'1','1','0','0','60','100',4,'0',NULL,'S',1,1,1),
                        ('اجازة حج','حج','N','1',TO_DATE('2016-03-31 00:00:00', 'YYYY-MM-DD HH24:MI:SS'),NULL,NULL,'4',30,'1','1','1','0','60','100',4,'0',NULL,'H',0,1,1),
                        ('اجازه امومه','امومة','N','1',TO_DATE('2016-01-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS'),NULL,NULL,'5',70,'1','1','0','0','60','100',4,'2',NULL,'M',0,1,1),
                        ('اجازة ابوة','ابوة','N','1',TO_DATE('2016-01-28 00:00:00', 'YYYY-MM-DD HH24:MI:SS'),NULL,NULL,'5',30,'0','1','0','0','60','100',4,'0',NULL,'Y',0,3,1),                        
                        ('إجازة عارضة','عارضة','N','1',NULL,NULL,NULL,'5',10,'1','1','0','0','60','100',4,'0',NULL,'T',1,1,1),
                        ('اجازه بدون راتب','بدون راتب','N','1',NULL,NULL,NULL,'3',0,'1','1','0','0','60','100',4,'0',NULL,'W',1,1,1),                                               
                        ('حسم من الراتب','حسم','N','1',TO_DATE('2016-01-28 00:00:00', 'YYYY-MM-DD HH24:MI:SS'),NULL,NULL,'5',10,'0','1','0','0','60','100',4,'0',NULL,'Z',0,3,1),                        
                        ('اجازة وفاة','D','N','1',TO_DATE('2016-06-30 00:00:00', 'YYYY-MM-DD HH24:MI:SS'),NULL,NULL,'5',NULL,'1','1','0','0','60','100',4,'0',NULL,'D',0,1,1),
                        ('مهمة عمل','مهمة عمل','N','1',TO_DATE('2021-04-20 04:41:36', 'YYYY-MM-DD HH24:MI:SS'),NULL,NULL,'5',0,'1','1','0','0','30','100',4,'0',NULL,'R',1,1,1)                                                
                    ");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE vacation_type');
    }
}
