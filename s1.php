<?php

/*
 *  DCE TOOLS - Copy dce  
 *  - STEP 1 - get source and target database
*/

require_once('settings.php');
require_once('db.php');
require_once('htmlheader.php');

//Get Connection
$mysqlconn=getconn($username, $password,'mysql');

//Get DB List
$sql ="Show Databases;";
$mysqlres=getresult($mysqlconn,$sql);

echo "<form action='s2.php' method='post'>\n";

//Source DB
echo "<h2>Select Source DB:</h2>\n";
if ($mysqlres->num_rows > 0) {
echo "   <select name='sourcedb'size='1' '>\n";
    while($row =$mysqlres->fetch_assoc())
    {
 echo "      <option value='" .$row["Database"]. "'>".$row["Database"]."</option> \n";
    }
echo "    </select>\n";
}

//Target DB
echo "<h2>Select Target DB:</h2>\n";

$sql ="Show Databases;";
$mysqlres=getresult($mysqlconn,$sql);

if ($mysqlres->num_rows > 0) {
echo "   <select name='targetdb'size='1' '>\n";
    while($row =$mysqlres->fetch_assoc())
    {
 echo "      <option value='" .$row["Database"]. "'>".$row["Database"]."</option> \n";
    }
echo "    </select><br><br>\n";
}

echo "  <button type='submit'>Weiter zu Schritt 2</button>\n";
echo "</form>\n";

//Close Connection
closeconn($mysqlconn);

require_once('htmlfooter.php');
?>
