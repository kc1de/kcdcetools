<?php
/*
*  DCE TOOLS
*  - DB Lib
*/


//Open and return database connection
function getconn($username, $password, $dbname)
{
// Create connection
    $conn = new mysqli(localhost, $username, $password, $dbname);
// Check connection
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}


//close database connection
function closeconn($conn)
{
    $conn->close();
}


//Execute query and return result
function getresult($conn, $sql)
{
    $result = $conn->query($sql);
    return $result;
}


//Execute NonQuery
function executenonquery($conn, $sql)
{
    if ($conn->query($sql) === FALSE)
    {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


//Insert row and return id of inserted row
function insertandgetid($conn, $sql)
{
    if ($conn->query($sql) === FALSE)
    {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $last_id = $conn->insert_id;
    return $last_id;
}
?>