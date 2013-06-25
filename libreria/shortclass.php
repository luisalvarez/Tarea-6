<?php
class super extends genclas{

	function __construct($id=0){
		parent::__construct('super',$id);
	
	}
	
	static function getSuperTotal(){
		$sql = "select id from super";
		$dt = new dataTable($sql);
		return $dt->numRows;
	
	}
	
	static function todosLosSuper(){
		$sql = "select *, '' as accion from super";
		return new dataTable($sql);
	}
}


class poder extends genclas{

	function __construct($id=0){
		parent::__construct('poder',$id);
	
	}

		
	static function todosLosPoderes(){
		$sql = "select *, '' as accion from poder";
		return new dataTable($sql);
	}
}