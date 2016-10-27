<?php

class Usuario_Model{

		
		private $nombre;
		private $pass;
	


		public function setPass($pass){
			$this->pass = $pass;
		}

		public function getPass(){
			return $this->pass;
		}

		public function getNombre()
		{
			return $this->nombre;
		}

		public function setNombre($nombre){
			$this->nombre = $nombre;
		}

	


/*///////////////////////////////////////////////////////////////////////////////////////////////////*/
//
//											Funciones especiales.-                                   //
//
/*///////////////////////////////////////////////////////////////////////////////////////////////////*/



	function obtener_Usuario($variable1, $variable2)
	{		
		global $db; // Indicamos que vamos a utlizar la variable global $db definida en el index.php
		$resultado=$db->select("SELECT * FROM usuarios WHERE  id_usuario ='".$variable1."' AND  pass = '".$variable2."'  ");
			
			if (is_null($resultado) || empty($resultado)) {
			# code...
			$valor=0;
			return $valor;
		}else{
				return $resultado;
			 }
			 
	}

	


}
?>