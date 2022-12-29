<?php

    class RubrosController extends RestController
    {
       
        public function getAll(){
            $Rubros = new Rubros();
            $data=[];
            $data=$Rubros->find("order: Id DESC");
            $this->data = $data;
        }
        private function searchParent($needle,&$haystack,$items){
            if(is_array($haystack)){
                $exist = array_search($needle,array_column($haystack,'id'));
                
                if($exist!==FALSE){
                    array_push($haystack[$exist]['children'],$items);
                    return TRUE;
                }else{
                    for($i=0;$i<count($haystack);$i++){
                        if(is_array($haystack[$i]['children'])){
                            self::searchParent($needle,$haystack[$i]['children'],$items);
                        }
                    }
                }
            }
            return FALSE;
             
        }
        public function get_countRubros(){
            $this->data=count($this->genList());
        }
        private function genList($whereList=NULL){
            $Rubros = new Rubros();
            $Productos = new Productos();
            $data=[];
            $level =[];
            if(isset($whereList)){
                if(intval($Rubros->count("conditions: $whereList"))===0)return $data;
                foreach ($Rubros->find("conditions: $whereList","order: Parent") as $rubro) {
                    $items=[];  
                    $items["id"] = $rubro->Id;  
                    $items["label"] = $rubro->Nom;  
                    $items["children"] = [];
                    
                    array_push($data,$items);
                }
                return $data;
            }
            if(intval($Rubros->count("conditions: Parent IS NULL"))===0)return $data;
            foreach ($Rubros->find("conditions: Parent IS NULL","order: Parent") as $rubro) {
                $items=[];  
                $items["id"] = $rubro->Id;  
                $items["label"] = $rubro->Nom;  
                $items["children"] = [];
                
                array_push($data,$items);
            }
            $inserted=[];
            $notinserted=[];
            $ix=0;
            $where = "Parent IS NOT NULL";
            if(intval($Rubros->count("conditions: $where"))===0)return $data;
            do {
                $rubros=$Rubros->find("conditions: $where","order: Id");
                $items=[];  
                $items["id"] = $rubros[$ix]->Id;  
                $items["label"] = $rubros[$ix]->Nom;  
                $items["children"] = [];
                if(!in_array($rubros[$ix]->Id,$inserted)){
                    
                    $exist = $this->searchParent($rubros[$ix]->Parent,$data,$items);
                    if($exist!==FALSE){
                        array_push($inserted,$rubros[$ix]->Id);
                        
                    }
                }
           
           
            $ix++;
            }while($Rubros->count("conditions: Parent IS NOT NULL","order: Parent")>$ix);
           
          
            return $whereList;
        }
        public function get_list($whereList=NULL){
            $where = (isset($whereList))?implode(" OR ",explode(",",$whereList)):NULL;
            
            $this->data = $this->genList($where);
        }
        
        public function post(){
            $input = $this->param();
            $Rubros = new Rubros();
            $Rubros->Nom = Filter::get($input['Nom'],'htmlspecialchars', array('charset' => 'UTF-8'));
            $Rubros->Parent = Filter::get($input['Parent'],'htmlspecialchars', array('charset' => 'UTF-8'));
            $Rubros->Rastro = Filter::get($input['Rastro'],'htmlspecialchars', array('charset' => 'UTF-8'));
            if($Rubros->save()){
                $this->data = array("rubros"=>$Rubros->find(),"rubroslist"=>$this->genList());
            }else{
                $this->data = $this->error("Error: Registro no se pudo realizar", 500);
                return false;
            }

        }

        public function put($id){

            $input = $this->param();
            $Rubros = new Rubros();
            $rubro = $Rubros->find_first("conditions: Id=$id");
            $rubro->Nom = Filter::get($input['Nom'],'htmlspecialchars', array('charset' => 'UTF-8'));
            if($rubro->update()){
                $this->data = $Rubros->find("order: Nom");
            }else{
                $this->data = $this->error("Error: Registro no se pudo realizar", 500);
                return false;
            }
        }
        
        public function delete($id){
            $Rubros = new Rubros();
            $rubro = $Rubros->find_first("conditions: Id=$id");
            if(intval($Rubros->count("conditions: Parent=$id"))>0){
            $Rubros->sql("UPDATE rubros SET Parent = NULL WHERE Parent=$id");
            }
            if($rubro->delete()){
                $this->data = array("rubros"=>$Rubros->find(),"rubroslist"=>$this->genList());
            }else{
                $this->data = $this->error("Error: Registro no se pudo realizar", 500);
                return false;

            }
        }
        

  
    } 






?>