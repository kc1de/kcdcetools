<?php
/*
 *  DCE TOOLS - Copy dce
 *  - STEP 3 - show source dce elements
*/

require_once('settings.php');
require_once('db.php');
require_once('dce.php');

require_once('htmlheader.php');

$sourcedce = $_POST['sourcedce'];
$sourcedb = $_POST['sourcedb'];
$targetdb = $_POST['targetdb'];

echo "<h4>Ausgewählte Quelle:" . $sourcedb . "</h4>\n";
echo "<h4>Ausgewähltes Ziel:" . $targetdb . "</h4>\n";
echo  "<h4>Augewähltes DCE: ".  $sourcedce ."</h4>\n";

//GetSourcedce Title
//Get Connection
$sourceconn=getconn($username, $password,$sourcedb);
$sourcedcetitle=getDCETitle($sourceconn,$sourcedce);
$alldcerows=getDCEFields($sourceconn,$sourcedce,TRUE);
echo "<form action='s4.php' method='post'>\n";
echo "<input type='hidden' id='sourcedb' name='sourcedb' value='" . $sourcedb . "' />\n";
echo "<input type='hidden' id='targetdb' name='targetdb' value='" . $targetdb . "' />\n";
echo "<input type='hidden' id='sourcedce' name='sourcedce' value='" . $sourcedce . "' />\n";
echo "<br><br>\n";
echo "<h4>Ausgewählte Ziel-Datenbank: " . $targetdb . "</h4>\n";
echo "<h4>Augewähltes DCE: ".  $sourcedcetitle ."</h4>\n";
echo "  <button type='submit'>DCE in Ziel-Datenbank kopieren</button>\n";
echo "</form>\n";

//Close Connection
closeconn($sourceconn);

require_once('htmlfooter.php');
?>


