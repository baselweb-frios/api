<?php

    class Prov extends ActiveRecord
    {
        function getNomById($prov_id){
            return $this->find_first("conditions: Prov_id={$prov_id}")->Nom;
        }
    }

?>