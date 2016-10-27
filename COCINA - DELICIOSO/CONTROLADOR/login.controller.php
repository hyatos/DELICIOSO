<?php
class Login_Controller{

	function validar_Sesion()
	{
		

		if(isset($_POST['ingresar']))
		{
			if($_POST['usuario']=="" || $_POST['password']=="")
			{
				echo "<script> alert('Debe ingresar usuario y contrasenia VALIDOS.');</script>";

				$tp2 = new TemplatePower("vistas/logueo.html");
											$tp2->prepare();
											$tp2->gotoBlock("_ROOT");

											return $tp2->getOutputContent();

			}else
				{ //si no esta vacio el Post, continuo...






								$mailUsuario=$_POST['usuario'];
								$passUsuario=$_POST['password'];

								 
								$usuario = new Usuario_Model();
								
								$res = $usuario->obtener_Usuario($mailUsuario, $passUsuario);

			        if ($res == 0) {
									# code...
											$tp2 = new TemplatePower("vistas/logueo.html");
											$tp2->prepare();
											$tp2->gotoBlock("_ROOT");

											
											 echo "<script> alert('Usuario o Contrasenia no validos, usuario no encontrado.');</script>";
												

											return $tp2->getOutputContent();
								}else{ //tengo que verificar que sean iguales los post con los datos EN la base de datos
										foreach ($res as $valor) {
											# code...
											$_SESSION['nombre'] = $valor['id_usuario'];
											

											if ($_SESSION['nombre'] == null) {
												# code...
													$tp2 = new TemplatePower("vistas/logueo.html");
												   	$tp2->prepare();
													$tp2->gotoBlock("_ROOT");

													
													 echo "<script> alert('Usuario y Contraseña no validos, usuario no encontrado.');</script>";
														

													return $tp2->getOutputContent();
											}else{

															$_SESSION['usuario'] = $mailUsuario;
										
										 
															$tp2 = new TemplatePower("vistas/welcome.html");
															$tp2->prepare();
															$tp2->gotoBlock("_ROOT");
												


											//----------------------------------------------------------------------//
											//----------------------------- T O K E N  -----------------------------//
													//$token = 0;//md5(uniqid(rand(), TRUE)); 
													$token = md5(rand());
											   		$_SESSION['token'] = $token;
											 	    $_SESSION['token_nacimiento'] = time();
											//----------------------------------------------------------------------//
											//----------------------------------------------------------------------//




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


							
 							
 				}//si no esta vacio el Post, continuo...
		}//si existe el post

	}//fin de la funcion



	





	function cerrar()
	{
		session_destroy();

		$tp2 = new TemplatePower("vistas/logueo.html");
											$tp2->prepare();
											$tp2->gotoBlock("_ROOT");

											return $tp2->getOutputContent();

	}


	function atras()
	{
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



	function olvide()
	{
			$tp2 = new TemplatePower("vistas/olvide.html");
											$tp2->prepare();
											$tp2->gotoBlock("_ROOT");

											return $tp2->getOutputContent();

	}






}
?>