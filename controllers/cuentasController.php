<?php

class cuentasController extends AppController{

	public function __construct(){
		
		parent::__construct();

		$this->_view = new View(new Request);
		$this->_messages = new \Plasticbrain\flashMessages\flashMessages();
		
	}

	public function index(){

		$cuentas = $this->loadModel("cuentas");
		$this->_view->cuentas = $cuentas->getAcounts();
		
		$this->_view->titulo = "Listado de cuentas";
		$this->_view->renderizar("index");

	}

	public function agregar(){

		if ($_POST){
			
			$cuentas = $this->loadModel("cuentas");

			if ($cuentas->guardar($_POST)){

				$this->_messages->success('Cuenta guardada con éxito', 
				$this->redirect(array("controller"=>"cuentas"))
				
			);
			
			}
		
		}
		
		$this->_view->titulo = "Agregar cuenta";
		$this->_view->renderizar("agregar");

	}

	public function editar($id=null){

        if ($_POST){

			$cuentas = $this->loadModel("cuentas");
			
            if ($cuentas->actualizar($_POST)){

				$this->_messages->success('Cuenta editada con éxito', 
				$this->redirect(array("controller"=>"cuentas")));
			
			}else{

                $this->_view->flashMessage = "Error al editar la cuenta...";
                $url = $this->redirect(array("controller"=>"cuentas", "action"=>"editar/".$id));
				header("LOCATION:".$url);
				
			}
			
		}
		
        $cuentas = $this->loadModel("cuentas");
		$this->_view->cuentas = $cuentas->buscarPorId($id);
		
        $this->_view->titulo = "Editar cuenta";
		$this->_view->renderizar("editar");
		
	}
	
	public function eliminar($id){

        $cuentas = $this->loadModel("cuentas");
		$registro = $cuentas->buscarPorId($id);
		
        if (!empty($registro)){

            $cuentas->eliminarPorId($id);
			$this->_messages->success('Cuenta eliminada con éxito', 
			$this->redirect(array("controller"=>"cuentas")));

		}
		
    }

}