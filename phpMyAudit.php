#!/usr/bin/php -q
<?php
//phpMyAudit - A MySQL Password Auditing Tool
//Copyright (C) 2004 Devin Egan
//
//This program is free software; you can redistribute it and/or
//modify it under the terms of the GNU General Public License
//as published by the Free Software Foundation; either version 2
//of the License, or (at your option) any later version.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU General Public License for more details.
//
//You should have received a copy of the GNU General Public License
//along with this program; if not, write to the Free Software
//Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
//$Id: phpMyAudit.php,v 1.3 2004/07/08 23:41:32 degan Exp $

//Include the PMA Config
include_once("includes/config.inc.php");
//Include Functions
include_once("includes/functions.inc.php");

//Display Baner
printf("phpMyAudit %s\n\n", $version);

//Check for proper usage
if(!isset($argv[1])){
   printf("Usage: %s hash\n", $argv[0]); 
   exit;
}

time_start();
$sqlTest = "SELECT entry FROM dictionary WHERE hash='$argv[1]' OR old_hash='$argv[1]'";
$resTest = mysqli_query($link, $sqlTest);
$numTest = mysqli_num_rows($resTest);
if($numTest){
   $arrTest = mysqli_fetch_array($resTest, MYSQLI_ASSOC);
   printf("Password Found: %s\n", $arrTest["entry"]);
}  else {
   printf("Password Not Found!\n"); 
}
time_stop();

if(isset($arrTest["entry"]) && strlen($arrTest["entry"]) > 8){
   printf("This password would be difficult to brute force.\n");
}

printf("Time: %01.6f\n", time_result());

//Close the MySQL database
mysqli_close($link);
?>
