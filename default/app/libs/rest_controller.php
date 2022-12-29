<?php

/**
 * Controlador para manejar peticiones REST
 * 
 * Por defecto cada acción se llama como el método usado por el cliente
 * (GET, POST, PUT, DELETE, OPTIONS, HEADERS, PURGE...)
 * ademas se puede añadir mas acciones colocando delante el nombre del método
 * seguido del nombre de la acción put_cancel, post_reset...
 *
 * @category Kumbia
 * @package Controller
 * @author kumbiaPHP Team
 */

require_once CORE_PATH . 'kumbia/kumbia_rest.php';
//$2y$10$nTs6Spqr2gUXleMT.Mzd5.VyNGcOA5C.EboHLSNTYHsuqTRxgpixu
class RestController extends KumbiaRest {

    /**
     * Inicialización de la petición
     * ****************************************
     * Aqui debe ir la autenticación de la API
     * ****************************************
     */
    final protected function initialize() {
       $headers = $this->getHeaders();
       $key_api = (isset($headers['Authorization']))?$headers['Authorization']:NULL;
       $token = (new Tokens)->find_first("conditions: Key_api='$key_api'");
       
       if($token==FALSE){
        $this->error("Key bad", 401);
        $this->data = "NO_AUTH";
        return false;
       } 
       
       
        if(password_verify($key_api,$token->Token)){
            if(strtolower(Router::get('method'))!=='get'&&!Auth::is_valid()&&!in_array($this->controller_name,array('usuarios','prov','config','cart'))){
              $this->data = 'NO_AUTH';  
              return false;  
            }
            return true;
        }else{
            $this->error("Key bad", 401);
            $this->data = "NO_AUTH";
            return false;
        }       
            
        
    }

    final protected function finalize() {
        
    }
    
      

}