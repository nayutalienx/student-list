<?php
require_once '../models/config.php';
require_once '../models/DataBase.php';
require_once '../models/Student.php';
require_once '../models/TableDataGateway.php';
require_once '../models/Validator.php';

//($first_name, $last_name, $group_id, $rating, $email , $birthday, $sex, $local, $token)

if(isset($_POST['token'])) {
	
	$db = new DataBase($config['host'],$config['dbname'],$config['user'],$config['password']);
	$data_gateway = new TableDataGateway($db,$config['table']);
	$student = $data_gateway->getByToken($_POST['token']);
	$result = array('sex' => $student->sex,
					'local' => $student->local);
	echo json_encode($result);
	
	
}

if(isset($_POST['formData']))
{
	$form = $_POST['formData'];
	$student = new Student($form['first_name'],$form['last_name'],$form['group_id'],$form['rating'],$form['email'],$form['birthday'],$form['sex'],$form['local'],$form['token']);
	$validator = new Validator($student);
	$result = $validator->check();

	if($result != 1)
	{
		$errors = $result;
		$response = array('valid' => 0,
						  'errors' => $errors);
		echo json_encode($response);
		die();
	} else 
	{
		$db = new DataBase($config['host'],$config['dbname'],$config['user'],$config['password']);
		$data_gateway = new TableDataGateway($db,$config['table']);

		$checkEmail = $validator->checkEmail($data_gateway,$student->email,$student->token);
		if($checkEmail=='bad')
		{
			$errors = array('Email уже кем-то занят');
			$response = array('valid' => 0, 'errors' => $errors);
			echo json_encode($response);
			die();

		} else {
			$data_gateway->update($student);
			$response = array('valid' => 1);
			echo json_encode($response);
			die();
		}
		

		
	}
	
}

?>