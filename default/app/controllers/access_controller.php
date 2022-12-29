<?php 
class AccessController extends RestController{

    public function post(){
        extract($this->param());
        $usuarios = (new Usuarios);
        $userExist = false;
            if (isset($pass)&&isset($user)){
                if(filter_var($user,FILTER_SANITIZE_EMAIL)){
                    $usuario = $usuarios->find_first("conditions: Mail=$user");
                }
                if(filter_var($user,FILTER_SANITIZE_NUMBER_INT)){
                    $usuario = $usuarios->find_first("conditions: Dni=$user");
                }
                // if(isset($module)){
                //     $cond[0].=" AND Rol_id = 1";
                // }
                
                if ($usuario) {
                    if(password_verify($pass,$usuario->Pass)){
                        $auth = new Auth("model", "class: usuarios","DNI: ".$usuario->Dni);
                        
                        $this->data=($auth->authenticate())?
                        Auth::get_active_identity()
                        :
                        false
                        ;
                    }else{
                        Auth::destroy_identity();
                        $this->data = false;
                    }
                } else {
                    $this->data = false;
                }
            }
            else{
                $this->data = false;
            }
            
    }
    public function get_logout(){
        if(Auth::is_valid()){
            $this->data = Auth::destroy_identity();
        }else{
            $this->data = 'no_auth';
        }
    }
    public function post_isLogged(){
        $input = $this->param();

        $oUsers =new Usuarios();
        $user = $oUsers->count("DNI=".$input['DNI']);
        
        if(Auth::is_valid()&& $user>0){
            $this->data = session_id();
        }else{
            $this->data = 'no_auth';
        }
    }


}