<?php
class Libro_Controller
{
	function nuevo()
	{
		if (!isset($_SESSION['usuario']))
		{ 
			$tpl = new TemplatePower("vistas/logueo.html");
			$tpl->prepare();
			$tpl->gotoBlock("_ROOT");	

			return $tpl->getOutputContent();
		}else{




						$articulo = new Libro_Model();
						$data=$_REQUEST;



						$tipo=htmlspecialchars($data["titulo"]);
						$articulo->setTitulo($tipo);

						$tipo=htmlspecialchars($data["autor"]);
						$articulo->setAutor($tipo);

						$tipo=htmlspecialchars($data["anio"]);
						$articulo->setAnio($tipo);

						$tipo=htmlspecialchars($data["isbn"]);
						$articulo->setIsbn($tipo);

						$tipo=htmlspecialchars($data["editorial"]);
						$articulo->setEditorial($tipo);

						$tipo=htmlspecialchars($data["paginas"]);
						$articulo->setCantidad($tipo);

						$tipo=htmlspecialchars($data["ejemplares"]);
						$articulo->setEjemplares($tipo);

						
						$res=$articulo->buscar();

						if($res==1)
						{
							 echo "<script> alert('[ERROR] Ya existe un libro registrado con ese <ISBN>!.');</script>";

							 $tp2 = new TemplatePower("vistas/welcome.html");
								$tp2->prepare();
								$tp2->gotoBlock("_ROOT");


																	//-------------------------------------------------------//
																								$articulo = new Socio_Model();
																								$valor = $articulo->obtener_listado();         // cuento los elementos de cada tabla de la BD.
																								$valor2 = $articulo->buscarNoHabilitado();
																								$x=count($valor);
																								$y=count($valor2);
																								//----------------------------------------------------------//		
																					

																								$tp2->assign("sociosTotal", $x);
																								$tp2->assign("sociosBaja", $y);


								return $tp2->getOutputContent();
						}else{


								$articulo->agregar();

								 echo "<script> alert('...NUEVO Libro agregado con exito!. Redireccionando...');</script>";

								#Libro  agregado !, redirecciono. 

								$tp2 = new TemplatePower("vistas/welcome.html");
								$tp2->prepare();
								$tp2->gotoBlock("_ROOT");

																	//-------------------------------------------------------//
																								$articulo = new Socio_Model();
																								$valor = $articulo->obtener_listado();         // cuento los elementos de cada tabla de la BD.
																								$valor2 = $articulo->buscarNoHabilitado();
																								$x=count($valor);
																								$y=count($valor2);
																								//----------------------------------------------------------//		
																					

																								$tp2->assign("sociosTotal", $x);
																								$tp2->assign("sociosBaja", $y);
							




								return $tp2->getOutputContent();
					         }
			}
	}



	function buscar()
	{
		if (isset($_SESSION['usuario']))
		{
			if(isset($_POST['buscar']))
			{
				$articulo = new Libro_Model();
				$data=$_REQUEST;

				$tipo=htmlspecialchars($data["isbn"]);
				$articulo->setIsbn($tipo);

				$res=$articulo->buscarTodo();


				if ($res == 0) {
					 echo "<script> alert('[ERROR] No hay UN LIBRO registrado con ese <ISBN>...');</script>";
					  $tp2 = new TemplatePower("vistas/welcome.html");
								$tp2->prepare();
								$tp2->gotoBlock("_ROOT");

																	//-------------------------------------------------------//
																								$articulo = new Socio_Model();
																								$valor = $articulo->obtener_listado();         // cuento los elementos de cada tabla de la BD.
																								$valor2 = $articulo->buscarNoHabilitado();
																								$x=count($valor);
																								$y=count($valor2);
																								//----------------------------------------------------------//		
																					

																								$tp2->assign("sociosTotal", $x);
																								$tp2->assign("sociosBaja", $y);

								return $tp2->getOutputContent();
				}else{

						$tp2= new TemplatePower("vistas/actualizar-libros.html");
						$tp2->prepare();
						$tp2->gotoBlock("_ROOT");


					

						if ($res)
						{
								foreach ($res as $res1){  

									  $tp2->assign("titulo", $res1['titulo']);
									  $tp2->assign("autor", $res1['autor']);
									  $tp2->assign("isbn", $res1['isbn']);
									  $tp2->assign("anio", $res1['anio']);	
									  $tp2->assign("editorial", $res1['editorial']);
									  $tp2->assign("paginas", $res1['paginas']);
									  $tp2->assign("ejemplares", $res1['ejemplares']);
								
							 	}	

					    }

					   return $tp2->getOutputContent();

					 }
			}

		}else{
				 echo "<script> alert('[Advertencia] Usted no cuenta con los privilegios para hacer esta accion. Redireccionando...');</script>";

				 $tp2 = new TemplatePower("vistas/logueo.html");
								$tp2->prepare();
								$tp2->gotoBlock("_ROOT");
								return $tp2->getOutputContent();
			 }
	}



