<?php

// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Call function file
include('resources/function.php');

// Initialize $response
$data = json_decode(file_get_contents('php://input'));
$response = NULL;

// Define a function
$apis = getApis();

// Get passed function and data
if(!empty($data))
{
	$function = $data->function;

	// Reset function arguments. 
	$arguments = NULL;

	// Get the data required in the api.
	if (isset($apis[$function]["data"])) 
	{
		// Loop through all data required and put something (parameter/NULL) inside arguments
		$api_data = $apis[$function]["data"];
		foreach ($api_data as $d) 
		{
			// If there is parameter passed, put inside arguments
			if (isset($data->$d)) 
			{
			$arguments[] = $data->$d;
			}
			// Else, put NULL inside arguments
			else
			{
			$arguments[] = NULL;
			}
		}
		$response = call_user_func_array($function, $arguments);   
		// printOut($arguments); //implode(",", $arguments));
	}
	else
	{
	$response = call_user_func($function);              		
	}     
}

// Filter response code and output
if ($response == NULL) 
{
	// Set response code: 404 Not found
    http_response_code(404);    
	$response = "No data";
}
else
{
	// Set response code - 200 OK
    http_response_code(200);	
}

// Encode json data
echo json_encode($response);

?>