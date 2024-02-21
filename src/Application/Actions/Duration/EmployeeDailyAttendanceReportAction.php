<?php

declare(strict_types=1);

namespace App\Application\Actions\Duration;


use Mpdf\Config\FontVariables;
use Mpdf\Config\ConfigVariables;

use App\Application\Actions\Action;
use App\Application\Actions\Shared\Calendar;
use Psr\Http\Message\ResponseInterface as Response;

class EmployeeDailyAttendanceReportAction extends Action
{
    use Calendar;
    protected function action(): Response
    {
        $fontPath = '../public/fonts/static';
        $imgPath = "../public/img/logo/header.png";
        $stylePath = "../public/css/app.css";

        $html = $this->view->fetch('/vacation/vacationForm4.twig',);

        // $defaultConfig = (new ConfigVariables())->getDefaults();
        // $fontDirs = $defaultConfig['fontDir'];

        // $defaultFontConfig = (new FontVariables())->getDefaults();
        // $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new MPDF([
            'format' => 'A4',
            'margin_top' => '45',
            'margin_bottom' => '15',
            // 'fontDir' => array_merge($fontDirs, [$fontPath]),
             'fontdata' => // $fontData +
             [ // lowercase letters only in font key                
                'cairo' => [
                    'R' => 'Cairo-Medium.ttf',
                    'B' => 'Cairo-Bold.ttf',
                    'useOTL' => 0xFF,
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

        $mpdf->SetHTMLHeader(
            '<div style="top:0 ;border-bottom:1px solid">
        <img src= "../public/img/logo/header.png" width="100%"/>
     </div> '
        );

        $mpdf->SetHTMLFooter('<div style="font-size:12px;border-top:1px solid" width="100%" ></div>');


        $mpdf->WriteHTML($html);

        return $this->responseFormatter->asJson($this->response, $mpdf->Output());
    }
}
