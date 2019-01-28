<?php

class TableDataGateway
{
	private $pdo, $table;
	public function __construct(DataBase $base, $table)
	{
		$this->pdo = $base->pdo;
		$this->table = $table;
	}
	public function add($student)
	{
		$sql = "INSERT INTO ".$this->table." (first_name, last_name, sex, group_id, email, rating, birthday, local, token) VALUES (:first_name, :last_name, :sex, :group_id, :email, :rating, :birthday, :local, :token)";
		$executor = $this->pdo->prepare($sql);
		
		$executor->execute(['first_name' => $student->first_name, 'last_name' => $student->last_name, 'group_id' => $student->group_id, 'rating' => $student->rating, 'email' => $student->email, 'birthday' => $student->birthday, 'sex' => $student->sex, 'local' => $student->local, 'token' => $student->token]);
		
	}

	public function getAll($page,$amount_records, $order, $desc)
	{
		$page = $page - 1;
		$offset = $page*$amount_records;
		if($desc == 1){
		$sql = sprintf('SELECT * FROM '.$this->table.' ORDER BY %1$s DESC LIMIT :x , :y',$order);
		} else 
		{
			$sql = sprintf('SELECT * FROM '.$this->table.' ORDER BY %1$s LIMIT :x , :y',$order);
		}
		$students = $this->pdo->prepare($sql);
		//$students->bindValue(':order', $order, PDO::PARAM_STR);
		$students->bindValue(':x', $offset, PDO::PARAM_INT);
		$students->bindValue(':y', $amount_records, PDO::PARAM_INT);
		$students->execute();
		$result = $students->fetchAll();
		return $result;
	}

	public function search($text, $page, $amount_records, $order, $desc)
	{
		$query = '%'.$text.'%';
		$page = $page - 1;
		$offset = $page*$amount_records;

		
		
		if($desc == 1){
		$sql = sprintf('SELECT * FROM '.$this->table.' WHERE first_name LIKE :query OR last_name LIKE :query ORDER BY %1$s DESC LIMIT :x , :y',$order);
		} else 
		{
			$sql = sprintf('SELECT * FROM '.$this->table.' WHERE first_name LIKE :query OR last_name LIKE :query ORDER BY %1$s LIMIT :x , :y',$order);
		}



		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':query', $query, PDO::PARAM_STR);
		$stmt->bindValue(':x',$offset,PDO::PARAM_INT);
		$stmt->bindValue(':y',$amount_records,PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();
		return $result;

	}

	public function rowSearchCount($text)
	{
		$query = '%'.$text.'%';
		$sql = "SELECT COUNT(*) FROM ".$this->table." WHERE first_name LIKE :query OR last_name LIKE :query";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([':query' => $query]);	
		$result = $stmt->fetchColumn();
		return $result;

	}

	public function rowCount() 
	{

		$sql = "SELECT COUNT(*) FROM ".$this->table;
		$students = $this->pdo->query($sql);
		$result = $students->fetchColumn();
		return $result;		

	}

	public function getByToken($token)
	{
		$sql = "SELECT * FROM ".$this->table." WHERE token = :token";
		$student = $this->pdo->prepare($sql);
		$student->execute(['token' => $token]);
		$result =  $student->fetch();
		return $result;
	}

	public function getByEmail($email)
	{
		$sql ="SELECT * FROM ".$this->table." WHERE email = :email";
		$student = $this->pdo->prepare($sql);
		$student->execute(['email' => $email]);
		$result = $student->fetch();
		return $result;
	}

	public function update($student)
	{
		$sql = "UPDATE ".$this->table." SET first_name = :first_name, last_name = :last_name, sex = :sex, group_id = :group_id, email = :email, rating = :rating, birthday = :birthday, local = :local WHERE token = :token";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(['first_name' => $student->first_name, 'last_name' => $student->last_name, 'group_id' => $student->group_id, 'rating' => $student->rating, 'email' => $student->email, 'birthday' => $student->birthday, 'sex' => $student->sex, 'local' => $student->local, 'token' => $student->token]);
	}


}