<?php

    class FavoritesController extends RestController
    {
    
        public function getAll(){
            $Favorites = new favorites();
            $data=[];
            $data=$Favorites->find();
            if(count($data)===0){
                foreach($Favorites->get_alias() as $index => $value){
                      $data[0][$index]="";  
                }
            }
            $this->data = $data;
        }

        public function post(){
            extract($this->param());
            $favorites = (new Favorites);
            $favorites->Producto_id = filter_var($productoId,FILTER_SANITIZE_NUMBER_INT); 
            $favorites->Cliente_id = Auth::get("Id"); 
            $this->data = $favorites->save();
            return $this->data;
        }

        
        public function delete($id){
            $this->data=(new Favorites)->delete("Id = $id");
            return $this->data;
        }

    } 





?>