<?php

include "../_config.php";

// DELETE EXISTING ALL DATABASE
$mysqli = new mysqli("localhost", username, password, dbname);

$mysqli->query('SET foreign_key_checks = 0');
if ($result = $mysqli->query("SHOW TABLES"))
{
    while($row = $result->fetch_array(MYSQLI_NUM))
    {
        $mysqli->query('DROP TABLE IF EXISTS '.$row[0]);
    }
}

$mysqli->query('SET foreign_key_checks = 1');
$mysqli->close();

// IMPORT LATEST DATABASE
// $sql = file_get_contents('database.sql');
// $mysqli = new mysqli("localhost", username, password, dbname);

// /* EXECUTE THE QUERY */
// $mysqli->multi_query($sql);

// print_r($mysqli);

$mysqli = new mysqli("localhost", username, password, dbname);

$query = '';
$sqlScript = file('database.sql');
foreach ($sqlScript as $line)	{
	
	$startWith = substr(trim($line), 0 ,2);
	$endWith = substr(trim($line), -1 ,1);
	
	if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
		continue;
	}
		
	$query = $query . $line;
	if ($endWith == ';') {
		mysqli_query($mysqli,$query) or die('<div class="error-response sql-import-response">Problem in executing the SQL query <b>' . $query. '</b></div>');
		$query= '';		
	}
}
echo '<div class="success-response sql-import-response">SQL file imported successfully</div>';
