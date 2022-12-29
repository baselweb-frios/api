<?php

    class Rubros extends ActiveRecord
    {
        function getNomById($Rubros_id){
            return $this->find_first("conditions: Rubros_id={$Rubros_id}")->Nom;
        }
    }

?>