<?php

$dateNow = date("Y-m-d");
header("Content-type:application/vnd-ms-excel");
header("Content-Disposition:attachment;filename='$dateNow'-Pemakaian Barang Hardware.xls");

include "databaranghardwareterpakaiexcel.php";

?>