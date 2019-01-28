<?php

class Sorter
{

	public $template;

	public function __construct($template)
	{
		$this->template = $template;
	}

	public function getLink($sorting,$desc,$currentPage)
	{
		$result = $this->template.'?sort='.$sorting.'&desc='.$desc.'&page='.$currentPage;
		return $result;
	}

	public function getLinks($desc,$currentPage)
	{
		$result = array('first_name' => $this->getLink('first_name',$desc,$currentPage),
					'last_name' => $this->getLink('last_name',$desc,$currentPage),
					'group_id' => $this->getLink('group_id',$desc,$currentPage),
					'rating' => $this->getLink('rating',$desc,$currentPage));
		return $result;
	}

	public function reverseDesc($desc)
	{

		
			
			if($desc == 1){
				$temp_desc = 0;
			}
			else{
				$temp_desc = 1;
			}
		
		return $temp_desc;

	}


	public function getSearchLink($sorting, $desc, $search,$currentPage)
	{
		$result = $this->template.'?search='.$search.'&sort='.$sorting.'&desc='.$desc.'&page='.$currentPage;
		return $result;
	}

	public function getSearchLinks($desc, $search, $currentPage)
	{
		$result = array('first_name' => $this->getSearchLink('first_name',$desc,$search,$currentPage),
				  		'last_name' => $this->getSearchLink('last_name',$desc,$search,$currentPage),
				  		'group_id' => $this->getSearchLink('group_id',$desc,$search,$currentPage),
				  		'rating' => $this->getSearchLink('rating',$desc,$search,$currentPage));
		return $result;
	}


	

}