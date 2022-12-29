<?php

    class CartController extends RestController
    {
    
        public function getAll(){
            $this->data=Session::get("cart".Input::ip());
        }

        public function post(){
            $inputs = $this->param();
           if(count($inputs)==0){
            Session::delete("cart".Input::ip());  
           }else{
               Session::set("cart".Input::ip(),$inputs);
           }

        }
        public function delete(){
            Session::delete("cart".Input::ip());
        }
    } 





?>