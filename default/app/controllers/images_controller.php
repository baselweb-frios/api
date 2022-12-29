<?php

    class ImagesController extends RestController
    {
      
      public function get($section){
            $images=[];
            if(! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ){
              $path =  $_SERVER['DOCUMENT_ROOT']."/app/images/$section/";
            }else{
              $path = $_SERVER['DOCUMENT_ROOT']."/tusuper.shop/app/images/$section/";
            }
            
            $files = scandir($path);
              foreach ($files as $ix => $file) {
               if ($file !== '.' && $file !== '..') {
                switch ($section) {
                  case 'users_profiles':
                    $images[$ix]['path']=$GLOBALS["HOSTURLUSER"].$file;
                    $images[$ix]['img']=$file;
                  break;
                  case 'products':
                  $images[$ix]['path']=$GLOBALS["HOSTURL"].$file;
                  $images[$ix]['img']=$file;
                  break;
                  default:
                  $images[$ix]['path']=$GLOBALS["HOSTURLROOT"].$file;
                  $images[$ix]['img']=$file;
                  break;
                }
                  
                }
              }
               
               $this->data=$images;

        }
    } 
?>