<?php

    class ProductosController extends RestController
    {
    
        
        public function getAll(){
            return $this->data;    
        }
    public function get_mostrar(){
        $this->data = (new Productos)->getAll();
        return $this->data;
    }
    public function post(){
            extract($this->param());
            $Productos = new Productos();


            $Productos->Marca = filter_var($marca);
            $Productos->Rubros_id = filter_var($rubrosId,FILTER_SANITIZE_NUMBER_INT);
            $Productos->Codebar = (isset($codebar))?filter_var($codebar):uniqid();
            $Productos->Nom = filter_var($nom);
            $Productos->Detalle = filter_var($detalle);
            $Productos->Costo = filter_var($costo,FILTER_SANITIZE_NUMBER_INT);
            $Productos->Final = filter_var($final,FILTER_SANITIZE_NUMBER_INT);
            $Productos->Sale = filter_var($sale,FILTER_SANITIZE_NUMBER_INT);
            $Productos->SrcImages = filter_var($srcImages);
            $Productos->Clave_search = (isset($claveSearch))?filter_var($claveSearch):"";
            $Productos->Destacado = (isset($destacado))?filter_var($destacado,FILTER_SANITIZE_NUMBER_INT):0;
            
            if($Productos->save()){
                $this->data=$this->get_mostrar();
            }else{
                $this->error("No se pudo insertar el registro", 500);
                return false;
            }
        }

        
        public function put($id){
            extract($this->param());
            $Productos = (new Productos)->find_first("conditions: Id=$id");
            $Productos->Marca = filter_var($marca);
            $Productos->Rubros_id = filter_var($rubrosId,FILTER_SANITIZE_NUMBER_INT);
            $Productos->Codebar = (isset($codebar))?filter_var($codebar):uniqid();
            $Productos->Nom = filter_var($nom);
            $Productos->Detalle = filter_var($detalle);
            $Productos->Costo = filter_var($costo,FILTER_SANITIZE_NUMBER_INT);
            $Productos->Final = filter_var($final,FILTER_SANITIZE_NUMBER_INT);
            $Productos->Sale = filter_var($sale,FILTER_SANITIZE_NUMBER_INT);
            $Productos->SrcImages = filter_var($srcImages);
            $Productos->Clave_search = (isset($claveSearch))?filter_var($claveSearch):"";
            $Productos->Destacado = (isset($destacado))?filter_var($destacado,FILTER_SANITIZE_NUMBER_INT):0;
            if($Productos->update()){
                $this->data = $Productos;
            }else{
                $this->data = $this->error("No se pudo insertar el registro", 500);
                return false;
            }

        }
        
        public function delete($id){

            $Productos = new Productos();
            $producto = $Productos->find_first("conditions: Id=$id");
            
            if($producto->delete("Id=$id")){
                $this->data=$this->get_mostrar();
            }else{
                $this->data = $this->error("No se pudo insertar el registro", 500);
                return false;
            }
            

        }

    } 




?>