<?php 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
/**
* composer require phpoffice/phpspreadsheet
*
**/
class Xls{
    
    function export_download($header,$datas,$filename=""){
        if($filename == ''){
            $filename = date('Y-m-d-H-i-s').'.xls';
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // 設定標題        
        $col1 = 'A';
        foreach ($header as $key => $value) {
            $sheet->setCellValue(chr(ord($col1) + $key).'1', $value);
        }
        // 設定內容
        foreach($datas as $k1=>$v1){
            $i =0;
            foreach ($v1 as $k2 => $v2) {
                $sheet->setCellValue(chr(ord($col1) + $i).($k1+2), $v2);
                $i++;
            }
        }
        $writer = new Xlsx($spreadsheet);
        header('Content-Type:application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="'.$filename.'"');
        header('Cache-Control:max-age=0');
        $writer->save('php://output');

    }
}
?>
