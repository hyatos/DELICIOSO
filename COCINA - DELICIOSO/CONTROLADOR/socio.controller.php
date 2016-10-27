<?php
class Socio_Controller{

	function nuevo()
	{
		if (!isset($_SESSION['usuario']))
		{ 
			$tpl = new TemplatePower("vistas/logueo.html");
			$tpl->prepare();
			$tpl->gotoBlock("_ROOT");	

			return $tpl->getOutputContent();
		}else{




						$articulo = new Socio_Model();
						$data=$_REQUEST;



						$tipo=htmlspecialchars($data["nombre"]);
						$articulo->setNombre($tipo);

						$tipo=htmlspecialchars($data["apellido"]);
						$articulo->setApellido($tipo);

						$tipo=htmlspecialchars($data["cuil"]);
						$articulo->setCuil($tipo);

						$tipo=htmlspecialchars($data["fecha"]);
						$articulo->setFecha($tipo);

						$tipo=htmlspecialchars($data["mail"]);
						$articulo->setMail($tipo);

						$tipo=htmlspecialchars($data["fijo"]);
						$articulo->setFijo($tipo);

						$tipo=htmlspecialchars($data["movil"]);
						$articulo->setMovil($tipo);

						
						$res=$articulo->buscar();

						if($res==1)
						{
							 echo "<script> alert('[ERROR] Ya existe un socio registrado con ese <cuil>!.');</script>";

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

								 echo "<script> alert('...NUEVO Socio agregado con exito!. Redireccionando...');</script>";

								#Socio  agregado !, redirecciono. 

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
																								$tp2->assign("sociosBaja", $y);;
							




								return $tp2->getOutputContent();
					         }
			}
	}

	
	function contar()
	{

									//-------------------------------------------------------//
								$articulo = new Socio_Model();
								$valor = $articulo->obtener_listado();         // cuento los elementos de cada tabla de la BD.

								$x=count($valor);
								//----------------------------------------------------------//		
					

								$tp2->assign("sociosTotal", $x);
							
	} #revisar este metodo


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

				$res=$articulo->buscarTodo();


				if ($res == 0) {
					 echo "<script> alert('[ERROR] No hay UN socio registrado con ese <cuil>...');</script>";
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

						$tp2= new TemplatePower("vistas/actualizar.html");
						$tp2->prepare();
						$tp2->gotoBlock("_ROOT");


					

						if ($res)
						{
								foreach ($res as $res1){  

									  $tp2->assign("nombre", $res1['nombre']);
									  $tp2->assign("apellido", $res1['apellido']);
									  $tp2->assign("cuil", $res1['cuil']);
									  $tp2->assign("fecha", $res1['fecha_nac']);	
									  $tp2->assign("mail", $res1['mail']);
									  $tp2->assign("fijo", $res1['tel_fijo']);
									  $tp2->assign("movil", $res1['movil']);
								
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




						$articulo = new Socio_Model();
						$data=$_REQUEST;



						$tipo=htmlspecialchars($data["nombre"]);
						$articulo->setNombre($tipo);

						$tipo=htmlspecialchars($data["apellido"]);
						$articulo->setApellido($tipo);

						$tipo=htmlspecialchars($data["cuil"]);
						$articulo->setCuil($tipo);

						$tipo=htmlspecialchars($data["fecha"]);
						$articulo->setFecha($tipo);

						$tipo=htmlspecialchars($data["mail"]);
						$articulo->setMail($tipo);

						$tipo=htmlspecialchars($data["fijo"]);
						$articulo->setFijo($tipo);

						$tipo=htmlspecialchars($data["movil"]);
						$articulo->setMovil($tipo);

						
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




	function suspender()
	{
		if (!isset($_SESSION['usuario']))
		{ 
			$tpl = new TemplatePower("vistas/logueo.html");
			$tpl->prepare();
			$tpl->gotoBlock("_ROOT");	

			return $tpl->getOutputContent();
		}else{
				if(isset($_POST['buscar']))
				{
				$articulo = new Socio_Model();
				$data=$_REQUEST;

				$tipo=htmlspecialchars($data["cuil"]);
				$articulo->setCuil($tipo);

				$res=$articulo->buscarTodo();


				if ($res == 0) {
					 echo "<script> alert('[ERROR] No hay UN socio registrado con ese <cuil>...');</script>";
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
										foreach ($res as $valor) {
											if ($valor['suspender'] == 'NO') {
												# code...
												//suspendo al socio

												$articulo->suspender();

												echo "<script> alert('[AVISO] El socio ha sido suspendido. Queda inhabilitado para realizar prestamos...');</script>";
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
													// habilito al socio
													$articulo->noSuspender();

												echo "<script> alert('[AVISO] El socio ha sido habilitado con exito!...');</script>";
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
	}










	function listar()
	{
		$tp2 = new TemplatePower("vistas/listado-socios.html");
		$tp2->prepare();
		$tp2->gotoBlock("_ROOT");

				$articulo = new Socio_Model();

				$res=$articulo->obtener_listado();




						if ($res)
						{
								foreach ($res as $res1){  

									$tp2->newblock("blockLista");

									  $tp2->assign("nombre", $res1['nombre']);
									  $tp2->assign("apellido", $res1['apellido']);
									  $tp2->assign("cuil", $res1['cuil']);
									  $tp2->assign("nacimiento", $res1['fecha_nac']);	
									  $tp2->assign("mail", $res1['mail']);
									  $tp2->assign("telefono", $res1['tel_fijo']);
									  $tp2->assign("movil", $res1['movil']);
								
							 	}	

					    }


		return $tp2->getOutputContent();
	}



	function listar2()
	{
		$tp2 = new TemplatePower("vistas/listado-socios.html");
		$tp2->prepare();
		$tp2->gotoBlock("_ROOT");

				$articulo = new Socio_Model();

				$res=$articulo->buscarNoHabilitado();




						if ($res)
						{
								foreach ($res as $res1){  

									$tp2->newblock("blockLista");

									  $tp2->assign("nombre", $res1['nombre']);
									  $tp2->assign("apellido", $res1['apellido']);
									  $tp2->assign("cuil", $res1['cuil']);
									  $tp2->assign("nacimiento", $res1['fecha_nac']);	
									  $tp2->assign("mail", $res1['mail']);
									  $tp2->assign("telefono", $res1['tel_fijo']);
									  $tp2->assign("movil", $res1['movil']);
								
							 	}	

					    }


		return $tp2->getOutputContent();
	}




	

}
?>