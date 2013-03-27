<?php
//phpMyAudit web - A MySQL Password Auditing Tool
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
//$Id: index.php,v 1.2 2004/07/08 23:41:13 degan Exp $

//Include the WEB PMA Config
include_once("includes/config.inc.php");
//Include the Functions
include_once("includes/functions.inc.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
  <HEAD>
    <TITLE>
      phpMyAudit: A MySQL Password Auditing Tool
    </TITLE>
    <STYLE type="text/css">
    <!--
    BODY {
      background: #EFEFEF;
    }
    TD, TH {
      font-family: Georgia;
      font-size: 15px;
    }
    .box {
      width: 275px;
      height: 155px;
      font-family: Georgia;
      font-size: 15px;
      background: #F0EEEA;
      color: #6C6454;
      border: solid #6C6454 1px;
    }
    .big {
      font-family: Georgia;
      font-size: 25px;
    }
    .small {
      font-family: Georgia;
      font-size: 10px;
      text-align: right;
    }
    .bold {
      font-family: Georgia;
      font-size: 15px;
      font-weight: bold;
    }
    .hr {
      background: #000000; 
      font-family: Georgia;
      font-size: 1px;
      height: 1px;
    }
    INPUT {
      font-family: Georgia;
      font-size: 15px;
      background: #F0EEEA;
      color: #6C6454;
      border: solid #6C6454 1px;
    }
    -->
    </STYLE>
  </HEAD>
  <BODY>
    <TABLE width="590" cellspacing="0" cellpadding="0" border="0">
      <TR>
        <TD class="big">
          phpMyAudit
        </TD>
      </TR>
      <TR>
        <TD class="hr">
          &nbsp;
        </TD>
      </TR>
      <TR>
        <TD>
          <BR>
          <FORM action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
            <TABLE cellspacing="0" cellpadding="0" border="0">
              <TR>
                <TD align="left">
                  <INPUT type="text" name="hash" size="16" maxlength="41" value="<?php echo $_POST["hash"]; ?>">
                </TD>
                <TD>
                  &nbsp;<INPUT type="submit" name="single_hash" value="Find">
                </TD>
              </TR>
            </TABLE>
          </FORM>
            <?php
            if($_POST["single_hash"]){
               time_start();
               $sqlTest = "SELECT entry FROM dictionary WHERE hash='" . $_POST["hash"] . "' OR old_hash='" . $_POST["hash"] . "'";
               $resTest = mysqli_query($link, $sqlTest);
               $numTest = mysqli_num_rows($resTest);
               if($numTest){
                  $arrTest = mysqli_fetch_array($resTest); 
                  echo "      MySQL Password Found: <span class=bold>$arrTest[entry]</span><BR>\n";
               } else {
                  echo "      MySQL Password <span class=bold>NOT</span> Found!<BR>\n";
               }
               time_stop();
               if(strlen($arrTest["entry"]) > 8){
                  echo "         This password would be difficult to brute force.<BR>\n";
               } 
               printf("       Time: %01.6f<BR>\n", time_result());
            }
            ?>
          <BR>
             <span class=bold>OR</span>
          <BR>
          <BR>
            ex (user:hash)
            <FORM action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
            <TABLE cellspacing="0" cellpadding="0" border="0">
              <TR>
                <TD valign="top">
                  <TEXTAREA name="hash_list" class="box"><?php echo $_POST["hash_list"]; ?></TEXTAREA>
                </TD>
                <TD valign="top">
                  &nbsp;<INPUT type="submit" name="mult_hash" value="Find">
                </TD>
              </TR>
            </TABLE>
          </FORM>
         
          <?php
          if($_POST["mult_hash"]){
            if($_POST["hash_list"]){
               $arrHash = explode("\n", $_POST["hash_list"]);
               $numHash = count($arrHash);
               
               $intCount = 0;
               $intFound = 0;
               $intFastCant = 0;
               $decPercentage = 0;

               echo "         <FORM><TEXTAREA class=box>\n";
               time_start();
               for($i=0; $i < $numHash; $i++){
                  $arrLine = explode(":", $arrHash[$i]); 
                  if($arrLine[0] && $arrLine[1]){
                      $strHash = substr($arrLine[1], 0, -1);
                      $intCount += 1;
                      $sqlTest = "SELECT entry FROM dictionary WHERE hash='" . $strHash . "' OR old_hash='" . $strHash . "'";
                      $resTest = mysqli_query($link, $sqlTest);
                      $numTest = mysqli_num_rows($resTest);
                      if($numTest){
                        $arrTest = mysqli_fetch_array($resTest);
                        echo "$arrLine[0]: $arrTest[entry] (found)\n";
                        $intFound += 1;
                        if(strlen($arrTest["entry"]) > 8){
                           $intFastCant += 1;
                        }
                      }  else {
                        echo "$arrLine[0]:  NOT FOUND\n";
                      }
                  }
               }
               time_stop();
               echo "         </TEXTAREA></FORM><BR>\n";

               $decTime = time_result();
               $decPercentage = ($intFound/$intCount) * 100;
               if($intFastCant && $intFound){
                  $decCantPercentage = ($intFastCant/$intFound) * 100;
               }
               printf("Total: %s<BR> Found: %s<BR> Time: %01.6f seconds<BR>%02.2f%% of the passwords were found.<BR>%02.2f%% of the found passwords would be difficult to brute force.<BR>\n",$intCount, $intFound, $decTime, $decPercentage, $decCantPercentage);

            }
          }
          ?>
          <BR>
        </TD>
      </TR>
      <TR>
        <TD class="hr">
          &nbsp;
        </TD>
      </TR>
      <TR>
        <TD class="small">
          Powered by phpMyAudit <?php echo $_PMA["version"]; ?>
        </TD>
      </TR>
    </TABLE>
  </BODY>
</HTML>
