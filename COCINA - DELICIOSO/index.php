<?php

//===========================================================================================================
// OPEN SESSION |
//---------------
	session_start();

	



//===========================================================================================================
// INCLUDES |
//-----------

include("inc.includes.php");

//===========================================================================================================
// OPEN CONNECTION |
//------------------

if ($config["dbEngine"]=="MYSQL"){
	$db = new MySQL($config["dbhost"],$config["dbuser"],$config["dbpass"],$config["db"]);
}

//===========================================================================================================
// INSTANCIA CLASES Y METODOS |
//-----------------------------

	if ((!isset($_REQUEST["action"])) || ($_REQUEST["action"]=="")) $_REQUEST["action"]="Ingreso::main";
	if ($_REQUEST["action"]=="") $html="";
	else{
		if (!strpos($_REQUEST["action"],"::")) $_REQUEST["action"].="::main";
		list($classParam,$method) = explode('::',$_REQUEST["action"]);
		if ($method=="") $method="main";
		$classToInstaciate = $classParam."_Controller";
		if (class_exists($classToInstaciate)){
			if (method_exists($classToInstaciate,$method)) {
				$claseTemp=new $classToInstaciate;
				$html=call_user_func_array(array($claseTemp, $method),array());
			}
			else{
				echo "<script type='text/javascript'> alert('Ups!: Debes loguearte primero para realizar esta accion!.'); </script>";
				#echo "ERROR";
				$html="";
				#$claseTemp2="Usuario_Controller";
				#$method2="logueo" ;
				#$html=call_user_func_array(array($claseTemp2, $method2),array();
			}
		}
		else{
			$html="La p�gina solicitada no est� disponible. [index.php] ";
		}
	}
	
//===========================================================================================================
// INSTANCIA TEMPLATE |
//---------------------

	$tpl = new TemplatePower("vistas/inicio.html" );
	$tpl->prepare();
	
//===========================================================================================================
// LEVANTA TEMPLATE	|
//-------------------		

	$tpl->gotoBlock("_ROOT");


	$tpl->assign("contenido",$html);
	$webapp=$tpl->getOutputContent();
	echo $webapp;

?>