<?php

require_once 'models/Pager.php';
require_once 'models/Sorter.php';

$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;


if(isset($_GET['search']))
{
	$order = isset($_GET['sort']) ? $_GET['sort'] : $config['default_order'];
	$desc = isset($_GET['desc']) ? $_GET['desc'] : 1;
	$students = $data_gateway->search($_GET['search'],$currentPage, $config['amount_records'], $order,$desc);
	$counts = $data_gateway->rowSearchCount($_GET['search']);
	$pager = new Pager($counts, $config['amount_records'] ,$config['domen']);
	if(isset($_GET['sort']))
	{
		$allLinks = $pager->getSortSearchLinks($currentPage, $order, $desc, $_GET['search']);
	} else 
	{
		$allLinks = $pager->getSearchLinks($currentPage ,$_GET['search']);
	}

	$sorter = new Sorter($config['domen']);
	$temp_desc = $sorter->reverseDesc($desc);
	$sort_links = $sorter->getSearchLinks($temp_desc,$_GET['search'],$currentPage);
	$last_page = $allLinks[count($allLinks)-1]['link'];
	
} 
else
{
	$order = isset($_GET['sort']) ? $_GET['sort'] : $config['default_order'];
	$desc = isset($_GET['desc']) ? $_GET['desc'] : 1;
	$students = $data_gateway->getAll($currentPage,$config['amount_records'],$order,$desc);
	$counts = $data_gateway->rowCount();
	$pager = new Pager($counts, $config['amount_records'] ,$config['domen']);
	if(isset($_GET['sort']))
	{
		$allLinks = $pager->getSortLinks($currentPage, $order, $desc);
	}
	else 
	{
		$allLinks = $pager->getLinks($currentPage);
	}

	$sorter = new Sorter($config['domen']);
	$temp_desc = $sorter->reverseDesc($desc);
	$sort_links = $sorter->getLinks($temp_desc,$currentPage);
	$last_page = $allLinks[count($allLinks)-1]['link'];
	

}
$user = $data_gateway->getByToken($_COOKIE['token']);
$user = (array) $user;

$allLinks = $pager->getPositionLinks($currentPage,$allLinks);


$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';













include 'view/main.html';