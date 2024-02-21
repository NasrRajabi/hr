<?php

declare(strict_types=1);

use App\Application\Actions\MenuItems\DeleteMenuItemsAction;
use App\Application\Actions\MenuItems\StoreMenuItemsAction;
use App\Application\Actions\MenuItems\UpdateMenuItemsAction;
use Slim\App;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Application\Actions\Os\{StoreAction, ViewOsAction, GetUserDetailsAction, AssignOSViewAction};

use App\Application\Middleware\{AuthMiddleware, OthMiddleware, AuthOSMiddleware};
use App\Application\Middleware\GuestMiddleware;

use App\Application\Actions\Home\ViewHomeAction;
use App\Application\Actions\Auth\{LoginAction, ViewLoginAction, LogoutAction, LoginOSAction, ViewLoginOSAction, LogoutOsAction, SwitchOSAction};

use App\Application\Actions\Home\ViewHome2Action;
use App\Application\Actions\Leave\AddLeaveAction;// اضافة المغادره
use App\Application\Actions\Leave\AddEmpLeaveAction;
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\Leave\ListLeaveAction;//اجراءات المغادره
use App\Application\Actions\Leave\StoreLeaveAction;// حفظ المغادره 
use App\Application\Actions\Leave\ListLeaveSearchAction;// بحث المغادره ListAttendanceAction
use App\Application\Actions\Leave\ApproveLeaveAction;
use App\Application\Actions\Duration\ListAttendanceAction;
use App\Application\Actions\Duration\DetailAttendanceAction;
use App\Application\Actions\JobAssignment\AddJobAssignmentAction;
use App\Application\Actions\JobAssignment\AddoutJobAssignmentAction;
use App\Application\Actions\JobAssignment\StoreJobAssignmentAction;
use App\Application\Actions\JobAssignment\ListJobAssignmentAction;
use App\Application\Actions\JobAssignment\ListJopAssignmentSearchAction;
use App\Application\Actions\JobAssignment\UpdateJobAssignmentAction;
use App\Application\Actions\JobAssignment\EditJobAssignmentAction;
use App\Application\Actions\JobAssignment\CustomizeJobAssignmentAction;
use App\Application\Actions\JobAssignment\StoreCustomizeJobAssignmentAction;
use App\Application\Actions\JobAssignment\DecisionJobAssignmentAction;
use App\Application\Actions\VacationsCrediting\AddVacationsCreditingAction;
use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Employee\{AddEmployeeAction, ViewProfileAction};
use App\Application\Actions\Setting\ListVacationAction;

use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\Attendance\EditDeviceAction;
use App\Application\Actions\Attendance\StoreDeviceAction;
use App\Application\Actions\Employee\StoreEmployeeAction;
use App\Application\Actions\Dashboard\ViewDashboardAction;

use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Application\Actions\Attendance\StoreAttendanceLogs;
use App\Application\Actions\Attendance\ViewAttendanceAction;

use App\Application\Actions\Attendance\AttendanceSetTimeAction;
use App\Application\Actions\Employee\ViewEmployeeDashboardAction;
use App\Application\Actions\Employee\{ViewAllEmployeesAction};
use App\Application\Actions\EmployeeOS\{AssignePositionAction, GetUserOSAction, EndUserOSAction, DelegateAction, DelegateActionPost, GetUserDelegationAction, EditUserDelegationAction};

use App\Application\Actions\Attendance\AttendanceCheckVoiceAction;
use App\Application\Actions\Attendance\AttendanceRemoveUserAction;
use App\Application\Actions\Attendance\ViewAttendanceDevicesAction;
use App\Application\Actions\Attendance\AttendanceDeviceGetUserAction;
use App\Application\Actions\Attendance\AttendanceDeviceRestartAction;
use App\Application\Actions\Attendance\AttendanceDeviceSetUserAction;
use App\Application\Actions\AttendanceAgreements\EditAgreementsAction;
use App\Application\Actions\AttendanceAgreements\StoreAgreementAction;
use App\Application\Actions\AttendanceAgreements\ViewAgreementsAction;
use App\Application\Actions\AttendanceAgreements\CreateAgreementAction;
use App\Application\Actions\Attendance\AttendanceDeviceCheckConnectAction;
use App\Application\Actions\Attendance\AttendanceAllDeviceCheckConnectAction;

