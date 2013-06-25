<?php

class btn_data{
	public $tipo ;
	public $text;
	public $tipo_HTML;
	public $extra;
	function __construct($tipo_HTML, $tipo, $text,$extra){
		$this->tipo = $tipo;
		$this->text = $text;
		$this->tipo_HTML = $tipo_HTML;
		$this->extra = $extra;
	}
	
	function __toString()
	{
		return $this->tipo;
	}
}

class soloTexto{
	private $txt;
	public function __construct($txt)
	{
		$this->txt = $txt;
		
	}
	function __toString(){
		return $this->txt;
	}
}

class setearBotonesDeLaBarra
{
	function __destruct(){
		echo "<script language='javascript'> \$('.btn_toolbar_asg').button(); </script>";
	}
}


class seq{								
	public static function btnGuardar($extra='',$text='Guardar', $tipo_HTML='submit'){$b = new btn_data($tipo_HTML, 'btnGuardar',$text,$extra); return $b; }
	public static function btnNuevo($extra='',$text='Nuevo', $tipo_HTML='button'){$b = new btn_data($tipo_HTML, 'btnNuevo',$text,$extra); return $b; }
	public static function btnEliminar($extra='',$text='Eliminar', $tipo_HTML='button'){$b = new btn_data($tipo_HTML, 'btnEliminar',$text,$extra); return $b; }
	public static function btnBuscar($extra='',$text='Buscar', $tipo_HTML='button'){$b = new btn_data($tipo_HTML, 'btnBuscar',$text,$extra); return $b; }
	public static function btnEditar($extra='',$text='Editar', $tipo_HTML='button'){$b = new btn_data($tipo_HTML, 'btnEditar',$text,$extra); return $b; }
	public static function btnInscribirEstudiante($extra='',$text='Inscribir', $tipo_HTML='button'){$b = new btn_data($tipo_HTML, 'btnInscribirEstudiante',$text,$extra); return $b; }
	public static function btnImprimir($extra='',$text='Imprimir', $tipo_HTML='button'){$b = new btn_data($tipo_HTML, 'btnImprimir',$text,$extra); return $b; }
	
	private static function generarCodigoBarra($params){

		$sf = $_SERVER['SCRIPT_NAME'];
		$sf = substr($sf,1,strlen($sf));
		$p = substr($sf,strrpos($sf, '/')+1, strlen($sf));
		$inicio = substr($sf,0,strpos($sf, '/'));
		$sf = str_replace("/{$p}", '', $sf);
		$modulo = substr($sf,strrpos($sf, '/'), strlen($sf));
		$modulo = str_replace('/','',$modulo);
		if($modulo == $inicio){
			$modulo = "";
		}
		$const = "{$modulo}{$p}";
		
		if(!defined($const)){
			define($const, true);
			$sql = "INSERT INTO `seq_paginas` (nombre, modulo) 
			VALUES ('{$p}','{$modulo}') ON DUPLICATE KEY 
			UPDATE nombre = '{$p}', modulo='{$modulo}'";
			asgMng::query($sql);			
		}
		
				
		$extra = "";
		$s = '';
		$s.= "<div id='' style='' class='toolbar_asg ui-widget-header ui-corner-all'>";
		foreach($params as $param){
			if(get_class($param) == 'btn_data'){
				$s .= "<button style='height:25px; padding:0px' class='btn_toolbar_asg' type='$param->tipo_HTML' $param->extra>$param->text</button>";
			}else{
				$extra = $param;
			}
		}
		
		$s .= "{$extra}</div>";
		
		if(!defined('CODIGO_AL_FINAL_DE_LA_BARRA')){
			$ja = new setearBotonesDeLaBarra();
			define('CODIGO_AL_FINAL_DE_LA_BARRA',true);
		}
		
		return $s;
		
	}
	/**
	 * Fabrica una barra y la retorna
	 */
	public static function fabricarBarra(){
		return self::generarCodigoBarra(func_get_args());
	}
	
	/**
	 * Muestra una barra sin retornarla
	 */
	public static function mostrarBarra(){
		echo self::generarCodigoBarra(func_get_args());
	}
	
}



function validarSeguridad(){
	$s = $_SERVER['SCRIPT_NAME'];
	$s= substr($s, strrpos($s, '/')+1, strlen($s));
//	echo $s;
}

