<?php

declare(strict_types=1);

namespace App\Application\Actions\Vacation;

use Mpdf\Mpdf;
use Mpdf\Config\FontVariables;
use Mpdf\Config\ConfigVariables;

use Dompdf\Dompdf;
use Dompdf\Options;
use ArPHP\I18N\Arabic;

use App\Application\Actions\Action;
use App\Models\Vacation\VacationModel;
use App\Models\Employee\EmployeeJobInfoModel;
use App\Models\Employee\EmployeeBasicInfoModel;
use Psr\Http\Message\ResponseInterface as Response;

class PrintEmpVacationAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        $data = $this->request->getParsedBody();

        //$job_title = $this->lookups->get('job_title');

        //$vacation_types = $this->lookups->get('vacation_type');

        $vacation_status = $this->lookups->get('vacation_status');

        $annual_vacation_type = $this->lookups->get('annual_vacation_type');

        $vacationInfo = VacationModel::getVaction((int) $data['id']);

        $employee_id = $vacationInfo['result']->employee_id;

        $get_employee_basic = EmployeeBasicInfoModel::getEmpById((int) $employee_id);
        $get_employee_job = EmployeeJobInfoModel::getJobInfoById((int) $employee_id);

        $vacationInfo['result']->employee_no = $get_employee_basic['result']->employee_no;
        $vacationInfo['result']->employee_name = $get_employee_basic['result']->f_name . ' ' . $get_employee_basic['result']->s_name  . ' ' . $get_employee_basic['result']->l_name;
        $vacationInfo['result']->employee_job = $get_employee_job['result']->job_title;

       // $vacationInfo['result']->vac_type_name   = $vacation_types[$vacationInfo['result']->vacation_type];
       
        $vacationInfo['result']->vac_sts = $vacation_status[$vacationInfo['result']->vacation_status];

        if ($vacationInfo['result']->annual_vac_type != 0) {
          //  $vacationInfo['result']->vac_type_name   = $vacation_types[$vacationInfo['result']->vacation_type] . ' - ' . $annual_vacation_type[$vacationInfo['result']->annual_vac_type];
          $vacationInfo['result']->vacation_name  .=  ' - ' . $annual_vacation_type[$vacationInfo['result']->annual_vac_type];
        }

        $date1 = date_create($vacationInfo['result']->start_date);
        $date2 = date_create($vacationInfo['result']->end_date);
        $vacationInfo['result']->day_count = (date_diff($date1, $date2)->format("%a")) + 1;

        $fontPath = '../public/fonts/static'; 
        $imgPath = "../public/img/logo/header.png";
        $stylePath = "../public/css/app.css";
        
        $html = $this->view->fetch('/vacation/vacationForm4.twig', ['vacationInfo' => $vacationInfo['result']]);

        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];      

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new Mpdf([
            'format' => 'A4',
            'margin_top' => '45',
            'margin_bottom' => '15',
            'fontDir' => array_merge($fontDirs, [$fontPath]),
            'fontdata' => $fontData + [ // lowercase letters only in font key                
                    'cairo' => [
                        'R' => 'Cairo-Medium.ttf',   
                        'B' => 'Cairo-Bold.ttf',                   
                        'useOTL' => 0xFF ,
                        'useKashida' => 75,
                    ],
            ],            
            'default_font' => 'cairo',
            'debug' => true,
            'allow_output_buffering' => true 
          ]);
    
        $mpdf->charset_in = 'utf-8';
        $mpdf->showImageErrors = true;
        $mpdf->SetDirectionality('rtl');

        $mpdf->SetHTMLHeader('<div style="top:0 ;border-bottom:1px solid">
                                 <img src= "../public/img/logo/header.png" width="100%"/>
                              </div> '                                
                            );     

        $mpdf->SetHTMLFooter('<div style="font-size:12px;border-top:1px solid" width="100%" >نموذج رقم (4) ديوان الموظفين العام (إجازة داخلية)</div>');                            

    //    $mpdf->autoScriptToLang = true;
   //     $mpdf->autoLangToFont = true;
     
        $mpdf->WriteHTML($html);

        return $this->responseFormatter->asJson($this->response, $mpdf->Output());
      
      /*  $options = new Options();
        $options->set('defaultFont', 'Cairo');
        $options->set('chroot', realpath(''));
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);

        $Arabic = new Arabic();
        $fontPath = '../public/fonts/Cairo-VariableFont_slnt,wght.ttf';
        $imgPath = "../public/img/logo/header.png";
        $stylePath = "../public/css/app.css";

        $html = $this->view->fetch('/vacation/vacationForm4.twig', ['fontPath' => $fontPath, 'imgPath' => $imgPath,'stylePath' => $stylePath, 'vacationInfo' => $vacationInfo['result']]);
        $html  = $this->processArabicText($html, $Arabic);

        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        // (Optional) Set dompdf options if needed
       // $dompdf->setOptions($options);


        $dompdf->render();
        $dompdf->stream('document.pdf', ['Attachment' => false]);

        return $this->responseFormatter->asJson($this->response, $dompdf);*/
    }

    public function processArabicText($html, $Arabic)
    {
        $p = $Arabic->arIdentify($html);

        for ($i = count($p) - 1; $i >= 0; $i -= 2) {
            $utf8ar = $Arabic->utf8Glyphs(substr($html, $p[$i - 1], $p[$i] - $p[$i - 1]));
            $html = substr_replace($html, $utf8ar, $p[$i - 1], $p[$i] - $p[$i - 1]);
        }

        return $html;
    }
}