use App\Application\Actions\AttendanceAgreements\UpdateAgreementsAction;
use App\Application\Actions\Duration\ListEmployeeAttendanceAction;
use App\Application\Actions\Menu\AddMenuAction;
use App\Application\Actions\Menu\DeleteMenuAction;
use App\Application\Actions\Menu\DetailsMenuAction;
use App\Application\Actions\Menu\EditMenuAction;
use App\Application\Actions\Menu\StoreMenuAction;
use App\Application\Actions\Menu\UpdateMenuAction;
use App\Application\Actions\Menu\ViewMenusAction;
use App\Application\Actions\MenuItems\ViewMenuItemsAction;
use App\Application\Actions\OfficialReach\ListGovEmailAction;
use App\Application\Actions\OfficialReach\ListGovMobileAction;
use App\Application\Actions\OfficialReach\ListGovTelAction;
use App\Application\Actions\OfficialReach\ListOfficialReachAction;
use App\Application\Actions\OfficialReach\StoreGovEmailAction;
use App\Application\Actions\OfficialReach\StoreGovMobileAction;
use App\Application\Actions\Role\{ViewRolesAction, EditRoleAction, UpdateRoleAction, AddRoleAction, StoreRoleAction, DetailsRoleAction, DeleteRoleAction };
use App\Application\Actions\Permissions\{ViewPermissionsAction, EditPermissionsAction,
    UpdatePermissionsAction, AddPermissionsAction, StorePermissionsAction, DeletePermissionAction };

use App\Application\Actions\Vacation\PrintEmpVacationAction;
use App\Application\Actions\Vacation\StoreEmpVacationAction;
use App\Application\Actions\Vacation\ListEmpVacBalanceAction;
use App\Application\Actions\Vacation\ApproveEmpVacationAction;
use App\Application\Actions\Vacation\ListEmpVacationSearchAction;
use App\Application\Actions\Vacation\EmpVacationTypeBalanceAction;
use App\Application\Actions\Vacation\EditEmpVacationAction;
use App\Application\Actions\Vacation\ListEmpVacationAction;
use App\Application\Actions\Vacation\AddEmpVacationAction;
use App\Application\Actions\Vacation\EmpVacationAction;
use App\Application\Actions\Vacation\ListAllManTOEmpAction;
use App\Application\Actions\Vacation\ListManTOEmpVacBalAction;
use App\Application\Actions\Vacation\ListManTOEmpVacationAction;
use App\Application\Actions\Vacation\ManTOEmpVacBalAction;
use App\Application\Actions\Vacation\AddManTOEmpVacAction;
use App\Application\Actions\Auth\ViewLoginFirstAction;
use App\Application\Actions\Auth\LoginFirstAction;
use App\Application\Actions\Duration\EmployeeDailyAttendanceReportAction;
use App\Application\Middleware\AuthFirstMiddleware;

use App\Application\Actions\Movement\ListMovementAction;
use App\Application\Actions\Movement\StoreMovementAction;
use App\Application\Actions\Movement\AddMovementAction;
use App\Application\Actions\Movement\EditMovementAction;
use App\Application\Actions\Movement\UpdateMovementAction;
use App\Application\Actions\Movement\EndMovementAction;

use App\Application\Actions\Vehicle\AddVehicleAction;
use App\Application\Actions\Vehicle\StoreVehicleAction;
use App\Application\Actions\Vehicle\ListVehicleAction;
use App\Application\Actions\Vehicle\UpdateVehicleAction;
use App\Application\Actions\Vehicle\EditVehicleAction;