	function modificar()
	{
		if (!isset($_SESSION['usuario']))
		{ 
			$tpl = new TemplatePower("vistas/logueo.html");
			$tpl->prepare();
			$tpl->gotoBlock("_ROOT");	

			return $tpl->getOutputContent();
		}else{




						$articulo = new Libro_Model();
						$data=$_REQUEST;



						$tipo=htmlspecialchars($data["titulo"]);
						$articulo->setTitulo($tipo);

						$tipo=htmlspecialchars($data["autor"]);
						$articulo->setAutor($tipo);

						$tipo=htmlspecialchars($data["anio"]);
						$articulo->setAnio($tipo);

						$tipo=htmlspecialchars($data["isbn"]);
						$articulo->setIsbn($tipo);

						$tipo=htmlspecialchars($data["editorial"]);
						$articulo->setEditorial($tipo);

						$tipo=htmlspecialchars($data["paginas"]);
						$articulo->setCantidad($tipo);

						$tipo=htmlspecialchars($data["ejemplares"]);
						$articulo->setEjemplares($tipo);

						
						$articulo->actualizar();


						 echo "<script> alert('[AVISO] Datos modificados con exito!...');</script>";
					 	    	 $tp2 = new TemplatePower("vistas/welcome.html");
								$tp2->prepare();
								$tp2->gotoBlock("_ROOT");

																	//-------------------------------------------------------//
																								$articulo = new Socio_Model();
																								$valor = $articulo->obtener_listado();         // cuento los elementos de cada tabla de la BD.
																								$valor2 = $articulo->buscarNoHabilitado();
																								$x=count($valor);
																								$y=count($valor2);
																								//----------------------------------------------------------//		
																					

																								$tp2->assign("sociosTotal", $x);
																								$tp2->assign("sociosBaja", $y);

								return $tp2->getOutputContent();
				}
	}




	function eliminar()
	{
		if (isset($_SESSION['usuario']))
		{
			if(isset($_POST['buscar']))
			{
				$articulo = new Libro_Model();
				$data=$_REQUEST;

				$tipo=htmlspecialchars($data["isbn"]);
				$articulo->setIsbn($tipo);

				$res=$articulo->buscarTodo();

				if ($res==0) {

					 echo "<script> alert('[ERROR] No existen libros registrados con ese ISBN...');</script>";
					 	    	 $tp2 = new TemplatePower("vistas/welcome.html");
								$tp2->prepare();
								$tp2->gotoBlock("_ROOT");

																	//-------------------------------------------------------//
																								$articulo = new Socio_Model();
																								$valor = $articulo->obtener_listado();         // cuento los elementos de cada tabla de la BD.
																								$valor2 = $articulo->buscarNoHabilitado();
																								$x=count($valor);
																								$y=count($valor2);
																								//----------------------------------------------------------//		
																					

																								$tp2->assign("sociosTotal", $x);
																								$tp2->assign("sociosBaja", $y);

								return $tp2->getOutputContent();
					
				}else{
						$articulo->eliminar();

						 echo "<script> alert('[AVISO] Libro eliminado con exito!...');</script>";
					 	    	 $tp2 = new TemplatePower("vistas/welcome.html");
								$tp2->prepare();
								$tp2->gotoBlock("_ROOT");

																	//-------------------------------------------------------//
																								$articulo = new Socio_Model();
																								$valor = $articulo->obtener_listado();         // cuento los elementos de cada tabla de la BD.
																								$valor2 = $articulo->buscarNoHabilitado();
																								$x=count($valor);
																								$y=count($valor2);
																								//----------------------------------------------------------//		
																					

																								$tp2->assign("sociosTotal", $x);
																								$tp2->assign("sociosBaja", $y);

								return $tp2->getOutputContent();
					 }
			}
		}
	}



	










}

?>

