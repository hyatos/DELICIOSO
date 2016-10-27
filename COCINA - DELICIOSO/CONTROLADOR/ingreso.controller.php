<?php
class Ingreso_Controller{

	function main(){
		$tpl = new TemplatePower("vistas/logueo.html");
		$tpl->prepare();				
		$tpl->gotoBlock("_ROOT");

		
		return $tpl->getOutputContent();	
	}
}
?>