use App\Application\Actions\Invoice\AddInvoiceAction;
use App\Application\Actions\Invoice\StoreInvoiceAction;
use App\Application\Actions\Invoice\ListInvoiceAction;
use App\Application\Actions\Invoice\EditInvoiceAction;
use App\Application\Actions\Invoice\UpdateInvoiceAction;
use App\Application\Actions\Invoice\EndInvoiceAction;


return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

  
    $app->group('/login', function (Group $group) {
        $group->get('', ViewLoginAction::class);
        $group->get('/x', ViewLoginAction::class);
        $group->post('', LoginAction::class);
    })->add(GuestMiddleware::class);

    $app->group('/login_os', function (Group $group) {
        $group->get('', ViewLoginOSAction::class);
        $group->post('', LoginOSAction::class);
    })->add(AuthOSMiddleware::class);

    $app->group('/login_first', function (Group $group) {
        $group->get('', ViewLoginFirstAction::class);
        $group->post('', LoginFirstAction::class);
    })->add(AuthFirstMiddleware::class);

    $app->get('/', ViewDashboardAction::class)->add(AuthMiddleware::class);
    $app->get('/dashboard', ViewDashboardAction::class)->add(AuthMiddleware::class);

    $app->get('/logout', LogoutAction::class)->add(AuthMiddleware::class);
    $app->get('/logout_os', LogoutOSAction::class)->add(AuthOSMiddleware::class);
    $app->get('/switch_os', SwitchOSAction::class)->add(AuthMiddleware::class);

    $app->get('/employee_dash', ViewEmployeeDashboardAction::class)->add(AuthMiddleware::class);

    

    $app->group('/employee', function (Group $group) {
        // TODO_Aya: add permission to this route
        $group->get('', ListUsersAction::class);
       // $group->get('{id}', ViewUserAction::class);       
        $group->get('/add', AddEmployeeAction::class)->setArgument("permission", 'add_new_employee')->add(OthMiddleware::class);
        $group->post('/add', StoreEmployeeAction::class)->setArgument("permission", 'add_new_employee')->add(OthMiddleware::class);
        //TODO_Aya: do we need this route 
        $group->get('/profile', ViewProfileAction ::class)->setArgument("permission", 'view_profile')->add(OthMiddleware::class);
        $group->get('/profile/{id}', ViewProfileAction ::class)->setArgument("permission", 'view_employee_profile')->add(OthMiddleware::class);
        $group->get('/all',ViewAllEmployeesAction ::class)->setArgument("permission", 'view_employee_list')->add(OthMiddleware::class);
        // TODO_Aya: [:no]
        $group->get('/assigne_position/{no}', AssignePositionAction ::class)->setArgument("permission", 'assigne_end_os')->add(OthMiddleware::class);
        $group->post('/get_user_os', GetUserOSAction ::class)->setArgument("permission", 'assigne_end_os')->add(OthMiddleware::class);
        $group->post('/end_user_os', EndUserOSAction ::class)->setArgument("permission", 'assigne_end_os')->add(OthMiddleware::class);
    })->add(AuthMiddleware::class);

    $app->group('/os', function (Group $group) {
        $group->post('/add', StoreAction::class)->setArgument("permission", 'add_os')->add(OthMiddleware::class);
        $group->get('/view', ViewOsAction::class)->setArgument("permission", 'view_os')->add(OthMiddleware::class);
        #TODO_Aya: check permission work on json calls?
        $group->post('/get_user', GetUserDetailsAction::class)->setArgument("permission", 'assigne_end_os')->add(OthMiddleware::class);
        $group->post('/assigne_end_os', AssignOSViewAction ::class)->setArgument("permission", 'assigne_end_os')->add(OthMiddleware::class);
    })->add(AuthMiddleware::class);

    $app->group('/delegate', function (Group $group) {
        $group->get('/[:no]', DelegateAction::class)->setArgument("permission", 'view_os_delegation')->add(OthMiddleware::class);
        $group->post('/save_delegate', DelegateActionPost::class)->setArgument("permission", 'save_os_delegation')->add(OthMiddleware::class);
        //TODO_Aya: check if view history have same permission for view page
        $group->post('/get_user_delegation', GetUserDelegationAction::class)->setArgument("permission", 'view_os_delegation')->add(OthMiddleware::class);
        $group->post('/edit_user_delegate', EditUserDelegationAction::class)->setArgument("permission", 'edit_user_delegation')->add(OthMiddleware::class);
    })->add(AuthMiddleware::class);
