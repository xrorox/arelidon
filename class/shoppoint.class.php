<?php
class shop_point{
	
	private $itemCollection;
	
	function __construct(){
		
		$this->loadShop_points();
	}
	
	function SetItemCollection($items){
		$this->itemCollection=$items;;
	}
	function GetItemCollection(){
		return $this->itemCollection;
	}
	function loadShop_points(){
		$sql="SELECT * FROM `objet` WHERE magasin=1 ";
		$items=loadSqlResultArrayList($sql);
		
		$this->SetItemCollection($items);
	}
	
	
}
?>