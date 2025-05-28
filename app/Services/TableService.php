<?php

namespace App\Services;

use App\Models\Management;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TableService{

    public function generateTable($students)
    {
        ob_end_clean();
        ob_start(); 

        date_default_timezone_set('America/Sao_Paulo');
        $date = date('d/m/Y');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Nome');
        $sheet->setCellValue('B1', 'Ano');
        $sheet->setCellValue('C1', 'Valor da Aula');
        $sheet->setCellValue('D1', 'Presença');
        $sheet->setCellValue('E1', 'Total');
        $sheet->setCellValue('F1', 'Pago');

        $sheet->setCellValue('H1', 'Total Bruto');
        $sheet->setCellValue('I1', 'Aluguel Salas');
        $sheet->setCellValue('J1', 'Total Líquido');
        $sheet->setCellValue('K1', 'Data de Hoje');

        $total = 0;
        $totalClasses = 0;
        $row = 2;

        foreach($students as $student){

            $management = Management::where("student_id", $student->id)->first();

            if($management->paid == 0 || $management->paid == null){
                $paidStatus = " ";
            }elseif($management->paid == 1){
                $paidStatus = "Sim";
            }

            $schoolYear = $this->schoolYear($student->school_year);

            $sheet->setCellValue('A'.$row, $student->name);
            $sheet->setCellValue('B'.$row, $schoolYear);
            $sheet->setCellValue('C'.$row, "R$" . number_format($management->class_value ?? 0, '2', ',', '.'));
            $sheet->setCellValue('D'.$row, $management->quantity_classes ?? 0);
            $sheet->setCellValue('E'.$row, "R$" . number_format($management->total_value ?? 0, '2', ',', '.'));
            $sheet->setCellValue('F'.$row, $paidStatus);
            
            $total += $management->total_value ?? 0; 
            $totalClasses += ($management->quantity_classes ?? 0) * 20;

            $row++;

        }

        $liquidValue = $total - $totalClasses;

        $sheet->setCellValue('H2', "R$" . number_format($total, '2', ',', '.'));
        $sheet->setCellValue('I2', "R$" . number_format($totalClasses, '2', ',', '.'));
        $sheet->setCellValue('J2', "R$" . number_format($liquidValue, '2', ',', '.'));
        $sheet->setCellValue('K2', $date);

        //STYLE
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $sheet->getStyle('H1:K1')->getFont()->setBold(true);

        
        $fileName = 'planilha'.date('d:m:Y').'.xlsx';

        return new StreamedResponse(
            function () use ($spreadsheet) {
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
                'Cache-Control' => 'no-store, no-cache',
                'Pragma' => 'no-cache'
            ]
        );
    }

    private function schoolYear(string $school_year)
    {

        if($school_year == 'fundamental 1'){
            return $school_year = "Fundamental 1";
        }elseif($school_year == 'fundamental 2'){
            return "Fundamental 2";
        }elseif($school_year == 'ensino médio'){
            return "Ensino Médio";
        }elseif($school_year == 'ensino superior'){
            return "Ensino Superior";
        }

    }

}