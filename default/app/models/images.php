<?php

    class Images extends ActiveRecord
    {
        function getImages($product_id){
            $result = [];
            foreach($this->find("conditions: Productos_id={$product_id}") as $image){
                $result[]=$image->Src;
            }
            return $result;
        }
        
        
    }

?>