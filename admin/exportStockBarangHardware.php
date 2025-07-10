<?php

$dateNow = date("Y-m-d");
header("Content-type:application/vnd-ms-excel");
header("Content-Disposition:attachment;filename='$dateNow'-Data Stock Barang Hardware.xls");

include "datastockbaranghardwareexcel.php";

?>