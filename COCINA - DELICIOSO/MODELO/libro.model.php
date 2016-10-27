<?php
class Libro_Model
{
	private $titulo;
	private $autor;
	private $anio;
	private $isbn;
	private $editorial;
	private $cantidad;
	private $ejemplares;



		public function setTitulo($titulo){
			$this->titulo = $titulo;
		}

		public function getTitulo(){
			return $this->titulo;
		}


		public function setAutor($autor){
			$this->autor = $autor;
		}

		public function getAutor(){
			return $this->autor;
		}

		public function setAnio($anio){
			$this->anio = $anio;
		}

		public function getAnio(){
			return $this->anio;
		}

		public function setIsbn($isbn){
			$this->isbn = $isbn;
		}

		public function getIsbn(){
			return $this->isbn;
		}

		public function setEditorial($editorial){
			$this->editorial = $editorial;
		}

		public function getEditorial(){
			return $this->editorial;
		}

		public function setCantidad($cantidad){
			$this->cantidad = $cantidad;
		}

		public function getCantidad(){
			return $this->cantidad;
		}

		public function setEjemplares($ejemplares){
			$this->ejemplares = $ejemplares;
		}

		public function getEjemplares(){
			return $this->ejemplares;
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
		
		$sql= "INSERT INTO libros(titulo, autor, isbn, anio, editorial, paginas, ejemplares) 
		       VALUES ('".$this->titulo."','".$this->autor."','".$this->isbn."','".$this->anio."',
		       	        '".$this->editorial."','".$this->cantidad."','".$this->ejemplares."');"; 

		$result=$db->insert($sql,false);
	}


	function buscar(){
		global $db; // Indicamos que vamos a utlizar la variable global $db definida en el index.php
		$resultado=$db->select("SELECT * FROM libros WHERE isbn=$this->isbn"); // realizamos la consulta
		
		if (is_null($resultado) || empty($resultado)) {
			# code...
			$valor=0;
			return $valor;
		}else{
				$valor=1;
				return $valor;
			 }
	}

	function nombre()
	{
		global $db; // Indicamos que vamos a utlizar la variable global $db definida en el index.php
		$resultado=$db->select("SELECT titulo FROM libros WHERE isbn=$this->isbn"); // realizamos la consulta
		
		
				
				return $resultado;
			
	}


	function obtener_listado(){
		global $db; // Indicamos que vamos a utlizar la variable global $db definida en el index.php
		$resultado=$db->select("SELECT * FROM libros"); // realizamos la consulta
		return $resultado; // retornamos el resultado
	}


	function buscarTodo(){
		global $db; // Indicamos que vamos a utlizar la variable global $db definida en el index.php
		$resultado=$db->select("SELECT * FROM libros WHERE isbn=$this->isbn"); // realizamos la consulta
		
		if (is_null($resultado) || empty($resultado)) {
			# code...
			$valor=0;
			return $valor;
		}else{
				
				return $resultado;
			 }
	}


	function stock(){
		global $db; // Indicamos que vamos a utlizar la variable global $db definida en el index.php
		$resultado=$db->select("SELECT ejemplares FROM libros WHERE isbn=$this->isbn"); // realizamos la consulta
			
				return $resultado;
			
	}


	function down()
	{
		global $db;
		$result=false;
		 
		$sql= "UPDATE libros SET  ejemplares = ejemplares - 1
		                              
		       WHERE isbn='$this->isbn' ;"; 

		$result=$db->update($sql);
	}


	function up()
	{
		global $db;
		$result=false;
		 
		$sql= "UPDATE libros SET  ejemplares = ejemplares + 1
		                              
		       WHERE isbn='$this->isbn' ;"; 

		$result=$db->update($sql);
	}

	function eliminar()
	{
		global $db;
			
		$resultado=$db->delete("DELETE FROM `libros` WHERE isbn='$this->isbn'");			
		return $resultado;
	}


	function disponible(){
		global $db; // Indicamos que vamos a utlizar la variable global $db definida en el index.php
		$resultado=$db->select("SELECT * FROM libros WHERE isbn=$this->isbn"); // realizamos la consulta
		
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
		 
		$sql= "UPDATE libros SET  titulo='$this->titulo', autor='$this->autor', isbn='$this->isbn',
									 anio='$this->anio', paginas='$this->cantidad', ejemplares='$this->ejemplares'
		                              
		       WHERE isbn='$this->isbn' ;"; 

		$result=$db->update($sql);
	}


}

?>
