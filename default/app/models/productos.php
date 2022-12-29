<?php

    class Productos extends ActiveRecord
    {

        public function getAll(){

            $sql = "SELECT productos.*,favorites.Productos_id AS 'FAV' FROM productos 
                    LEFT JOIN favorites ON favorites.Productos_id = productos.id 
                    ORDER BY Productos.Rubros_id DESC";
            return $this->find_all_by_sql($sql);        

        }

        
        
    }

?>