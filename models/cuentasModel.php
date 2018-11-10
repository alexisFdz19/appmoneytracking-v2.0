<?php

class cuentasModel extends AppModel{

    private static $nombre = "cuentas";
  
    public function getAcounts(){

        $cuentas = $this->_db->query("SELECT * FROM accounts");
        return $cuentas->fetchAll();
  
    }

    public function guardar($dato){

        $consulta = $this->_db->prepare("INSERT INTO accounts (name) VALUES (:name)");
        $consulta->bindParam(":name", $dato["name"]);
        
        if ($consulta->execute()){
            
            return true;
        
        }else{
            
            return false;
        
        }
        
    }

    public function buscarPorId($id){

        $cuentas = $this->_db->prepare("SELECT * FROM accounts WHERE id=:id");

        $cuentas->bindParam(":id", $id);
        $cuentas->execute();
        $registro = $cuentas->fetch();
        
        if ($registro){
            
            return $registro;
        
        }else{
            
            return false;
        
        }
    }

    public function actualizar($dato){

        $consulta = $this->_db->prepare("UPDATE accounts SET name=:name WHERE id=:id");

        $consulta->bindParam(":id", $dato["id"]);
        $consulta->bindParam(":name", $dato["name"]);

        if ($consulta->execute()){

            return true;

        }else{

            return false;

        }

    }

    public function eliminarPorId($id){

        $consulta = $this->_db->prepare("DELETE FROM accounts WHERE id=:id");
        $consulta->bindParam(":id", $id);

        if ($consulta->execute()){

            return true;

        }else{

            return false;

        }
        
    }

}