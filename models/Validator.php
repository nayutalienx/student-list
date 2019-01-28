<?php

class Validator
{
	private $student;

	public function __construct(Student $student)
	{
		$this->student = $student;
	}

	public function checkEmail($data_gateway,$email,$token)
	{
		
		$currentStudent = $data_gateway->getByToken($token);
		$searchedStudent = $data_gateway->getByEmail($email); // false, если нету
		if($searchedStudent == false)
		{
			return 'good';
		} elseif ($searchedStudent->email == $currentStudent->email) {
			return 'good';
		} else {
			return 'bad';
		}
		
	}

	public function check()
	{
		$errors = array();
		if($this->student->first_name == '' )
		{
			$errors[] = 'Вы не ввели имя';
		} elseif(!preg_match("/^[a-zA-Zа-яА-Я]{2,30}+$/ui", $this->student->first_name))
		{
			$errors[] = 'Имя не должно быть длиннее 30 символов. Используйте только маленькие и заглавные буквы.';
		}



		if($this->student->last_name == '')
		{
			$errors[] = 'Вы не ввели фамилию';
		} elseif (!preg_match("/^[a-zA-Zа-яА-Я]{2,30}+$/ui", $this->student->last_name)) {
			$errors[] = 'Фамилия должна быть не длиннее 30 символов и состоять только из букв.';
		}



		if($this->student->group_id == '')
		{
			$errors[] = 'Вы не ввели свою группу';
		} elseif (!preg_match("/^[a-zA-Zа-яА-Я0-9]{2,6}+$/ui", $this->student->group_id)) {
			$errors[] = 'Название группы должна содержать минимум 2 символа(буквы и цифры). Максимум 6 символов.';
		}



		if($this->student->rating == '')
		{
			$errors[] = 'Вы не ввели количество баллов';
		} elseif (!preg_match("/^[0-9]{3}+$/ui", $this->student->rating)) {
			$errors[] = 'Колличество баллов должно содержать только числа.';
		} elseif ($this->student->rating < 0 or $this->student->rating > 300) {
			$errors[] = 'Колличество баллов не должно быть меньше нуля или быть больше 300.';
		}



		$pattern = "/[-a-z0-9!#$%&'*_`{|}~]+[-a-z0-9!#$%&'*_`{|}~\.=?]*@[a-zA-Z0-9_-]+[a-zA-Z0-9\._-]+/i";
		if($this->student->email == '')
		{
			$errors[] = 'Вы не ввели свой email';
		} elseif (!preg_match($pattern,$this->student->email)) {
			$errors[] = "Введите корректный email";
		}



		if($errors)
		{
			return $errors;
		} else {
			return true;
		}

	}
}