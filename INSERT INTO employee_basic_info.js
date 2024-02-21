INSERT INTO employee_basic_info
                        (employee_no, f_name, s_name, t_name, l_name, en_name, gender, religion, birthday, birthplace, nationality, national_id
                        , passport_no, marital_status, disability, disability_desc,attendance_agreements_id, password, active ) 
SELECT 
    EMP_ID
    ,split_part(emp_a_name, ' ', 1) 
    ,split_part(emp_a_name, ' ', 2) 
    ,split_part(emp_a_name, ' ', 3) 
    ,split_part(emp_a_name, ' ', 4)
    , COALESCE(EMP_L_NAME,'')
    , CAST(GENDER AS INTEGER)
    ,COALESCE(CAST(RELIGION AS INTEGER),1) 
    , COALESCE(DATE_BIRTH,'1960/01/01')
    , COALESCE(PLACE_BIRTH,'')
    , 1
    , COALESCE(ID_NUMBER,'')
    , ''
    , COALESCE(CAST(M_STATUS AS INTEGER),1)
    , COALESCE(HAS_INJURY_YN,'')
    , ''
    , 1
    , '$pass' 
    , true
FROM 
    att_emp
WHERE 
    EMP_ID != '168139'


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   INSERT INTO employee_addresses_info
    (employee_id, address, city, region, street, postal_code) 
    SELECT 
        employee_basic_info.id
      , att_emp.address
      , CASE att_emp.city_no 
            WHEN '103' THEN 1
            WHEN '101' THEN 2
            WHEN '102' THEN 3
            WHEN '106' THEN 4
            WHEN '107' THEN 5
            WHEN '105' THEN 6
            WHEN '108' THEN 7
            WHEN '109' THEN 8
            WHEN '114' THEN 9
            WHEN '115' THEN 10
            WHEN '104' THEN 12
            WHEN '113' THEN 13
            WHEN '11' THEN  14
            WHEN '111' THEN 15
            WHEN '110' THEN 16
            ELSE 0
        END city

      , ''
      , ''
      , ''
    FROM
        att_emp
      , employee_basic_info
    WHERE
        employee_basic_info.employee_id = att_emp.emp_id 
        
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

INSERT INTO os
    ( parent_id, node_level, dept_type, name ) 
SELECT
    ITEM_TYPE
    
INSERT INTO att_org_items (ITEM_TYPE,ITEM_ID,ITEM_A_NAME,ITEM_L_NAME,ITEM_DESC,USER_NO,TIME_STAMP,TEMP) 


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    INSERT INTO employee_job_info
        (employee_id, contract_type, job_title, general_management, department, division, div, class, grade, job_start_date, job_end_date)
    SELECT 
        employee_basic_info.id
       ,CONTRACT_ID
       ,JOB_CODE
       ,
    
    FROM
        att_emp
      , employee_basic_info
    WHERE
        employee_basic_info.employee_id = att_emp.emp_id 
         