<?php

    class RolesController extends RestController
    {
       
        public function getAll(){
            $Rol = new Rol();
            $data=[];
            $data=$Rol->find();
            $this->data = $data;
        }
        
        

  
    } 






?>