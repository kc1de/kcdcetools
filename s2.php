<?php

/*
 *  DCE TOOLS - Copy dce  
 *  - STEP 2 - select source dce
*/

require_once('settings.php');
require_once('db.php');

require_once('htmlheader.php');

$sourcedb = $_POST['sourcedb'];
$targetdb = $_POST['targetdb'];

echo "<h4>Ausgewählte Quelle:</h4>" . $sourcedb . "\n";
echo "<h4>Ausgewähltes Ziel:</h4>" . $targetdb . "\n";

echo "<br><br>\n";

echo "<h2>Select Source DCE:</h2>\n";
//Get Connection
$sourceconn=getconn($username, $password,$sourcedb);

$sql = "SELECT * FROM tx_dce_domain_model_dce";
$sourceresult = getresult($sourceconn,$sql);

echo "<form action='s3.php' method='post'>\n";
echo "   <select name='sourcedce'size='1' '>\n";

if ($sourceresult->num_rows > 0) {
    // output data of each row
    while($row = $sourceresult->fetch_assoc()) {
        echo "      <option value='" .$row["uid"]. "'>".$row["title"]."</option> \n";
    }
}

echo "    </select>\n";

echo "<input type='hidden' id='sourcedb' name='sourcedb' value='" . $sourcedb . "' />\n";
echo "<input type='hidden' id='targetdb' name='targetdb' value='" . $targetdb . "' />\n";
echo "<br><br>\n";
echo "  <button type='submit'>Weiter zu Schritt 3</button>\n";
echo "</form>\n";


//Close Connection
closeconn($sourceconn);

require_once('htmlfooter.php');
?>
