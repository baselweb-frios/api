<?php

   class configController extends RestController{
       
       public function get_genKey($text=''){

            $this->data = array("key"=>password_hash($text,PASSWORD_DEFAULT));

       }

       public function get_infoTables($table){
           $model = ActiveRecord::get($table);
           $this->data = $model->get_alias();
       }
   }