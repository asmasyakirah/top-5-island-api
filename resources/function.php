<?php

function getTop5ByDate($visit_date)
{
	try
	{		
		$result = dbSelect("
		SELECT i.island_id, i.island_name, v.visit_count
	  	FROM visit v 
	  	LEFT JOIN island i ON v.island_id = i.island_id  
	  	WHERE v.visit_date = '$visit_date'
	  	ORDER BY v.visit_count DESC
	  	LIMIT 5");
	
    	$return = array
    	(
    		'success' => true, 
    		'message' => "Result",
    		'result' => $result
    	); 
	}
	catch (Exception $e)
	{		
    	$return = array
    	(
    		'success' => false,
    		'message' => $e->getMessage()
    	); 
	}
	

	return $result;	
} 

function getAPIs()
{	
	// Call config file
	require('config.php');
	return $config["apis"];
}

function dbSelect($sql)
{
	$result = dbSelectMysql($sql);
	return $result;
}

function dbInsert($sql)
{
	$result = dbInsertMysql($sql);
	return $result;
}

function dbUpdate($sql)
{
	$result = dbUpdateMysql($sql);
	return $result;
}

function dbInsertMsSql($sql)
{
	return dbInsertUpdateMsSql($sql);
}

function dbUpdateMsSql($sql)
{
	return dbInsertUpdateMsSql($sql);
}

function dbInsertUpdateMsSql($sql)
{
	// Call database file
	require('database.php');

	// Initialize the return array
	$return = array();

	try 
	{
	    $conn = new PDO("sqlsrv:Server=$dbhost;Database=$dbname", $dbuser, $dbpass);

	    // set the PDO error mode to exception
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    
		// $sql = "UPDATE Booking
		// 	SET StatusId = '1'
		// 	WHERE BookingId = 6";

		$query = $conn->prepare($sql);
		$query->execute();
		$return = $conn->lastInsertId();

	    unset($conn);
    }
	catch(PDOException $e)
    {
	    $return["Error"] = $e->getMessage();
    	// echo "Connection failed: " . $e->getMessage();
    }

    // var_dump($return);
	return $return;
}

function dbSelectMsSql($sql)
{
	// Call database file
	require('database.php');

	// Initialize the return array
	$return = array();

	try 
	{
	    $conn = new PDO("sqlsrv:Server=$dbhost;Database=$dbname", $dbuser, $dbpass);

	    // set the PDO error mode to exception
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $pdoStmtObj = $conn->query($sql);
	    $pdoStmtObj->setFetchMode(PDO::FETCH_ASSOC);
	    
	    foreach($pdoStmtObj as $row)
	    {
	    	$return[] = $row;
	    	// var_dump($row);
	    }
	    // echo "Connected successfully"; 
    }
	catch(PDOException $e)
    {
	    $return["Error"] = $e->getMessage();
    	// echo "Connection failed: " . $e->getMessage();
    }

    // var_dump($return);
	return $return;
}

function dbSelectMysql($sql)
{
	// Call database file
	require('database.php');

	// Initialize the return array
	$return = array();

	try 
	{
	    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	    // set the PDO error mode to exception
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $pdoStmtObj = $conn->query($sql);
	    $pdoStmtObj->setFetchMode(PDO::FETCH_ASSOC);
	    
	    foreach($pdoStmtObj as $row)
	    {
	    	$return[] = $row;
	    	// var_dump($row);
	    }
	    // echo "Connected successfully"; 
    }
	catch(PDOException $e)
    {
	    $return[] = "Error: " . $e->getMessage();
    	// echo "Connection failed: " . $e->getMessage();
    }

    // var_dump($return);
	return $return;
}

function dbInsertMysql($sql)
{
	// Call database file
	require('database.php');

	// Initialize the return array
	$return = array();

	try 
	{
	    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	    // set the PDO error mode to exception
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $conn->exec($sql);
		$return = $conn->lastInsertId();

		$conn = null;
    }
	catch(PDOException $e)
    {
	    $return[] = "Error: " . $e->getMessage();
    	// echo "Connection failed: " . $e->getMessage();
    }

    // var_dump($return);
	return $return;
}

function dbUpdateMysql($sql)
{
	// Call database file
	require('database.php');

	// Initialize the return array
	$return = array();

	try 
	{
	    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	    // set the PDO error mode to exception
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    // Prepare statement
	    $stmt = $conn->prepare($sql);

	    // execute the query
	    $stmt->execute();

	    // Return number of affected rows    
		$return[] = $stmt->rowCount() . " records UPDATED successfully";

		$conn = null;
    }
	catch(PDOException $e)
    {
	    $return[] = "Error: " . $e->getMessage();
    	// echo "Connection failed: " . $e->getMessage();
    }

    // var_dump($return);
	return $return;
}

function dbSelectPostgresql($sql)
{
	// Call database file
	require('database.php');

	// Initialize the return array
	$return = array();

	try 
	{
		$pdo = new PDO("pgsql:host=$dbhost;port=$dbport;dbname=$dbname", $dbuser, $dbpass);
		$stmt = $pdo->query($sql);
		if ($stmt) 
		{
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
			    $return[] = $row;
			}
		}
	}
	catch (PDOException $e) 
	{
	    $return[] = "Error: " . $e->getMessage();
		die();
	}	

	return $return;
}
?>