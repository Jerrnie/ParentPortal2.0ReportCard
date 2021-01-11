<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// $spreadsheet = new Spreadsheet();
// $sheet = $spreadsheet->getActiveSheet();
// $sheet->setCellValue('A1', 'Hello World !');

// $writer = new Xlsx($spreadsheet);
// $writer->save('hello world.xlsx');

// $spreadsheet->getActiveSheet()
//     ->getCell('B1')
//     ->setValue('Some value');

$excel = \PhpOffice\PhpSpreadsheet\IOFactory::load('hello world.xlsx');
//$excel = PHPExcel_IOFactory::load('hello world.xlsx');

$excel->setActiveSheetIndex(0);

echo "<table>";

$i = 1; 

while ($excel->getActiveSheet()->getCell('A'.$i)->getValue() !="") {
	$id =$excel -> getActiveSheet() -> getCell('A'.$i)->getValue();
 
 if ($id = 'Hello World !') {
 	echo "true";
 }
	echo "
		<tr>
			<td>".$id."</td>
			<td>".$id."</td>
		</tr>

	";
	$i++;
}

echo "</table>";
?>