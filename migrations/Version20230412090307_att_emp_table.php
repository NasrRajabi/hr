<?php

declare(strict_types=1);

namespace HR\Migrations;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230412090307_att_emp_table extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {


        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('att_emp');
        $table->addColumn('EMP_ID', Types::INTEGER);
        $table->addColumn('EMP_A_NAME', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('EMP_L_NAME', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('BADGE_NO',  Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('START_WORK_DATE', Types::DATE_MUTABLE)->setNotnull(false)->setDefault(null);
        $table->addColumn('REAL_WORK_DATE', Types::DATE_MUTABLE)->setNotnull(false)->setDefault(null);
        $table->addColumn('END_WORK_DATE', Types::DATE_MUTABLE)->setNotnull(false)->setDefault(null);
        $table->addColumn('AG_NO', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('ID_NUMBER',  Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('COUNTRY_NO', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('CITY_NO', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('ADDRESS',   Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('PLACE_BIRTH',Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('DATE_BIRTH', Types::DATE_MUTABLE)->setNotnull(false)->setDefault(null);
        $table->addColumn('HOME_PHONE', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('PEL_PHONE', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('EMERGENCY_PHONE',  Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('EMAIL', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('GENDER', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('M_STATUS', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('BANK_NO', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('BANK_ACCOUNT',  Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('T_ID', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('PUNCH', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('EMP_STATUS',Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('LICENCE_NO', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('BLOOD_GROUP', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('EMERGENCY_PERSON', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('USER_NO', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('TIME_STAMP',  Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('IMAGE', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('RELIGION', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('NUMBEROFCHILDREN', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('HOUSERENT', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('NSTUDENT',  Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('NDEPENDANTS', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('SPOUSESNAME', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('SPOUSEID', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('SPOUSEDATEOFBIRTH',   Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('STREET',Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('SALARY_TYPE', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('HAVE_STEP', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('TAXABLE', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('SPOUSE_WORK',  Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('RESIDENCE', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('BRANCH_NO', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('MANULA_TAX', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('MANUAL_TAX', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('DEPT_NO',  Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('SHOW_ATTENDANCE_REP', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('BUILD_HOUSE', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('REQUEST_NO',   Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('CODE_ACC',Types::STRING)->setNotnull(false)->setDefault(null);        
        $table->addColumn('FILE_NO', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('BANK_CO', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('SAL_CAT_ALLOWANCES', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('CONTRACT_ID',  Types::INTEGER)->setNotnull(false)->setDefault(null);
        $table->addColumn('HAS_INS_YN', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('HAS_INJURY_YN', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('PROF_PRACTICING', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('END_CONTRACT_DATE', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('STUD_APPROVE',  Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('STUD_APPROVE_TILL_DATE', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('MEMBER_ID', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('VILLAGE_NAME',   Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('SHOW_ABSENCE_REP',Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('DEPT_TREE', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('BANK_BRANCH_NO', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('EMP_IMAGE', Types::BLOB)->setNotnull(false)->setDefault(null);
        $table->addColumn('PHONE_EXT',  Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('PREV_LATES', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('JOB_CODE', Types::STRING)->setNotnull(false)->setDefault(null);
        $table->addColumn('IBAN_NO', Types::STRING)->setNotnull(false)->setDefault(null);
       
        $table->setPrimaryKey(['EMP_ID']);
        //$table->addUniqueConstraint(['EMP_ID']);

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('att_emp');

    }
}
