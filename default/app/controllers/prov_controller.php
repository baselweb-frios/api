<?php

    class ProvController extends RestController
    {
    
        public function getAll(){

            $Prov = new Prov();
            $data=[];
            $data= $Prov->find("order: Nom");
            $this->data = $data;
            
        }

        public function post(){

            $input = $this->param();
            $Prov = new Prov();
            
            $Prov->Nom =  Filter::get($input['Nom'],'htmlspecialchars', array('charset' => 'UTF-8'));
            $Prov->Tel =  Filter::get($input['Tel'],'htmlspecialchars');
            $Prov->Dir =  Filter::get($input['Dir'],'htmlspecialchars', array('charset' => 'UTF-8'));
            $Prov->Mail =  Filter::get($input['Mail'],'htmlspecialchars', array('charset' => 'UTF-8'));
            
            
            if($Prov->save()){
                $this->data = $Prov->find("order: Nom");
            }else{
                $this->data = $this->error("No se pudo insertar el registro", 500);
                return false;
            }

        }

        public function put($id){
            $input = $this->param();
            $Prov = new Prov();
            $provedor = $Prov->find_first("conditions: Id=$id");
            $provedor->Nom =  Filter::get($input['Nom'],'htmlspecialchars', array('charset' => 'UTF-8'));
            $provedor->Tel =  Filter::get($input['Tel'],'htmlspecialchars', array('charset' => 'UTF-8'));
            $provedor->Dir =  Filter::get($input['Dir'],'htmlspecialchars', array('charset' => 'UTF-8'));
            $provedor->Mail =  Filter::get($input['Mail'],'htmlspecialchars', array('charset' => 'UTF-8'));
            if($provedor->update()){
                $this->data = $provedor->find("order: Nom");
            }else{
                $this->data = $this->error("No se pudo insertar el registro", 500);
                return false;
            }
        }
        
        public function delete($id){
            $provedor = new Prov();
            if($provedor->delete("Id=$id")){
                $this->data = $provedor->find("order: Nom");
            }else{
                $this->data = $this->error("No se pudo insertar el registro", 500);
                return false;
            }
            
        }

    } 





?>