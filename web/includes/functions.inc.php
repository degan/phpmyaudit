<?php
//functions.inc.php
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
//$Id: functions.inc.php,v 1.1.1.1 2004/07/08 21:25:15 degan Exp $

//Time Functions
function time_start (){
   global $arrStart;
   $arrStart = explode(' ', microtime());
} //end function time_start 

function time_stop (){
   global $arrStop;
   $arrStop = explode(' ', microtime());
} //end function time_stop 

function time_result(){
   global $arrStart, $arrStop;
   $decResult = $arrStop[1] - $arrStart[1];
   $decResult += $arrStop[0] - $arrStart[0];
   return $decResult;
} //end function time_result

?>
