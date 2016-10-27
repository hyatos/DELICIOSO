<?php
class Prestamo_Controller
{
	
	function buscar()
	{
		if (isset($_SESSION['usuario']))
		{
			if(isset($_POST['buscar']))
			{
				$articulo = new Socio_Model();
				$data=$_REQUEST;

				$tipo=htmlspecialchars($data["cuil"]);
				$articulo->setCuil($tipo);

				$res=$articulo->buscarHabilitado();


				if ($res == 0) {
					 echo "<script> alert('[ERROR] El socio vinculado al CUIL ingresado no esta habilitado para realizar un prestamo...');</script>";
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


						/* -------------------------------   bloque para cargar la lista de  prestamos.html -------------------------------*/
						$prestamo = new Prestamo_Model();
						$prestamo->setSocio($tipo);

						$pendiente = $prestamo->pendientes();

						$tp2= new TemplatePower("vistas/prestamo.html");
						$tp2->prepare();
						$tp2->gotoBlock("_ROOT");


					

						if ($res)
						{
								foreach ($res as $res1){  

									  $tp2->assign("cuil", $res1['cuil']);
									  $tp2->assign("nombre", $res1['nombre']);
									  $tp2->assign("apellido", $res1['apellido']);
									  $tp2->assign("sus", $res1['suspender']);
						
									$_SESSION['cuil'] = $res1['cuil']; // guardo el cuil para usarlo luego en la logica de prestamos.-
							 	}	

					    }



					    if ($pendiente)
						{
								foreach ($pendiente as $res1)
								{  

									$tp2->newblock("blockLista");

																	$titulo = $res1['libro1'];
																	$lib = new Libro_Model();
																	$lib->setIsbn($titulo);
																	$titulo2= $lib->nombre();

																	foreach ($titulo2 as $value) {
																		# code...
																		$tp2->assign("titulo", $value['titulo']);
																	}


									   	$tp2->assign("cuil", $res1['socio']);
										  $tp2->assign("prestamo", $res1['fecha_prestamo']);
										  $tp2->assign("devolucion", $res1['fecha_devolucion']);
										  $tp2->assign("libro1", $res1['libro1']);	
						
									
							 	}	

					    }else{
					    		$tp2->newblock("noResults");
					    	 }



					   return $tp2->getOutputContent();
					   /* -------------------------------   bloque para cargar la lista de  prestamos.html -------------------------------*/
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






	function consulta()
	{
		if (isset($_SESSION['usuario']))
		{
			if(isset($_POST['buscar']))
			{
				$articulo = new Libro_Model();
				$presta = new Prestamo_Model();

				$data=$_REQUEST;

				$tipo=htmlspecialchars($data["isbn"]);
				$articulo->setIsbn($tipo);
				$presta->setLibro1($tipo);

				

				$res=$articulo->disponible();

					if ($res == 0) {
									 echo "<script> alert('[ERROR] No hay UN LIBRO registrado con ese <ISBN>...');</script>";

					  				 //***************************  BLOQUE PARA RECARGAR LOS DATOS DINAMICAMENTE ***********************//
					  				 $articulo = new Socio_Model();
				

									$tipo=htmlspecialchars($_SESSION["cuil"]);
									$articulo->setCuil($tipo);

									$res=$articulo->buscarHabilitado();

											/* -------------------------------   bloque para cargar la lista de  prestamos.html -------------------------------*/
						$prestamo = new Prestamo_Model();
						$prestamo->setSocio($tipo);

						$pendiente = $prestamo->pendientes();

						$tp2= new TemplatePower("vistas/prestamo.html");
						$tp2->prepare();
						$tp2->gotoBlock("_ROOT");


					

						if ($res)
						{
								foreach ($res as $res1){  

									  $tp2->assign("cuil", $res1['cuil']);
									  $tp2->assign("nombre", $res1['nombre']);
									  $tp2->assign("apellido", $res1['apellido']);
									  $tp2->assign("sus", $res1['suspender']);
						
									$_SESSION['cuil'] = $res1['cuil']; // guardo el cuil para usarlo luego en la logica de prestamos.-
							 	}	

					    }



					    if ($pendiente)
						{
								foreach ($pendiente as $res1)
								{  

									$tp2->newblock("blockLista");

																	$titulo = $res1['libro1'];
																	$lib = new Libro_Model();
																	$lib->setIsbn($titulo);
																	$titulo2= $lib->nombre();

																	foreach ($titulo2 as $value) {
																		# code...
																		$tp2->assign("titulo", $value['titulo']);
																	}


									   	$tp2->assign("cuil", $res1['socio']);
										  $tp2->assign("prestamo", $res1['fecha_prestamo']);
										  $tp2->assign("devolucion", $res1['fecha_devolucion']);
										  $tp2->assign("libro1", $res1['libro1']);	
						
									
							 	}	

					    }else{
					    		$tp2->newblock("noResults");
					    	 }



					   return $tp2->getOutputContent();
					   /* -------------------------------   bloque para cargar la lista de  prestamos.html -------------------------------*/

									//**************************************************************************************************//

									}else{

												$stock = $articulo->stock();

												$valor=0;

												foreach ($stock as $value) {
													# code...
													$valor= $value['ejemplares'];
												}

												

												if ($valor > 1) 
												{
													# code. . .   PRESTO EL LIBRO SOLO SI HAY STOCK
												

												$tipo=htmlspecialchars($data["fecha"]);    //tengo la fecha del prestamo
												$presta->setPrestamo($tipo);

												$fec_vencimi= date("Y-m-d", strtotime("$tipo+ 7 days"));   //calculo la fecha de devolucion
												$presta->setDevolucion($fec_vencimi);

												$tipo= $_SESSION['cuil'];                  // tengo el cuil del socio que pide el prestamo
												$presta->setSocio($tipo);


												$pen = $presta->pendientes();

												$calculo = count($pen);

												if ($calculo < 3) {
													# code...

													$presta->agregar();   

													
													echo "<script> alert('[AVISO] PRESTAMO LISTO!!. ');</script>";


													$articulo->down();  //decremento en uno el stock del libro

												}else{

															echo "<script> alert('[AVISO] Se ha alcanzado el limite de 3 ejemplares por socio.- ');</script>";

													 }



												











												

												 //***************************  BLOQUE PARA RECARGAR LOS DATOS DINAMICAMENTE ***********************//
								  				 $articulo = new Socio_Model();
							

												$tipo=htmlspecialchars($_SESSION["cuil"]);
												$articulo->setCuil($tipo);

												$res=$articulo->buscarHabilitado();

														/* -------------------------------   bloque para cargar la lista de  prestamos.html -------------------------------*/
						$prestamo = new Prestamo_Model();
						$prestamo->setSocio($tipo);

						$pendiente = $prestamo->pendientes();

						$tp2= new TemplatePower("vistas/prestamo.html");
						$tp2->prepare();
						$tp2->gotoBlock("_ROOT");


					

						if ($res)
						{
								foreach ($res as $res1){  

									  $tp2->assign("cuil", $res1['cuil']);
									  $tp2->assign("nombre", $res1['nombre']);
									  $tp2->assign("apellido", $res1['apellido']);
									  $tp2->assign("sus", $res1['suspender']);
						
									$_SESSION['cuil'] = $res1['cuil']; // guardo el cuil para usarlo luego en la logica de prestamos.-
							 	}	

					    }



					    if ($pendiente)
						{
								foreach ($pendiente as $res1)
								{  

									$tp2->newblock("blockLista");
																	$titulo = $res1['libro1'];
																	$lib = new Libro_Model();
																	$lib->setIsbn($titulo);
																	$titulo2= $lib->nombre();

																	foreach ($titulo2 as $value) {
																		# code...
																		$tp2->assign("titulo", $value['titulo']);
																	}


									   	$tp2->assign("cuil", $res1['socio']);
										  $tp2->assign("prestamo", $res1['fecha_prestamo']);
										  $tp2->assign("devolucion", $res1['fecha_devolucion']);
										  $tp2->assign("libro1", $res1['libro1']);	

						
									
							 	}	

					    }else{
					    		$tp2->newblock("noResults");
					    	 }



					   return $tp2->getOutputContent();
					   /* -------------------------------   bloque para cargar la lista de  prestamos.html -------------------------------*/

												

												}else{
														echo "<script> alert('[AVISO] No hay stock disponible para prestamo de este ejemplar. ');</script>";

														//***************************  BLOQUE PARA RECARGAR LOS DATOS DINAMICAMENTE ***********************//
										  				 $articulo = new Socio_Model();
									

														$tipo=htmlspecialchars($_SESSION["cuil"]);
														$articulo->setCuil($tipo);

														$res=$articulo->buscarHabilitado();

																/* -------------------------------   bloque para cargar la lista de  prestamos.html -------------------------------*/
						$prestamo = new Prestamo_Model();
						$prestamo->setSocio($tipo);

						$pendiente = $prestamo->pendientes();

						$tp2= new TemplatePower("vistas/prestamo.html");
						$tp2->prepare();
						$tp2->gotoBlock("_ROOT");


					

						if ($res)
						{
								foreach ($res as $res1){  

									  $tp2->assign("cuil", $res1['cuil']);
									  $tp2->assign("nombre", $res1['nombre']);
									  $tp2->assign("apellido", $res1['apellido']);
									  $tp2->assign("sus", $res1['suspender']);
						
									$_SESSION['cuil'] = $res1['cuil']; // guardo el cuil para usarlo luego en la logica de prestamos.-
							 	}	

					    }



					    if ($pendiente)
						{
								foreach ($pendiente as $res1)
								{  

									$tp2->newblock("blockLista");

																	$titulo = $res1['libro1'];
																	$lib = new Libro_Model();
																	$lib->setIsbn($titulo);
																	$titulo2= $lib->nombre();

																	foreach ($titulo2 as $value) {
																		# code...
																		$tp2->assign("titulo", $value['titulo']);
																	}


									   	$tp2->assign("cuil", $res1['socio']);
										  $tp2->assign("prestamo", $res1['fecha_prestamo']);
										  $tp2->assign("devolucion", $res1['fecha_devolucion']);
										  $tp2->assign("libro1", $res1['libro1']);	
						
									
							 	}	

					    }else{
					    		$tp2->newblock("noResults");
					    	 }



					   return $tp2->getOutputContent();
					   /* -------------------------------   bloque para cargar la lista de  prestamos.html -------------------------------*/

														//**************************************************************************************************//
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
	}














	function devolucion()
	{
		if (isset($_SESSION['usuario']))
		{
			if(isset($_POST['buscar']))
			{
		
				$presta = new Prestamo_Model();
				$socio = new Socio_Model();

				$data=$_REQUEST;

				$tipo=htmlspecialchars($data["cuil"]);
				$presta->setSocio($tipo);
				$socio->setCuil($tipo);

				$pendiente = $presta->pendientes();
				$calculo = count($pendiente);

				$res=$socio->buscarTodo();
				

				if ($res == 0) {
					# code...
									echo "<script> alert('[AVISO]  No hay SOCIOS registrados con el CUIL ingresado.- ');</script>";

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

											if ($calculo == 0) {
												# code...
												echo "<script> alert('[AVISO]  No hay PRESTAMO registrado con el CUIL ingresado.- ');</script>";
											}else{

														/* -------------------------------   bloque para cargar la lista de  prestamos.html -------------------------------*/
												

														$tp2= new TemplatePower("vistas/devolucion.html");
														$tp2->prepare();
														$tp2->gotoBlock("_ROOT");


													

														if ($res)
														{
																foreach ($res as $res1){  

																	  $tp2->assign("cuil", $res1['cuil']);
																	  $tp2->assign("nombre", $res1['nombre']);
																	  $tp2->assign("apellido", $res1['apellido']);
																	  $tp2->assign("sus", $res1['suspender']);
														
																	$_SESSION['cuil'] = $res1['cuil']; // guardo el cuil para usarlo luego en la logica de prestamos.-
															 	}	

													    }



													    if ($pendiente)
														{

																foreach ($pendiente as $res1)
																{  

																	$tp2->newblock("blockLista");

																	$titulo = $res1['libro1'];
																	$lib = new Libro_Model();
																	$lib->setIsbn($titulo);
																	$titulo2= $lib->nombre();

																	foreach ($titulo2 as $value) {
																		# code...
																		$tp2->assign("titulo", $value['titulo']);
																	}


																		
																	   	$tp2->assign("cuil", $res1['socio']);
																		  $tp2->assign("prestamo", $res1['fecha_prestamo']);
																		  $tp2->assign("devolucion", $res1['fecha_devolucion']);
																		  $tp2->assign("libro1", $res1['libro1']);	



																		  $url2='index.php?action=Prestamo::eliminar&idProp=';
																														
																			$tp2->assign("eliminarProp", $url2.$res1['cod_prestamo']);
														
																	
															 	}	

													    }else{
													    		$tp2->newblock("noResults");
													    	 }



													   return $tp2->getOutputContent();
													   /* -------------------------------   bloque para cargar la lista de  prestamos.html -------------------------------*/
											
											    	}
										 }
			}
		}
	}




	function eliminar(){
		

			
		$id_propiedad=$_REQUEST['idProp'];   //discrimino el codigo del prestamo a modificar
		
		$articulo= new Prestamo_Model();
		
		$result=$articulo->retorno($id_propiedad);      //recupero la info desde la base de datos asiciada al codigo discriminado
		$articulo->setId($id_propiedad);

	
		if (isset($result)) 
		{
			# code...    hago los calculos para efectuar la devolucion del ejemplar, esto incluye actualizar stock, tabla de pedidos y control de fechas.
			
			$hoy = date('Y-m-d');  //obtengo la fecha de hoy para hacer la comparacion y determinar si el socio supero el limite de dias de prestamo
			$hoy2 =  strtotime("$hoy");

			$fecha_prestamo = 0;
			$isbn=0;
			$cuil=0;

			foreach ($result as $value) {
				# code...
				$fecha_prestamo = $value['fecha_prestamo'];   //con esto comparo las fechas
				$isbn = $value['libro1'];                     //con esto incremento el stock
				$cuil = $value['socio'];                      //con esto suspendo el socio si fuera necesario.   :)
			}

			$fecha_prestamo2 =  strtotime("$fecha_prestamo");

			$calcular = $hoy2 - $fecha_prestamo2;
		
			if ($calcular < 604801) {     //   ****C O N T R O L de fechas****, aqui se determina si la devolucion se hace mas de 7 dias despues!!:
				# code...

				echo '<script language=javascript> alert(" Ejemplar devuelto con exito. Muchas gracias!.- ") </script>';

				$articulo->regresar();   //1-   actualizo el prestamo de 'devuelto=NO' a 'devuelto=SI'


				$presta = new Prestamo_Model();
				$socio = new Socio_Model();
				$libro = new Libro_Model();

				$libro->setIsbn($isbn);
				$libro->up();           //2-  actualizamos el stock del libro y finalizamos el proceso para el caso en el cual el libro ha sido devuelto dentro del plazo.



				$data=$_REQUEST;

				$tipo=htmlspecialchars($_SESSION["cuil"]);
				$presta->setSocio($tipo);
				$socio->setCuil($tipo);

				$pendiente = $presta->pendientes();
				$calculo = count($pendiente);

				$res=$socio->buscarTodo();
				

				if ($res == 0) {
					# code...
									echo "<script> alert('[AVISO]  No hay SOCIOS registrados con el CUIL ingresado.- ');</script>";

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

											if ($calculo == 0) {
												# code...
												echo "<script> alert('[AVISO]  No hay PRESTAMO registrado con el CUIL ingresado.- ');</script>";
											}else{

														/* -------------------------------   bloque para cargar la lista de  prestamos.html -------------------------------*/
												

														$tp2= new TemplatePower("vistas/devolucion.html");
														$tp2->prepare();
														$tp2->gotoBlock("_ROOT");


													

														if ($res)
														{
																foreach ($res as $res1){  

																	  $tp2->assign("cuil", $res1['cuil']);
																	  $tp2->assign("nombre", $res1['nombre']);
																	  $tp2->assign("apellido", $res1['apellido']);
																	  $tp2->assign("sus", $res1['suspender']);
														
																	$_SESSION['cuil'] = $res1['cuil']; // guardo el cuil para usarlo luego en la logica de prestamos.-
															 	}	

													    }



													    if ($pendiente)
														{
																foreach ($pendiente as $res1)
																{  

																	$tp2->newblock("blockLista");



																	$titulo = $res1['libro1'];
																	$lib = new Libro_Model();
																	$lib->setIsbn($titulo);
																	$titulo2= $lib->nombre();

																	foreach ($titulo2 as $value) {
																		# code...
																		$tp2->assign("titulo", $value['titulo']);
																	}

																	   	$tp2->assign("cuil", $res1['socio']);
																		  $tp2->assign("prestamo", $res1['fecha_prestamo']);
																		  $tp2->assign("devolucion", $res1['fecha_devolucion']);
																		  $tp2->assign("libro1", $res1['libro1']);	



																		  $url2='index.php?action=Prestamo::eliminar&idProp=';
																														
																			$tp2->assign("eliminarProp", $url2.$res1['cod_prestamo']);
														
																	
															 	}	

													    }else{
													    		$tp2->newblock("noResults");
													    	 }



													   return $tp2->getOutputContent();
													}
										}
			}else{
					echo '<script language=javascript> alert("La devolucion del ejemplar se hizo fuera de los 7 dias acordados. Socio SUSPENDIDO.-") </script>';

					$articulo->regresar();   //1-  actualizo el prestamo de 'devuelto=NO' a 'devuelto=SI'

					$libro = new Libro_Model();

					$libro->setIsbn($isbn);
					$libro->up();           //2-  actualizamos el stock del libro  devuelto FUERA del plazo.
					

					$presta = new Prestamo_Model();
					$socio = new Socio_Model();

					$socio->setCuil($cuil);
					$socio->suspender();    // 3-  Suspender al socio por haber devuelto el libro fuera de termino.

					$data=$_REQUEST;

					$tipo=htmlspecialchars($_SESSION["cuil"]);
					$presta->setSocio($tipo);
					$socio->setCuil($tipo);

					$pendiente = $presta->pendientes();
					$calculo = count($pendiente);

					$res=$socio->buscarTodo();
					

					if ($res == 0) {
					# code...
									echo "<script> alert('[AVISO]  No hay SOCIOS registrados con el CUIL ingresado.- ');</script>";

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

											if ($calculo == 0) {
												# code...
												echo "<script> alert('[AVISO]  No hay PRESTAMO registrado con el CUIL ingresado.- ');</script>";
											}else{

														/* -------------------------------   bloque para cargar la lista de  prestamos.html -------------------------------*/
												

														$tp2= new TemplatePower("vistas/devolucion.html");
														$tp2->prepare();
														$tp2->gotoBlock("_ROOT");


													

														if ($res)
														{
																foreach ($res as $res1){  

																	  $tp2->assign("cuil", $res1['cuil']);
																	  $tp2->assign("nombre", $res1['nombre']);
																	  $tp2->assign("apellido", $res1['apellido']);
																	  $tp2->assign("sus", $res1['suspender']);
														
																	$_SESSION['cuil'] = $res1['cuil']; // guardo el cuil para usarlo luego en la logica de prestamos.-
															 	}	

													    }



													    if ($pendiente)
														{
																foreach ($pendiente as $res1)
																{  

																	$tp2->newblock("blockLista");

																	$titulo = $res1['libro1'];
																	$lib = new Libro_Model();
																	$lib->setIsbn($titulo);
																	$titulo2= $lib->nombre();

																	foreach ($titulo2 as $value) {
																		# code...
																		$tp2->assign("titulo", $value['titulo']);
																	}


																	   	$tp2->assign("cuil", $res1['socio']);
																		  $tp2->assign("prestamo", $res1['fecha_prestamo']);
																		  $tp2->assign("devolucion", $res1['fecha_devolucion']);
																		  $tp2->assign("libro1", $res1['libro1']);	



																		  $url2='index.php?action=Prestamo::eliminar&idProp=';
																														
																			$tp2->assign("eliminarProp", $url2.$res1['cod_prestamo']);
														
																	
															 	}	

													    }else{
													    		$tp2->newblock("noResults");
													    	 }



													   return $tp2->getOutputContent();
													}
										}


				 }


			

}
	


	}




	function listadopendientes()
	{
		$presta = new Prestamo_Model();
		$res=$presta->prestados();


			$tp2= new TemplatePower("vistas/listado-prestamos.html");
														$tp2->prepare();
														$tp2->gotoBlock("_ROOT");


													

														



													    if ($res)
														{
																foreach ($res as $res1)
																{  

																	$tp2->newblock("blockLista");



																	$titulo = $res1['libro1'];
																	$lib = new Libro_Model();
																	$lib->setIsbn($titulo);
																	$titulo2= $lib->nombre();

																	foreach ($titulo2 as $value) {
																		# code...
																		$tp2->assign("titulo", $value['titulo']);
																	}

																	   	$tp2->assign("cuil", $res1['socio']);
																		  $tp2->assign("prestamo", $res1['fecha_prestamo']);
																		  $tp2->assign("devolucion", $res1['fecha_devolucion']);
																		  $tp2->assign("libro1", $res1['libro1']);	



																		  $url2='index.php?action=Prestamo::eliminar&idProp=';
																														
																			$tp2->assign("eliminarProp", $url2.$res1['cod_prestamo']);
														
																	
															 	}	

													    }else{
													    		$tp2->newblock("noResults");
													    	 }



													   return $tp2->getOutputContent();
	}





}

?>