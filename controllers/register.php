<?php

	require_once 'models/config.php';
	require_once 'models/DataBase.php';
	require_once 'models/Student.php';
	require_once 'models/TableDataGateway.php';
	require_once 'models/Validator.php';

if(isset($_POST['register']))
{
	$data = $_POST;
	$token = md5(trim($data['first_name']).trim($data['last_name']).trim($data['group_id']).trim($data['rating']));
	$student = new Student(trim($data['first_name']),trim($data['last_name']),trim($data['group_id']),trim($data['rating']),trim($data['email']),$data['birthday'],$data['sex'],$data['local'],$token);
	$validator = new Validator($student);
	$result = $validator->check();
	if($result != 1)
	{
		$errors = $result;
		include 'view/register.html';
	} else 
	{
		$db = new DataBase($config['host'],$config['dbname'],$config['user'],$config['password']);
		$data_gateway = new TableDataGateway($db,$config['table']);
	
		$checkEmail = $data_gateway->getByEmail($student->email);
		if($checkEmail == false){
			$data_gateway->add($student);	
			setcookie('token',$token,strtotime('+360 days'));
			header("Location: ".$config['domen']);
		} else 
		{
			$errors = array('Такой Email уже кем-то занят');
			include 'view/register.html';
		}

		


	}
} else 
{
	$student = new Student('','','','','','','','','');
	$errors = array();
	include 'view/register.html';
}