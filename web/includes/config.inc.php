<?php
//config.inc.php - Configuration File
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
// $Id: config.inc.php,v 1.1.1.1 2004/07/08 21:25:15 degan Exp $

//Open the Connection to the MySQL database
$link = mysqli_connect("host", "user", "pass", "phpMyAudit");

//Check the connection
if (!$link) {
   printf("Connect failed: %s\n", mysqli_errno());
   exit();
}

//General Information
$_PMA["version"] = "Web 0.6a";

?>
