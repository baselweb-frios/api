<?php

    class Marcas extends ActiveRecord
    {
        function getNomMarcasById($id){
            return $this->find_first("conditions: Id=$id")->Nom;
        }
    }

?>