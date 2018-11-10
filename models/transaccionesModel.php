<?php

class transaccionesModel extends AppModel{
	
	public function __construct(){

		parent::__construct();
	
	}

	public function getTransactions(){

        $transacciones = $this->_db->query("SELECT t.id,a.name,c.name,description,date,amount 
                                            FROM transactions t INNER JOIN categories c ON t.category_id=c.id INNER JOIN accounts a ON t.account_id=a.id ");
		
		foreach (range(0,$transacciones->columnCount()-1) as $column_index){

            $meta[] = $transacciones->getColumnMeta($column_index);
			
		}

		$resutados = $transacciones->fetchAll(PDO::FETCH_NUM);
		
        for ($i=0; $i < count($resutados); $i++){
            $j = 0;
            //$x = 0;
            foreach ($meta as $value){

                $rows[$i][$value["table"]][$value["name"]] = $resutados[$i][$j];
                $j++;
                //$x++;
            }
		}
		
        return $rows;
    }

	public function guardar($datos = array()){

        $consulta = $this->_db->prepare(

            "INSERT INTO transactions (account_id, category_id, description, date, amount) 
            VALUES (:account_id, :category_id, :description, :date, :amount)"
		
		);
		
        $consulta->bindParam(":account_id", $datos["account_id"]);
        $consulta->bindParam(":category_id", $datos["category_id"]);
        $consulta->bindParam(":description", $datos["description"]);
        $consulta->bindParam(":date", $datos["date"]);
		$consulta->bindParam(":amount", $datos["amount"]);
		
        if ($consulta->execute()){
			
			return true;

        }else{
			
			return false;
		
		}

	}
	
	public function buscarPorId($id){

        $transaccion = $this->_db->prepare(
            "SELECT t.id,a.name,t.account_id,c.name,t.category_id,description,date,amount 
        	FROM transactions t INNER JOIN categories c ON t.category_id=c.id INNER JOIN accounts a ON t.account_id=a.id WHERE t.id=:id"
		);
		
        $transaccion->bindParam(":id", $id);
        $transaccion->execute();
        $registro = $transaccion->fetch();
		
		if ($registro){
			
			return $registro;
			
        }else{

            return false;
		
		}
		
	}
	
	public function actualizar($datos = array()){

        $consulta = $this->_db->prepare(

            "UPDATE transactions SET
			account_id=:account_id, 
			category_id=:category_id, 
			description=:description, 
			date=:date, 
			amount=:amount
			WHERE id=:id"

		);
		
        $consulta->bindParam(":id", $datos["id"]);
        $consulta->bindParam(":account_id", $datos["account_id"]);
        $consulta->bindParam(":category_id", $datos["category_id"]);
        $consulta->bindParam(":description", $datos["description"]);
        $consulta->bindParam(":date", $datos["date"]);
		$consulta->bindParam(":amount", $datos["amount"]);
		
        if ($consulta->execute()){
			
			return true;
		
		}else{
			
			return false;
		
		}
	
	}

	public function eliminarPorId($id){

        $consulta = $this->_db->prepare("DELETE FROM transactions WHERE id=:id");
        $consulta->bindParam(":id", $id);
		
		if ($consulta->execute()){
			
			return true;
		
		}else{
			
			return false;
		
		}
		
    }

}
