<?php
class Prestamo_Model
{
	private $id;
	private $socio;
	private $prestamo;
	private $devolucion;
	private $libro1;
	private $libro2;
	private $libro3;
	

		public function setId($id){
			$this->id = $id;
		}

		public function setSocio($socio){
			$this->socio = $socio;
		}

		public function getSocio(){
			return $this->socio;
		}

		public function setPrestamo($prestamo){
			$this->prestamo = $prestamo;
		}

		public function getPrestamo(){
			return $this->prestamo;
		}

		public function setDevolucion($devolucion){
			$this->devolucion = $devolucion;
		}

		public function getDevolucion(){
			return $this->devolucion;
		}

		public function setLibro1($libro1){
			$this->libro1 = $libro1;
		}

		public function getLibro1(){
			return $this->libro1;
		}		

		public function setLibro2($libro2){
			$this->libro2 = $libro2;
		}

		public function getLibro2(){
			return $this->libro2;
		}

		public function setLibro3($libro3){
			$this->libro3 = $libro3;
		}

		public function getLibro3(){
			return $this->libro3;
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
		
		$sql= "INSERT INTO prestamos(socio, fecha_prestamo, fecha_devolucion, libro1) 
		       VALUES ('".$this->socio."','".$this->prestamo."','".$this->devolucion."','".$this->libro1."');"; 

		$result=$db->insert($sql,false);
	}


	function buscar(){
		global $db; // Indicamos que vamos a utlizar la variable global $db definida en el index.php
		$resultado=$db->select("SELECT * FROM prestamos WHERE socio=$this->socio"); // realizamos la consulta
		
		if (is_null($resultado) || empty($resultado)) {
			# code...
			$valor=0;
			return $valor;
		}else{
				$valor=1;
				return $valor;
			 }
	}

	function pendientes(){
		global $db; // Indicamos que vamos a utlizar la variable global $db definida en el index.php
		$resultado=$db->select("SELECT * FROM prestamos WHERE socio=$this->socio and devuelto='NO'"); // realizamos la consulta
		
		if (is_null($resultado) || empty($resultado)) {
			# code...
			$valor=0;
			return $valor;
		}else{
				
				return $resultado;
			 }
	}

	function retorno($valor){
		global $db; // Indicamos que vamos a utlizar la variable global $db definida en el index.php
		$resultado=$db->select("SELECT * FROM prestamos WHERE cod_prestamo=$valor "); // realizamos la consulta
		
		if (is_null($resultado) || empty($resultado)) {
			# code...
			$valor=0;
			return $valor;
		}else{
				
				return $resultado;
			 }
	}


	function obtener_listado(){
		global $db; // Indicamos que vamos a utlizar la variable global $db definida en el index.php
		$resultado=$db->select("SELECT * FROM prestamos"); // realizamos la consulta
		return $resultado; // retornamos el resultado
	}


	function buscarTodo(){
		global $db; // Indicamos que vamos a utlizar la variable global $db definida en el index.php
		$resultado=$db->select("SELECT * FROM prestamos WHERE socio=$this->socio"); // realizamos la consulta
		
		if (is_null($resultado) || empty($resultado)) {
			# code...
			$valor=0;
			return $valor;
		}else{
				
				return $resultado;
			 }
	}



	function prestados(){
		global $db; // Indicamos que vamos a utlizar la variable global $db definida en el index.php
		$resultado=$db->select("SELECT * FROM prestamos WHERE devuelto='NO'"); // realizamos la consulta
		
		if (is_null($resultado) || empty($resultado)) {
			# code...
			$valor=0;
			return $valor;
		}else{
				
				return $resultado;
			 }
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
		 
		$sql= "UPDATE prestamos SET  libro1='$this->libro1', autor='$this->autor', isbn='$this->isbn',
									 anio='$this->anio', paginas='$this->cantidad', ejemplares='$this->ejemplares'
		                              
		       WHERE isbn='$this->isbn' ;"; 

		$result=$db->update($sql);
	}     //revisar metodos especiales



	function regresar()
	{
		
		global $db;
		$result=false;
		

		 
		$sql= "UPDATE prestamos SET  devuelto='SI'
		                              
		       WHERE cod_prestamo='$this->id' ;"; 

		$result=$db->update($sql);
	} 


}

?>