<?php

class categoriasModel extends AppModel{

	private static $nombre = "categorias";

  	public function getCategories(){

    	$categorias = $this->_db->query("SELECT * FROM categories");
    	return $categorias->fetchall();
	  
	}

	public function guardar($dato){

    	$consulta = $this->_db->prepare("INSERT INTO categories (name) VALUES (:name)");
        $consulta->bindParam(":name", $dato["name"]);
		
		if ($consulta->execute()){
			
			return true;
		
		}else{
			
			return false;
		
		}

	}
	  
	public function buscarPorId($id){

		$categorias = $this->_db->prepare("SELECT * FROM categories WHERE id=:id");
		
        $categorias->bindParam(":id", $id);
        $categorias->execute();
        $registro = $categorias->fetch();
		
		if ($registro){
			
			return $registro;
		
		}else{
			
			return false;
		
		}

	}
	
	public function actualizar($dato){

		$consulta = $this->_db->prepare("UPDATE categories SET name=:name WHERE id=:id");
		
        $consulta->bindParam(":id", $dato["id"]);
		$consulta->bindParam(":name", $dato["name"]);
		
        if ($consulta->execute()){

			return true;
			
        }else{

            return false;
		}
		
	}
	
	public function eliminarPorId($id){

        $consulta = $this->_db->prepare("DELETE FROM categories WHERE id=:id");
		$consulta->bindParam(":id", $id);
		
        if ($consulta->execute()){

			return true;
			
        }else{

			return false;
			
		}
		
    }

}