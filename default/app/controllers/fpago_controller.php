<?php

    class FpagoController extends RestController
    {
    
        public function getAll(){
            $Fpagos = new Fpago();
            $this->data=$Fpagos->find();
        }

        public function post(){
            $inputs = $this->param();
            $Fpagos = new Fpago();
            $Fpagos->Forma = $inputs["Forma"];
            if($Fpagos->save()){
                $this->data = $Fpagos->find();
            }else{
                $this->data = $this->error("No se pudo insertar el registro", 500);
                return false;
            }
        }
        public function delete($id){
            $Fpagos = new Fpago();
            $Fpagos->delete("Id=$id");
        }
    } 





?>