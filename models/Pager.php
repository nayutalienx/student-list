<?php
class Pager {

	public $totalRecords, $amountRecords, $template;

	public function __construct($totalRecords, $amountRecords, $template)
	{
		$this->totalRecords = $totalRecords;
		$this->amountRecords = $amountRecords;
		$this->template = $template;
	}

	public function getAllPages()
	{
		$temp = $this->totalRecords / $this->amountRecords;
		$result = ceil($temp);
		return $result;
	}

	public function getLinks($current)
	{
		$result = array();
		for($i = 1; $i <= $this->getAllPages(); $i++)
		{
			$result[] = array('link' => $this->template.'?page='.$i,
							  'page' => $i,
							  'underline' => ($current == $i) ? 'text-decoration: underline;' : '');
		}
		return $result;
	}

	public function getSearchLinks($current,$query)
	{
		$result = array();
		for($i = 1; $i <= $this->getAllPages(); $i++)
		{
			$result[] = array('link' => $this->template.'?page='.$i.'&search='.$query,
							  'page' => $i,
							  'underline' => ($current == $i) ? 'text-decoration: underline;' : '');
		}
		return $result;
	}

	public function getSortLinks($current, $order, $desc)
	{
		$result = array();
		for($i = 1; $i <= $this->getAllPages(); $i++)
		{
			$result[] = array('link' => $this->template.'?page='.$i.'&sort='.$order.'&desc='.$desc,
							  'page' => $i,
							  'underline' => ($current == $i) ? 'text-decoration: underline;' : '');
		}
		return $result;
	}

	public function getSortSearchLinks($current, $order, $desc, $search)
	{
		$result = array();
		for($i = 1; $i <= $this->getAllPages(); $i++)
		{
			$result[] = array('link' => $this->template.'?page='.$i.'&sort='.$order.'&desc='.$desc.'&search='.$search,
							  'page' => $i,
							  'underline' => ($current == $i) ? 'text-decoration: underline;' : '');
		}
		return $result;
	}



	public function getPositionLinks($current,$links)
	{
		
		$result = array();
		if($current>=4)
		{
			if($current >= count($links)-2)
			{
				$counter = count($links) - 5;
				for($i = 0; $i < 5; $i++)
				{
					if(isset($links[$counter])){
					$result[] = $links[$counter];
					}	
					$counter = $counter + 1;
				}
			}
			else 
			{
				for($i = $current; $i < $current+5; $i++)
				{
					$result[] = $links[$i-3];
				}
			}

		}
		else
		{
			for($i=0; $i<5;$i++)
			{
				if(isset($links[$i])){
					$result[] = $links[$i];
				}
			}
		}
		return $result;

	}


}