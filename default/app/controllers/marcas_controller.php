<?php

    class MarcasController extends RestController
    {
       
        public function getAll(){
            $Marcas = new Marcas();
            $data=[];
            $this->data = $Marcas->find("order: Nom");
        }
        
        public function post(){
            $input = $this->param();
            $Marcas = new Marcas();
            $Marcas->Nom = Filter::get($input['Nom'],'htmlspecialchars', array('charset' => 'UTF-8'));
            if($Marcas->save()){
                $this->data = $Marcas->find();
            }else{
                $this->data = $this->error("Error: Registro no se pudo realizar", 500);
                return false;
            }

        }

        public function put($id){

            $input = $this->param();
            $Marcas = new Marcas();
            $marca = $Marcas->find_first("conditions: Id=$id");
            $marca->Nom = Filter::get($input['Nom'],'htmlspecialchars', array('charset' => 'UTF-8'));
            if($marca->update()){
                $this->data = $Marcas->find("order: Nom");
            }else{
                $this->data = $this->error("Error: Registro no se pudo realizar", 500);
                return false;
            }
        }
        
        public function delete($id){
            $Marcas = new Marcas();
            
            if($Marcas->delete("Id=$id")){
                $this->data = $Marcas->find("order: Nom");
            }else{
                $this->data = $this->error("Error: Registro no se pudo realizar", 500);
                return false;
            }
        }
        

  
    } 






?>