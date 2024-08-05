<?php

namespace App\Services;

use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\File;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Carbon\Carbon;

class PdfService
{
    public function fillTemplate($data)
    {

        $templatePath = public_path('/ALAJMI_EMP_EVALUATION_DETAILS.docx');
        $evaluation_details = $data['evaluation_details'][0];
        $points_details = $data['point_details'];
        $templateProcessor = new TemplateProcessor($templatePath);

        if ($evaluation_details['eval_reason'] == 'Contract') {
            $templateProcessor->setValue('contract', '*');
            $templateProcessor->setValue('probation', ' ');
            $templateProcessor->setValue('other', ' ');
        } elseif ($evaluation_details['eval_reason'] == 'Probation') {
            $templateProcessor->setValue('probation', '*');
            $templateProcessor->setValue('contract', ' ');
            $templateProcessor->setValue('other', ' ');
        } else {
            $templateProcessor->setValue('other', '*');
            $templateProcessor->setValue('probation', ' ');
            $templateProcessor->setValue('contract', ' ');
        }


        $templateProcessor->setValue('emp_name', $evaluation_details['emp_name']);
        $templateProcessor->setValue('emp_number', $evaluation_details['emp_number']);
        $templateProcessor->setValue('emp_position', $evaluation_details['emp_position']);
        $templateProcessor->setValue('emp_cost_center_name', $evaluation_details['emp_cost_center_name']);
        $templateProcessor->setValue('emp_hire_date', Carbon::parse($evaluation_details['emp_hire_date'])->format('Y-m-d'));
        $templateProcessor->setValue('evaluated_by', $evaluation_details['evaluated_by']);
        $templateProcessor->setValue('last_sal_incmt', $evaluation_details['last_sal_incmt']);
        $templateProcessor->setValue('last_sal_chng_date', Carbon::parse($evaluation_details['last_sal_chng_date'])->format('Y-m-d'));
        $templateProcessor->setValue('sal_start_contract', $evaluation_details['sal_start_contract']);
        $templateProcessor->setValue('present_sal', $evaluation_details['present_sal']);
        $templateProcessor->setValue('comments', $evaluation_details['comments']);
        $templateProcessor->setValue('reviewed_by', $evaluation_details['reviewed_by']);
        $templateProcessor->setValue('total', $evaluation_details['p_total_grade']);

        for ($i = 0; $i <= 14; $i++) {
            $templateProcessor->setValue($i, $points_details[$i]['eval_grade']);
        }
        $templateProcessor->setValue('13*2', $points_details[13]['eval_grade'] * 2);

        if ($evaluation_details['p_perfmce_decn'] == 'Continue his contract after end of probationary period') {
            $templateProcessor->setValue('cap', '*');
            $templateProcessor->setValue('ru', ' ');
            $templateProcessor->setValue('rw', ' ');
            $templateProcessor->setValue('ep', ' ');
            $templateProcessor->setValue('tr', ' ');
            $templateProcessor->setValue('t', ' ');
        } elseif ($evaluation_details['p_perfmce_decn'] == 'Terminate') {
            $templateProcessor->setValue('cap', ' ');
            $templateProcessor->setValue('ru', ' ');
            $templateProcessor->setValue('rw', ' ');
            $templateProcessor->setValue('ep', ' ');
            $templateProcessor->setValue('tr', ' ');
            $templateProcessor->setValue('t', '*');
        } elseif ($evaluation_details['p_perfmce_decn'] == 'Contract renewable under same conditions') {
            $templateProcessor->setValue('cap', ' ');
            $templateProcessor->setValue('ru', '*');
            $templateProcessor->setValue('rw', ' ');
            $templateProcessor->setValue('ep', ' ');
            $templateProcessor->setValue('tr', ' ');
            $templateProcessor->setValue('t', ' ');
        } elseif ($evaluation_details['p_perfmce_decn'] == 'Contract renewable with increment …………..……… SAR') {
            $templateProcessor->setValue('cap', ' ');
            $templateProcessor->setValue('ru', ' ');
            $templateProcessor->setValue('rw', '*');
            $templateProcessor->setValue('ep', ' ');
            $templateProcessor->setValue('tr', ' ');
            $templateProcessor->setValue('t', ' ');
        } elseif ($evaluation_details['p_perfmce_decn'] == 'Training required') {
            $templateProcessor->setValue('cap', ' ');
            $templateProcessor->setValue('ru', ' ');
            $templateProcessor->setValue('rw', ' ');
            $templateProcessor->setValue('ep', ' ');
            $templateProcessor->setValue('tr', '*');
            $templateProcessor->setValue('t', ' ');
        } elseif ($evaluation_details['p_perfmce_decn'] == 'Extend probation period') {
            $templateProcessor->setValue('cap', ' ');
            $templateProcessor->setValue('ru', ' ');
            $templateProcessor->setValue('rw', ' ');
            $templateProcessor->setValue('ep', '*');
            $templateProcessor->setValue('tr', ' ');
            $templateProcessor->setValue('t', ' ');
        }

        // Check Main Folder
        $mainFolderPath = public_path('documents');

        // Check For Sub Folder
        $subFolderName = $evaluation_details['emp_number'];
        $subFolderPath = $mainFolderPath . DIRECTORY_SEPARATOR . $subFolderName;

        if (!File::exists($subFolderPath)) {
            File::makeDirectory($subFolderPath, 0755, true);
        }

        // Check For Sub Folder Is Exist
        if (File::exists($subFolderPath) && File::isDirectory($subFolderPath)) {

            // Save the filled template to a new Word file
            $creationDate = Carbon::parse($evaluation_details['creation_date'])->format('Y-m-d');
            $filledTemplatePath  = public_path('documents' . DIRECTORY_SEPARATOR . $subFolderName . DIRECTORY_SEPARATOR  . 'Evaluation_' . $creationDate . '.docx');
            $templateProcessor->saveAs($filledTemplatePath);

            // Load the filled Word file and convert to HTML
            $phpWord = \PhpOffice\PhpWord\IOFactory::load($filledTemplatePath);
            $pdfWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
            $tempHtmlPath = public_path('documents' . DIRECTORY_SEPARATOR . $subFolderName . DIRECTORY_SEPARATOR  . 'Evaluation_' . $creationDate . '.html');
            $pdfWriter->save($tempHtmlPath);
            $outputPdfPath = public_path('documents' . DIRECTORY_SEPARATOR . $subFolderName . DIRECTORY_SEPARATOR  . 'Evaluation_' . $creationDate . '.pdf');

            // Convert HTML to PDF using mPDF
            $htmlContent = file_get_contents($tempHtmlPath);

            // Use a font that supports Arabic, like Amiri
            $fontDir = public_path('fonts');
            $fontPath = $fontDir . DIRECTORY_SEPARATOR . 'Amiri-Regular.ttf';

            // mPDF configuration
            $defaultConfig = (new ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];
            $defaultFontConfig = (new FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            $mpdf = new Mpdf([
                'fontDir' => array_merge($fontDirs, [
                    $fontDir,
                ]),
                'fontdata' => $fontData + [
                    'amiri' => [
                        'R' => 'Amiri-Regular.ttf',
                        'B' => 'Amiri-Bold.ttf',
                        'I' => 'Amiri-Italic.ttf',
                        'BI' => 'Amiri-BoldItalic.ttf',
                    ]
                ],
                'default_font' => 'amiri',
                'mode' => 'utf-8',
                'format' => 'A4-R',
            ]);

            $htmlContents = '<html><head>
                    <style>
                        body {
                            font-family: "amiri", sans-serif;
                            direction: rtl;
                            text-align: right;
                        }
                    </style>
                    </head><body>' . $htmlContent . '</body></html>';

            $mpdf->WriteHTML($htmlContents);
            $mpdf->Output($outputPdfPath, \Mpdf\Output\Destination::FILE);

            // Remove the temporary HTML & Word file
            // unlink($filledTemplatePath);
            // unlink($tempHtmlPath);

            return response()->download($outputPdfPath);
        }
    }
}
