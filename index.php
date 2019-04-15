<?php
include 'PHPExcel/Classes/PHPExcel.php';

convertXLStoCSV('Domestic_Import_PO_Report_(04-10-2019) (1).xls','output.csv');
 
function convertXLStoCSV($infile,$outfile)
{
    $fileType = PHPExcel_IOFactory::identify($infile);
    $objReader = PHPExcel_IOFactory::createReader($fileType);
 
    $objReader->setReadDataOnly(true);   
    $objPHPExcel = $objReader->load($infile);    
 
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
    $objWriter->save($outfile);
    copy($outfile, 'output/'.$outfile);
    unlink($outfile);
}
$i=0;
$file = fopen('output/output.csv', 'r');
while (($line = fgetcsv($file)) !== FALSE) {
   //$line[0] = '1004000018' in first iteration

   $fileinfo[$i]=$line;
 $i++;
}

fclose($file);
unset($fileinfo[0]);
unset($fileinfo[1]);
unset($fileinfo[2]);
// print_r( $fileinfo);
$fp = fopen('file.csv','w');
$list=$fileinfo;
foreach ($list as $fields) {

    fputcsv($fp, $fields);

}
fclose($fp);
$file = fopen('file.csv', 'r');
while (($line = fgetcsv($file)) !== FALSE) {
   //$line[0] = '1004000018' in first iteration

   $fileinfo[$i]=$line;
 $i++;
}
unset($fileinfo[3]);

foreach ($fileinfo as  $value) {
  echo "INSERT INTO table_name (column1, column2, column3)
  VALUES ($value[0],$value[1], $value[2])";
  echo "<br>";
}
?>