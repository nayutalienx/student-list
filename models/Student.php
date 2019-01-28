<?php 

class Student
{
	public $first_name, $last_name, $group_id, $rating, $email , $birthday, $sex, $local,$token;
	public function __construct($first_name, $last_name, $group_id, $rating, $email , $birthday, $sex, $local, $token)
	{
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->group_id = $group_id;
		$this->rating = $rating;
		$this->email = $email;
		$this->birthday = $birthday;
		$this->sex = $sex;
		$this->local = $local;
		$this->token = $token;
	}


}