<?php
class Socio_Model{

	private $nombre;
	private $apellido;
	private $cuil;
	private $fecha;
	private $mail;
	private $fijo;
	private $movil;


		public function setNombre($nombre){
			$this->nombre = $nombre;
		}

		public function getNombre(){
			return $this->nombre;
		}


		public function setApellido($apellido){
			$this->apellido = $apellido;
		}

		public function getApellido(){
			return $this->apellido;
		}


		public function setCuil($cuil){
			$this->cuil = $cuil;
		}

		public function getCuil(){
			return $this->cuil;
		}


		public function setFecha($fecha){
			$this->fecha = $fecha;
		}

		public function getFecha(){
			return $this->fecha;
		}


		public function setMail($mail){
			$this->mail = $mail;
		}

		public function getMail(){
			return $this->mail;
		}


		public function setFijo($fijo){
			$this->fijo = $fijo;
		}

		public function getFijo(){
			return $this->fijo;
		}



		public function setMovil($movil){
			$this->movil = $movil;
		}

		public function getMovil(){
			return $this->movil;
		}



/*///////////////////////////////////////////////////////////////////////////////////////////////////*/
//
//											Funciones especiales.-                                   //
//
/*///////////////////////////////////////////////////////////////////////////////////////////////////*/


	function agregar()
	{
		// logica para agregar usuarios + control de usuario existente usando el cuil
		global $db;
		$result=false;
		
		$sql= "INSERT INTO socios(nombre, apellido, cuil, fecha_nac, mail, tel_fijo, movil) 
		       VALUES ('".$this->nombre."','".$this->apellido."','".$this->cuil."','".$this->fecha."',
		       	        '".$this->mail."','".$this->fijo."','".$this->movil."');"; 

		$result=$db->insert($sql,false);
	}


	function buscar(){
		global $db; // Indicamos que vamos a utlizar la variable global $db definida en el index.php
		$resultado=$db->select("SELECT * FROM socios WHERE cuil=$this->cuil"); // realizamos la consulta
		
		if (is_null($resultado) || empty($resultado)) {
			# code...
			$valor=0;
			return $valor;
		}else{
				$valor=1;
				return $valor;
			 }
	}


	function obtener_listado(){
		global $db; // Indicamos que vamos a utlizar la variable global $db definida en el index.php
		$resultado=$db->select("SELECT * FROM socios"); // realizamos la consulta
		return $resultado; // retornamos el resultado
	}


	function buscarTodo(){
		global $db; // Indicamos que vamos a utlizar la variable global $db definida en el index.php
		$resultado=$db->select("SELECT * FROM socios WHERE cuil=$this->cuil"); // realizamos la consulta
		
		if (is_null($resultado) || empty($resultado)) {
			# code...
			$valor=0;
			return $valor;
		}else{
				
				return $resultado;
			 }
	}

	function buscarHabilitado(){
		global $db; // Indicamos que vamos a utlizar la variable global $db definida en el index.php
		$resultado=$db->select("SELECT * FROM socios WHERE cuil=$this->cuil and suspender='NO'"); // realizamos la consulta
		
		if (is_null($resultado) || empty($resultado)) {
			# code...
			$valor=0;
			return $valor;
		}else{
				
				return $resultado;
			 }
	}

	function buscarNoHabilitado(){
		global $db; // Indicamos que vamos a utlizar la variable global $db definida en el index.php
		$resultado=$db->select("SELECT * FROM socios WHERE suspender='SI'"); // realizamos la consulta
		
		
				
				return $resultado;
		
	}


	function actualizar()
	{
		
		global $db;
		$result=false;
		/*$this->nombre = mysqli_real_escape_string($db, $this->nombre);
		$this->apellido = mysqli_real_escape_string($db, $this->apellido);
		$this->cuil = mysqli_real_escape_string($db, $this->cuil);
		$this->fecha = mysqli_real_escape_string($db, $this->fecha);
		$this->mail = mysqli_real_escape_string($db, $this->mail);
		$this->fijo = mysqli_real_escape_string($db, $this->fijo);
        $this->movil = mysqli_real_escape_string($db, $this->movil);*/
		 
		$sql= "UPDATE socios SET  nombre='$this->nombre', apellido='$this->apellido', fecha_nac='$this->fecha',
									 mail='$this->mail', tel_fijo='$this->fijo', movil='$this->movil'
		                              
		       WHERE cuil='$this->cuil' ;"; 

		$result=$db->update($sql);
	}
	

	function suspender()
	{
		global $db;
		$result=false;
		
		 
		$sql= "UPDATE socios SET  suspender='SI'
		                              
		       WHERE cuil='$this->cuil' ;"; 

		$result=$db->update($sql);
	}

	function noSuspender()
	{
		global $db;
		$result=false;
		
		 
		$sql= "UPDATE socios SET  suspender='NO'
		                              
		       WHERE cuil='$this->cuil' ;"; 

		$result=$db->update($sql);
	}


}
?>