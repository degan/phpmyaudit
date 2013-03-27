#!/usr/bin/php -q
<?php
//phpMyAudit Dictionary Removal tool
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

////Include the PMA Config
include_once("includes/config.inc.php");

//Display Baner
printf("phpMyAudit Dictionary Cleaner Tool v%s\n\n", $version);

//Check for proper usage
if(!isset($argv[1])){
   printf("\nUsage: %s yes\n", $argv[0]); 
   exit;
}

//Include the PMA Config  
include_once("includes/config.inc.php");

if($argv[1] == "yes"){
   mysqli_query($link, "DELETE FROM dictionary");
   printf("Dictionary removed.\n");
} else {
   printf("\nUsage: %s yes\n", $argv[0]); 
}

//Close the MySQL database
mysqli_close($link);
?>
