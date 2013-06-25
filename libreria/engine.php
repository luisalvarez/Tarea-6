<?php
session_start();

include("configx.php");
include("conexion.php");
include("asgControls.php");
include("genclas.php");
include("utils.php");
include("sfacil.php");
include("mantenimiento.php");
include("mantenimientoSimple.php");
include("shortclass.php");
include("Calendario.php");
include("language.php");
include("seguridad.php");


date_default_timezone_set("America/Santo_Domingo");


function radioSet($name, $labels, $values, $val=""){
	
	foreach($labels as $k=>$label){
		$checked = ($values[$k] == $val)?'checked':'';
		echo "<label>
			<input {$checked} type='radio' name='{$name}' value='{$values[$k]}'/>
			{$label}
		</label>";
	}
	
}