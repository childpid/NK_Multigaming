<?php
//-------------------------------------------------------------------------//
//  Nuked-KlaN - PHP Portal                                                //
//  http://www.nuked-klan.org                                              //
//-------------------------------------------------------------------------//
//  This program is free software. you can redistribute it and/or modify   //
//  it under the terms of the GNU General Public License as published by   //
//  the Free Software Foundation; either version 2 of the License.         //
//-------------------------------------------------------------------------//

if (eregi("blok.php", $_SERVER['PHP_SELF']))
{
    die ("You cannot open this page directly");
} 

global $nuked;

$i = 0;
$sql = mysql_query("SELECT titre FROM " . PAGE_TABLE . " ORDER BY titre");
while (list($titre) = mysql_fetch_array($sql))
{
    $titre = stripslashes($titre);
    $titre = htmlspecialchars($titre);
    $i++;

    echo "<div><b>" . $i . " . <a href=\"index.php?file=Page&amp;name=" . $titre . "\">" . $titre . "</a></b></div>\n";
} 


?>