class menuItem{
	public $cod;
	public $text;
	public $href;
	public $items;
	public $title;
	public $extra;
	function __construct($cod,$text, $href,$items=array(),$title='',$extra=''){
		$this->cod = $cod;
		$this->text = $text;
		$this->href = $href;
		$this->items = $items;
		$this->title = $title;
		$this->extra = $extra;
	}
}

class menu{
	public $menuItems;
	function __construct(){
		$this->menuItems = array(
			new menuItem('inicio','Inicio','inicio.php',array(),'inicio'),
			
			new menuItem('estudiante','Estudiantes','#',array(
				new menuItem('estudiante_familias','Familias','modulos/estudiantes/padres.php'),
				new menuItem('estudiante_estudiante','Estudiantes','modulos/estudiantes/estudiantes.php'),
				new menuItem('estudiante_calificaciones','Consulta de Calificaciones','#'),
				new menuItem('estudiante_solicitudes','Solicitudes','#'),
				new menuItem('estudiante_mensajes','Mensajes','#'),
				)),
				
			
			new menuItem('caja','Caja','#',array(
				new menuItem('caja_abrir','Abrir Caja','#',array(),'','onclick="abrirCajaNew();"'),
				//new menuItem('caja_inscripcion','Inscripcion','modulos/caja/inscripcion.php'),
				new menuItem('caja_mensualidad','Cobros','modulos/caja/mensualidad.php'),
				new menuItem('caja_cierre','Cierre de caja','modulos/caja/cierre.php'),
				new menuItem('caja_generar_notificacion_atrazo','Circular de pago','modulos/caja/generar_notif_pagos.php'),
				new menuItem('caja_comprobantesFiscales','Comprobantes Fiscales','modulos/caja/comprobantes.php')
			)),
				
			new menuItem('registro','Registro','#',array(
				new menuItem('registro_calificaciones','Calificaciones','modulos/registro/calificaciones.php'),
				new menuItem('registro_asistencia','Asistencia','#'),
				new menuItem('registro_mensajes','Mensajes','#')
			)),
			new menuItem('direccion','Direccion','#',array(
				new menuItem('direccion_calendario','Calendario Academico','#'),
				new menuItem('direccion_horarios','Horarios de clases','#'),
				new menuItem('direccion_mural','Mural Digital','#'),
				new menuItem('direccion_becas','Becas','modulos/direccion/becas.php')
			)),
			new menuItem('personal','Personal','#',array(
				new menuItem('personal_empleados','Empleados','#'),
				new menuItem('personal_asistencia','Asistencia','#'),
				new menuItem('personal_nomina','Nomina','#')
			)),
			new menuItem('reportes','Reportes','#',array(
				new menuItem('reportes_estudiantes','Estudiantes',"modulos/reportes/listadoEst.php"),
				new menuItem('reportes_cierres','Cierres',"modulos/reportes/reporteCierres.php"),
				new menuItem('reportes_ingresos','Ingresos',"modulos/reportes/reporteIngresos.php"),
				new menuItem('reportes_asistencia','Asistencia',"#"),
				new menuItem('reportes_nomina','Nomina',"#")
			)),
			new menuItem('configuracion','Configuracion','#',array(
				new menuItem('configuracion_eventos','Eventos','modulos/mantenimientos/eventos.php'),
				new menuItem('configuracion_cursos','Cursos','modulos/mantenimientos/cursos.php'),
				new menuItem('configuracion_aulas','Aulas','modulos/mantenimientos/aulas.php'),
				new menuItem('configuracion_secciones','Secciones','modulos/mantenimientos/secciones.php'),
				new menuItem('configuracion_profesores','Profesores','modulos/mantenimientos/profesores.php'),
				new menuItem('configuracion_materias','Materias','modulos/mantenimientos/materias.php'),
				new menuItem('configuracion_becas','Def Becas','modulos/mantenimientos/becas.php'),
				new menuItem('configuracion_becas','Usuarios','modulos/mantenimientos/usuarios.php')
			)),
			new menuItem('ayuda','Ayuda','#',array(
				new menuItem('ayuda_manual','Manual de Usuario','#'),
				new menuItem('ayuda_soporte','Soporte Tecnico','#')
			))			
		);
	}
}
			