<?php
/*
 *  DCE TOOLS - Copy dce
 *  - STEP 4 - copy dce and show result
*/
require_once('settings.php');
require_once('db.php');
require_once('dce.php');

require_once('htmlheader.php');

$sourcedce = $_POST['sourcedce'];
$sourcedb = $_POST['sourcedb'];
$targetdb = $_POST['targetdb'];

echo "<h2>Kopieren des DCE in Ziel DB:" . $targetdb . "</h2>\n";
echo "<h4>Ausgewählte Quelle:" . $sourcedb . "</h4>\n";
echo  "<h4>Augewähltes DCE: ".  $sourcedce ."</h4>\n";

//GetSourcedce Title
//Get Connection
$sourceconn=getconn($username, $password,$sourcedb);
$targetconn=getconn($username, $password,$targetdb);
$sourcedcetitle=getDCETitle($sourceconn,$sourcedce);

echo  "<h4>Augewähltes DCE Title: ".  $sourcedcetitle ."</h4>\n";

$dcerow=getDCERow($sourceconn,$sourcedce);
$alldcerows=getDCEFields($sourceconn,$sourcedce,FALSE);

$lastdceid=insertdcerow($targetconn,$dcerow);
echo  "<h3>UID des eingefügten DCEs : ".  $lastdceid ."</h3>\n";

$oldsectionuid=-1;
$currentsectionuid=-1;

foreach ($alldcerows as $arow)
    {
    if($arow["type"]=="0")
    {
       if($arow["parent_field"]==$oldsectionuid)
        {
         $arow["parent_field"]=$currentsectionuid;
        }
        else //Kein Sectionfield
        {
        $arow["parent_dce"]=$lastdceid;
        }

     insertdceelement($targetconn,$arow);
    }

    if($arow["type"]=="1")
    {
      $arow["parent_dce"]=$lastdceid;

      if($arow["parent_field"]==$oldsectionuid)
        {
        $arow["parent_field"]=$currentsectionuid;
        }

     insertdceelement($targetconn,$arow);
    }

    if($arow["type"]=="2")
    {

     $arow["parent_dce"]=$lastdceid;

     $oldsectionuid=$arow["uid"];
     $currentsectionuid=insertdceelement($targetconn,$arow);
    }
  }

echo "<h2> DCE: '". $sourcedcetitle . "' erfolgreich in DB '" . $targetdb . "' eingefügt.</h2>\n";

//Close Connection
closeconn($sourceconn);
closeconn($sourceconn);
require_once('htmlfooter.php');
?>


