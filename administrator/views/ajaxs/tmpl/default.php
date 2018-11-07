<?php
error_reporting(0);
$jinput = JFactory::getApplication()->input;
$db = JFactory::getDbo();
$query = $db->getQuery(true);

$foo = $jinput->get('id', '0', 'INT');
$string = $jinput->get('string', ' ', 'STRING');
$task = $jinput->get('task', 'propiedad', 'STRING');
$output = $jinput->get('out', 'csv', 'STRING');

switch ($task) {
  case('consultatotal'):
    $db->setQuery("select id,total,abonado, (total-abonado) as adeudo from #__servin_".$string." where id=".$foo);
    $result=$db->loadAssoc('id');
    $salida='';
    $salida = ($result);
    echo json_encode($salida);
  break;
  case('consigpermitidas'):
    $db->setQuery("sELECT id,abono, concat(no_folio_pagare,' | $' ,abono) as descripcion FROM `#__servin_consignaciones2` WHERE 1
      and estatus = 2
      and tipo_transaccion= ".$foo);
    $result=$db->loadAssocList('id');
    $salida='';
    $salida = ($result);
    echo json_encode($salida);
  break;
  case 'costosugerido':
    // echo $foo;
    $db->setQuery("select * from #__servin_hechuras2 where id=".$foo);
    $result=$db->loadAssoc();
    $salida='';
    $salida = ($result['costo']);
    echo $salida;
  break; 
  case 'preciosugerido':
    // echo $foo;
    $db->setQuery("select * from #__servin_hechuras2 where id=".$foo);
    $result=$db->loadAssoc();
    $costo=$result['costo'];
    $tipo_ganancia = $result['tipo_ganancia'];
    $precio=0;
    if($tipo_ganancia=="fijo"){
      $precio = $costo + $result['ganancia'];
    }else{
      $precio = $costo + (($result['ganancia']*$costo)/100 );
    }
    $salida='';
    $salida = $precio;
    echo $salida;
  break; 
  case 'preciosugerido':
    // echo $foo;
    $db->setQuery("select * from #__servin_hechuras2 where id=".$foo);
    $result=$db->loadAssoc();
    $salida='';
    if ($result['tipo_ganancia']  == "fijo") {
      $salida = ($result['costo'])+($result['ganancia']);
    }else{
      $salida = ($result['costo']) + (($result['costo'] * $result['ganancia'])/100);
    }
    echo $salida;
  break;
  case 'piezascompra':
    // echo $foo;
    $db->setQuery("sELECT p.id, concat(h.numero,' | ' ,p.descripcion) as descripcion FROM #__servin_piezas2 as p inner join #__servin_hechuras2 as h on h.id = p.hechura ");
    $result=$db->loadAssocList('id','descripcion');
    $salida=json_encode($result);
    echo "1";
    echo $salida;
  break;
  case 'consultotal':
    // echo $foo;
    $db->setQuery("select precio from #__servin_piezas2 where id in (".$string.")");
    $result=$db->loadColumn();
    echo round(array_sum($result),2);
  break;
}
function toexcel($array,$file){
  $sufix = date(Ymd);
  header('Content-type: application/x-msdownload; charset=utf-16');
  header('Content-Disposition: attachment; filename='.$file."_" . $sufix . '.xls');
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Cache-Control: private",false); 

  foreach ($array as $data)
  {
    $str = implode("\t",$data);
    $str = str_replace(array("\r\n", "\r", "\n"), "", $str); 
    if (mb_detect_encoding($str ) == 'UTF-8') {
       $str = mb_convert_encoding($str ,  'UTF-16LE', 'UTF-8');
    }
    echo $str . "\r\n";
  }
}
function tocsv(array &$array, $filename){
    $now = gmdate("D, d M Y H:i:s");
    $sufix = date(Ymd);
    header('Content-Encoding: Windows-1252');
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");
    header("Content-Type: application/x-msdownload; charset=Windows-1252");
    header("Content-Disposition: attachment;filename={$filename}_{$sufix}.csv");
    header("Content-Transfer-Encoding: binary");
   if (count($array) == 0) {
     return null;
   }
   ob_start();
   $df = fopen("php://output", 'w');
   //echo "\xEF\xBB\xBF";
   foreach ($array as $row) {
      array_walk($row, 'csv_encode_conv', 'Windows-1252');
      fputcsv($df, $row);
   }
   fclose($df);
   echo ob_get_clean();
}
function csv_encode_conv(&$var, $key, $enc='Windows-1252') {
    $var = htmlentities($var, ENT_QUOTES, 'utf-8');
    $var = html_entity_decode($var, ENT_QUOTES , $enc);
    return $var;
}
?>