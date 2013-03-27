#!/usr/bin/php -q
<?php
//pmaFile 
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
//$Id: pmaFile.php,v 1.2 2004/07/08 23:41:21 degan Exp $

//Include the PMA Config
include_once("includes/config.inc.php");
//Include Functions
include_once("includes/functions.inc.php");

//Display Baner
printf("phpMyAudit %s\n\n", $version);

//Check for proper usage
if(!isset($argv[1])){
   printf("Usage: %s filename\n", $argv[0]); 
   exit;
}

$intCount = 0;
$intFound = 0;
$intFastCant = 0;
$decPercentage = 0;

//Open the File for reading and processing 
$file = fopen($argv[1], "r");
time_start();
while(!feof($file)){
   $line = fgets($file, 80);
   $line = str_replace("\n","",$line);
   $arrFile = explode(":", $line);

   if($arrFile[0] && $arrFile[1]){
         $intCount += 1;
         $sqlTest = "SELECT entry FROM dictionary WHERE hash='$arrFile[1]' OR old_hash='$arrFile[1]'";

         $resTest = mysqli_query($link, $sqlTest);
         $numTest = mysqli_num_rows($resTest);
         if($numTest){
            while($arrTest = mysqli_fetch_array($resTest, MYSQLI_ASSOC)){
               printf("%s: %s - $arrTest[entry] (found)\n", $arrFile[0], $arrFile[1]);
               $intFound += 1;
               if(strlen($arrTest["entry"]) > 8){
                  $intFastCant += 1;
               }
            }
         }  else {
            printf("%s: %s - NOT FOUND\n", $arrFile[0], $arrFile[1]);
         }
   }
}
time_stop();
fclose($file);

$decPercentage = ($intFound/$intCount) * 100;
if($intFastCant && $intFound){
   $decCantPercentage = ($intFastCant/$intFound) * 100;
} else {
   $decCantPercentage = 0;
}
$decTime = time_result();

printf("\nTotal: %s\nFound: %s\nTime: %01.6f seconds\n%02.2f%% of the passwords were found.\n%02.2f%% of the found passwords would be difficult to brute force.\n",$intCount, $intFound, $decTime, $decPercentage, $decCantPercentage);

//Close the MySQL database
mysqli_close($link);

?>