//////////////////////////Omar Leave///////////////////////////////////////////////////

    $app->group('/movement', function (Group $group) {
        $group->get('/list', ListMovementAction::class);
        $group->get('/add', AddMovementAction::class);
        $group->post('/store', StoreMovementAction::class);
        $group->post('/update/{id}', UpdateMovementAction::class);
        $group->post('/update_end/{id}', EndMovementAction::class);
        $group->get('/edit/{id}', EditMovementAction::class);
    });
    $app->group('/vehicle', function (Group $group) {
        $group->get('/list', ListVehicleAction::class);
        $group->get('/add', AddVehicleAction::class);
        $group->post('/store', StoreVehicleAction::class);
        $group->post('/update/{id}', UpdateVehicleAction::class);
        $group->get('/edit/{id}', EditVehicleAction::class);
        // $group->post('/add', StoreMovementAction::class)->setArgument("permission", 'add_leave')->add(OthMiddleware::class);
    });

    
    $app->group('/invoice', function (Group $group) {
       
        $group->get('/add', AddInvoiceAction::class);
        $group->post('/store', StoreInvoiceAction::class);
        $group->get('/list', ListInvoiceAction::class);
        $group->get('/edit/{id}', EditInvoiceAction::class);
        $group->post('/update/{id}', UpdateInvoiceAction::class);
        $group->post('/update_end/{id}', EndInvoiceAction::class);
    });






