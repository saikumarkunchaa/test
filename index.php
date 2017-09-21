<?php
//include the following 2 files
require 'phpexcel/Classes/PHPExcel.php';
require_once 'phpexcel/Classes/PHPExcel/IOFactory.php';

/*$SERVER = 'localhost';
$USERNAME = 'username';
$PASSWORD =  'password';
$DB = 'database';
$DSN = "mysql:host=".$SERVER.";dbname=".$DB."";
$connection = new PDO($DSN,$USERNAME,$PASSWORD);*/

$path = "#1521-Active-Basic.csv";

$objPHPExcel = PHPExcel_IOFactory::load($path);
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
    $worksheetTitle     = $worksheet->getTitle();
    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    $nrColumns = ord($highestColumn) - 64;
    for ($row = 1; $row <= $highestRow; ++ $row) {
        $rowArray = [];
        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
            $cell = $worksheet->getCellByColumnAndRow($col, $row);
            $val = $cell->getValue();
            $rowArray[] = $val;
        }
        $finalArray[] = $rowArray;
    }
}

$headings = array_shift($finalArray);
array_walk(
    $finalArray,
    function (&$row) use ($headings) {
        $row = array_combine($headings, $row);
    }
);
echo '<pre>';print_r($finalArray);exit;

 //$Connection="INSERT INTO `users` (name, family, type) VALUES ('".$val[1] . "','" . $val[2] . "','" . $val[3]. "')";

}
?>