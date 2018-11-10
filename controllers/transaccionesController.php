<?php

class transaccionesController extends AppController{

	
	public function __construct(){

		parent::__construct();

		$this->_view = new View(new Request);
		$this->_messages = new \Plasticbrain\flashMessages\flashMessages();

	}

	public function index(){

		$transacciones = $this->loadmodel("transacciones");
		$this->_view->transacciones = $transacciones->getTransactions();
		
		$this->_view->titulo = "Listado de transacciones";
		$this->_view->renderizar("index");
	
	}

	public function agregar(){

		if ($_POST){

			$transacciones = $this->loadModel("transacciones");

			if ($transacciones->guardar($_POST)){

				$this->_messages->success(
					
					'Transacción guardada con éxito', 
					$this->redirect(array("controller"=>"transacciones"))

				);
			}

		}

		$cuentas = $this->loadModel("cuentas");
		$this->_view->cuentas = $cuentas->getAcounts();

		$categorias = $this->loadModel("categorias");
		$this->_view->categorias = $categorias->getCategories();

		$this->_view->titulo = "Agregar transacción";
		$this->_view->renderizar("agregar");

	}
	
	public function editar($id=null){

        if ($_POST){

			$transaccion = $this->loadModel("transacciones");
			
            if ($transaccion->actualizar($_POST)){

				$this->_messages->success('Transacción editada correctamente', 
				$this->redirect(array("controller"=>"transacciones")));
			
			}else{

                $this->_view->flashMessage = "Error al editar la transacción";
                $url = $this->redirect(array("controller"=>"transacciones", "action"=>"editar/".$id));
				header("LOCATION:".$url);
				
			}
			
		}
		
        $transaccion = $this->loadModel("transacciones");
		$this->_view->transacciones = $transaccion->buscarPorId($id);
		
        $cuentas = $this->loadModel("cuentas");
		$this->_view->cuentas = $cuentas->getAcounts();
		
        $categorias = $this->loadModel("categorias");
		$this->_view->categorias = $categorias->getCategories();
		
        $this->_view->titulo = "Editar transaccion";
		$this->_view->renderizar("editar");
		
	}
	
	public function eliminar($id){

        $transaccion = $this->loadModel("transacciones");
		$registro = $transaccion->buscarPorId($id);
		
        if (!empty($registro)){
			
			$transaccion->eliminarPorId($id);
			$this->_messages->success('Transacción eliminada con éxito', 
			$this->redirect(array("controller"=>"transacciones")));
		
		}
	
	}

}