$app->group('/leave', function (Group $group) {
   $group->get('/list', ListLeaveAction::class)->setArgument("permission", 'view_leave_list')->add(OthMiddleware::class);
   $group->post('/add', StoreLeaveAction::class)->setArgument("permission", 'add_leave')->add(OthMiddleware::class);
   $group->get('/add', AddLeaveAction::class)->setArgument("permission", 'add_leave')->add(OthMiddleware::class);
   $group->get('/addemp', AddEmpLeaveAction::class)->setArgument("permission", 'view_users_leave')->add(OthMiddleware::class);
   $group->get('/getleave/{id}/{sts}', ApproveLeaveAction::class)->setArgument("permission", 'update_leave_status')->add(OthMiddleware::class);
   $group->get('/listLeave/{sts}/{leave_type}/{start_date}/{end_date}', ListLeaveSearchAction::class)->setArgument("permission", 'search_leaves')->add(OthMiddleware::class); 
});//->add(AuthMiddleware::class);
//////////////////////////Omar duration  ///////////////////////////////////////////////////
$app->group('/duration', function (Group $group) {
    $group->get('/attendance', ListAttendanceAction::class)->setArgument("permission", 'view_all_users_attendance')->add(OthMiddleware::class);
    $group->get('/emp_att_calendar/{id}', ListEmployeeAttendanceAction::class)->setArgument("permission", 'view_user_attendance')->add(OthMiddleware::class);
    $group->get('/report', EmployeeDailyAttendanceReportAction::class)->setArgument("permission", 'get_users_attendance_report')->add(OthMiddleware::class);  
    $group->get('/detail/{id}', DetailAttendanceAction::class)->setArgument("permission", 'view_user_attendance_details')->add(OthMiddleware::class);    
});
    ////////////////////////Omar job assignment in and out///////////////////////////////////////////
    $app->group('/job_assignment', function (Group $group) {
        $group->get('/add', AddJobAssignmentAction::class);
        $group->get('/addout', AddoutJobAssignmentAction::class);
        $group->post('/update/{id}', UpdateJobAssignmentAction::class);//->setArgument("permission", 'update_jobassignment')->add(OthMiddleware::class);
        $group->get('/edit/{id}', EditJobAssignmentAction::class);//->setArgument("permission", 'edit_jobassignment')->add(OthMiddleware::class);
        $group->get('/customize/{id}', CustomizeJobAssignmentAction::class);//->setArgument("permission", 'customize_jobassignment')->add(OthMiddleware::class);
        $group->post('/storecustomize/{id}', StoreCustomizeJobAssignmentAction::class);//->setArgument("permission", 'storeustomize_jobassignment')->add(OthMiddleware::class);
        $group->post('/store', StoreJobAssignmentAction::class);//->setArgument("permission", 'customize_jobassignment')->add(OthMiddleware::class);
        $group->get('/list', ListJobAssignmentAction::class);
        $group->get('/list1/{sts}/{date1}/{date2}', ListJopAssignmentSearchAction::class);
        $group->get('/approve/{id}/{dec}', DecisionJobAssignmentAction::class);//->setArgument("permission", 'approve_jobassignment')->add(OthMiddleware::class);
    });
     ////////////////////////Omar vacations crediting///////////////////////////////////////////
     $app->group('/vacations_crediting', function (Group $group) {
        $group->get('/add', AddVacationsCreditingAction::class);//->setArgument("permission", 'vacations_crediting')->add(OthMiddleware::class);
               
    });
    /////////////////////////////////////////////////////////////////////

    // $app->group('/home', function (Group $group) {
    //     $group->get('', ViewHomeAction::class);
    //     $group->get('/home2', ViewHome2Action::class);
    // });
    $app->get('/home', ViewHomeAction::class);
    $app->get('/home2', ViewHome2Action::class);


    /////////////////////////////////////////////////////////////////////




    $app->group('/attendance', function (Group $group) {
        $group->get('/monitoring', ViewAttendanceAction::class);
        
        $group->get('/devices', ViewAttendanceDevicesAction::class)->setArgument("permission", 'view_devices')->add(OthMiddleware::class);
        $group->post('/devices/add', StoreDeviceAction::class)->setArgument("permission", 'add_device')->add(OthMiddleware::class);
        $group->post('/devices/edit', EditDeviceAction::class)->setArgument("permission", 'edit_device')->add(OthMiddleware::class);
       
        $group->get('/zktest', ViewAttendanceAction::class);
        $group->post('/devices/transfer_data', StoreAttendanceLogs::class)->setArgument("permission", 'transfer_data')->add(OthMiddleware::class);       
        $group->post('/devices/check_connect', AttendanceDeviceCheckConnectAction::class)->setArgument("permission", 'check_connect')->add(OthMiddleware::class);
        $group->post('/devices/set_time', AttendanceSetTimeAction::class)->setArgument("permission", 'set_time')->add(OthMiddleware::class);
        $group->post('/devices/get_user', AttendanceDeviceGetUserAction::class)->setArgument("permission", 'get_user')->add(OthMiddleware::class);
        $group->post('/devices/set_user', AttendanceDeviceSetUserAction::class)->setArgument("permission", 'set_user')->add(OthMiddleware::class);
        $group->post('/devices/restart', AttendanceDeviceRestartAction::class)->setArgument("permission", 'restart')->add(OthMiddleware::class);
        $group->post('/devices/check_voice', AttendanceCheckVoiceAction::class)->setArgument("permission", 'check_voice')->add(OthMiddleware::class);
        $group->post('/devices/remove_user', AttendanceRemoveUserAction::class)->setArgument("permission", 'remove_user')->add(OthMiddleware::class);
    })->add(AuthMiddleware::class);
   


    $app->group('/setting', function (Group $group) {
        $group->get('/vacationList', ListVacationAction::class);
    });//->add(AuthMiddleware::class);
    
    $app->group('/official_reach', function (Group $group) {
        $group->get('/gov_email', ListGovEmailAction::class);
        $group->post('/gov_email/add', StoreGovEmailAction::class);
        $group->get('/gov_mobile', ListGovMobileAction::class);
        $group->post('/gov_mobile/add', StoreGovMobileAction::class);
        $group->get('/gov_tel', ListGovTelAction::class);
        $group->post('/gov_tel/add', StoreGovTelAction::class);
    });//->add(AuthMiddleware::class);

    $app->group('/attendance_agreements', function (Group $group) {
        $group->get('/agreement_list', ViewAgreementsAction::class);
        $group->get('/edit/{id}', EditAgreementsAction::class);
        $group->post('/edit', UpdateAgreementsAction::class);
        $group->get('/create', CreateAgreementAction::class);
        $group->post('/create', StoreAgreementAction::class);
    });//->add(AuthMiddleware::class);


    $app->group('/vacation', function (Group $group) {
        $group->get('/listEmpVacBalance',ListEmpVacBalanceAction::class);//->setArgument("permission", 'list_emp_vac_balance')->add(OthMiddleware::class);
        $group->get('/addEmpVacation',AddEmpVacationAction::class);//->setArgument("permission", 'add_emp_vac')->add(OthMiddleware::class);
        $group->post('/addEmpVacation',StoreEmpVacationAction::class);
        //$group->get('/editEmpVacation/{id}', EditEmpVacationAction::class);
        $group->post('/listEmpVacation', EditEmpVacationAction::class);
        $group->get('/listEmpVacation', ListEmpVacationAction::class);//->setArgument("permission", 'edit_emp_vac')->add(OthMiddleware::class); 
        $group->get('/approveEmpVacation/{id}/{sts}', ApproveEmpVacationAction::class);//->setArgument("permission", 'approve_emp_vac')->add(OthMiddleware::class);
        $group->get('/listEmpVacation/{sts}/{date1}/{date2}', ListEmpVacationSearchAction::class);//->setArgument("permission", 'list_emp_vac')->add(OthMiddleware::class);   

        $group->post('/get_balance', EmpVacationTypeBalanceAction::class);
        $group->post('/get_vacation', EmpVacationAction::class);
        $group->post('/getEmpVac', PrintEmpVacationAction::class);
        
        $group->get('/listManTOEmp',ListAllManTOEmpAction::class);//->setArgument("permission", 'list_all_vac_balance')->add(OthMiddleware::class);    
        $group->post('/listManTOEmp',AddManTOEmpVacAction::class);
        $group->post('/getEmpAllVacBal', ListManTOEmpVacBalAction::class);
        $group->get('/listManTOEmpVacation/{empID}',ListManTOEmpVacationAction::class);
        $group->post('/getManTOEmpVacBal', ManTOEmpVacBalAction::class);
        
    });//->add(AuthMiddleware::class);

    /* ******** Permissions ******** */
    $app->group('/permissions', function (Group $group) {
        // TODO_Aya: check if there are 'permissions' parameters used inside views and solve if it conflect with 'permissions' global parameter
        $group->get('', ViewPermissionsAction::class)->setArgument("permission", 'view_permissions')->add(OthMiddleware::class);
        
        $group->get('/edit/{id}', EditPermissionsAction::class)->setArgument("permission", 'edit_permission')->add(OthMiddleware::class);        
        $group->post('/edit', UpdatePermissionsAction::class)->setArgument("permission", 'edit_permission')->add(OthMiddleware::class); 
        
        $group->get('/add', AddPermissionsAction::class)->setArgument("permission", 'add_permission')->add(OthMiddleware::class);
        $group->post('/add', StorePermissionsAction::class)->setArgument("permission", 'add_permission')->add(OthMiddleware::class);

        $group->get('/delete/{id}', DeletePermissionAction::class)->setArgument("permission", 'delete_permission')->add(OthMiddleware::class);
    });//->add(AuthMiddleware::class);

    /* ******** roles ******** */
    $app->group('/roles', function (Group $group) {
        $group->get('', ViewRolesAction::class)->setArgument("permission", 'view_roles')->add(OthMiddleware::class);
        
        $group->get('/edit/{id}', EditRoleAction::class)->setArgument("permission", 'edit_role')->add(OthMiddleware::class);
        $group->post('/edit', UpdateRoleAction::class)->setArgument("permission", 'edit_role')->add(OthMiddleware::class);
        
        $group->get('/add', AddRoleAction::class)->setArgument("permission", 'add_role')->add(OthMiddleware::class);
        $group->post('/add', StoreRoleAction::class)->setArgument("permission", 'add_role')->add(OthMiddleware::class);

        $group->get('/details/{id}', DetailsRoleAction::class)->setArgument("permission", 'view_role')->add(OthMiddleware::class);
        $group->get('/delete/{id}', DeleteRoleAction::class)->setArgument("permission", 'delete_role')->add(OthMiddleware::class);
    });//->add(AuthMiddleware::class);

    
     /* ******** menus ******** */
     $app->group('/menus', function (Group $group) {
        $group->get('', ViewMenusAction::class);
        
        $group->get('/edit/{id}', EditMenuAction::class);// View
        $group->post('/edit', UpdateMenuAction::class);// Action
        
        $group->get('/add', AddMenuAction::class);// View
        $group->post('/add', StoreMenuAction::class);// Action

        $group->get('/delete/{id}', DeleteMenuAction::class);
    });//->add(AuthMiddleware::class);
     /* ******** menus ******** */
     $app->group('/menu_items', function (Group $group) {
        $group->get('/{id}', ViewMenuItemsAction::class);
        $group->post('/update/{id}', UpdateMenuItemsAction::class);

         $group->post('/add', StoreMenuItemsAction::class);// Action
         $group->get('/delete/{menu_id}/{id}', DeleteMenuItemsAction::class);// Action

    });//->add(AuthMiddleware::class);


    $app->get('/mpdf', function (Request $request, Response $response) {
        // Generate PDF using mPDF

        $html = '
        <html>
        <head>
            <meta charset="UTF-8">
        </head>
        <body>
            <h1>مرحبًا بك في العالم</h1>
            <p>هذا مثال لتوليد ملف PDF باللغة العربية باستخدام mPDF و Slim Framework.</p>
        </body>
        </html>
        ';
        
    
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'margin_top' => '0',
            'margin_bottom' => '0',
            'default_font' => 'Cairo'
          ]);

        $mpdf->charset_in = 'utf-8';
        $mpdf->showImageErrors = true;
        $mpdf->SetDirectionality('rtl');
 
        $mpdf->WriteHTML($html);
        return $mpdf->Output();
          
        // Output the PDF as a response
      //  $response->getBody()->write($mpdf->Output('', 'S'));
      //  return $response->withHeader('Content-Type', 'application/pdf');
    });

$app->get('/generate-pdf', function ($request, $response) {
    
//DejaVu Sans
$options = new Options();
$options->set('defaultFont', 'ArabicFont');
$options->set('chroot', realpath(''));
$dompdf = new Dompdf($options);

$Arabic = new ArPHP\I18N\Arabic();

$html = ' asem@gmail.com 12346  بسم الله الرحمن الرحيم';
$p = $Arabic->arIdentify($html);
for ($i = count($p)-1; $i >= 0; $i-=2) {
$utf8ar = $Arabic->utf8Glyphs(substr($html, $p[$i-1], $p[$i] - $p[$i-1]));
$html   = substr_replace($html, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
}
$dompdf->loadHtml("
<!DOCTYPE html>
<head><style>
@font-face {
    font-family: 'Cairo';
    src: url('../public/fonts/Cairo-VariableFont_slnt,wght.ttf') format('truetype');
  }
body{
    font-family: Cairo, sans-serif;
    font-size: 16px;
    text-align:right;
    
}

</style></head>
<body>
<header>
    <img src='../public/img/logo/header.png' width='100%' height='100%'/>
</header>
$html
</body></html>
");
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf -> stream("NEXAMPLE", array("Attachment" => false));
    return $response;
});


};


