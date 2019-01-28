<?php

if(isset($_COOKIE['token']))
{

	require_once 'models/config.php';
	require_once 'models/DataBase.php';
	require_once 'models/TableDataGateway.php';
	

	$db = new DataBase($config['host'],$config['dbname'],$config['user'],$config['password']);
    $data_gateway = new TableDataGateway($db,$config['table']);


	$objectSt = $data_gateway->getByToken($_COOKIE['token']);
	
	if($objectSt == false)
	{

		include 'controllers/register.php';
		die();
		
	}


	include 'controllers/list.php';

}
else 
{
	
	include 'controllers/register.php';
	
}