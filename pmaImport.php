#!/usr/bin/php -q
<?php
//phpMyAudit Dictionary Import tool
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

//Include the PMA Config  
include_once("includes/config.inc.php");

//Display Baner
printf("phpMyAudit Dictionary Import Tool v%s\n", $version);

//Check for proper usage
if(!isset($argv[1])){
   printf("\nUsage: %s dictionary_file\n", $argv[0]); 
   exit;
}

//Open the File for reading, import 
$intCount = 0;
$file = fopen($argv[1], "r");
while(!feof($file)){
   $line = fgets($file, 80);
   $line = str_replace("\n","",$line);
   $sql ="INSERT INTO dictionary (hash,old_hash,entry) VALUES(PASSWORD('$line'),OLD_PASSWORD('$line'),'$line')"; 
   mysqli_query($link, $sql); 
   $intCount += 1;
   if($intCount % 1000 == 0) { 
       echo $intCount;
   }
   print ".";
}
fclose($file);

printf("Dictionary import done. %s words added.\n",$intCount);

//Close the MySQL database
mysql_close();

?>
