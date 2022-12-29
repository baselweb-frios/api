<?php
    
    class UsuariosController extends RestController
    {
    
        public function before_filter(){
        //    if(!Auth::is_valid()){
        //      $this->data = 'NO_AUTH';  
        //      return false; 
        //    }
        }
        public function getAll(){
            $this->data = (new Usuarios)->find("order: Fch_insert Desc");
        }
        
        public function get_by($cond){
            if(isset($cond)){
                $Usuarios = new Usuarios();
                $this->data = $Usuarios->find("conditions: $cond");
            }else{
                $this->data = array("errDb"=>"No ha definido una condici&oacuten");
            }

        }

        public function post(){

            extract($this->param());
            $Usuarios = new Usuarios();
            $Usuarios->Dni =  filter_var($Dni,FILTER_SANITIZE_NUMBER_INT);
            $Usuarios->Nom =  filter_var($Nom);
            $Usuarios->Ap =  filter_var($Ap);
            $Usuarios->Dir =  filter_var($Dir);
            $Usuarios->Mail =  filter_var($Mail,FILTER_SANITIZE_EMAIL);
            $Usuarios->Tel =  filter_var($Tel);
            $Usuarios->Pass =  password_hash($Pass,PASSWORD_DEFAULT);
            $Usuarios->Rol_id =  filter_var($Rol_id,FILTER_SANITIZE_NUMBER_INT);
            $Usuarios->User =  filter_var($Dni,FILTER_SANITIZE_NUMBER_INT);
            $Usuarios->Image = filter_var($Image,FILTER_SANITIZE_URL);
            $this->data =($Usuarios->save())
                            ?
                            $Usuarios->find("order: Fch_insert DESC")
                            :
                            $this->error("No se pudo insertar el registro", 500);
        }
        
        public function put($id){
            extract($this->param());
            $Usuario = (new Usuarios)->find_first("conditions: Id = $id");
            $Usuario->Dni =  filter_var($Dni,FILTER_SANITIZE_NUMBER_INT);
            $Usuario->Nom =  filter_var($Nom);
            $Usuario->Ap =  filter_var($Ap);
            $Usuario->Dir =  filter_var($Dir);
            $Usuario->Mail =  filter_var($Mail,FILTER_SANITIZE_EMAIL);
            $Usuario->Tel =  filter_var($Tel);
            $Usuario->Pass =  password_hash($Pass,PASSWORD_DEFAULT);
            $Usuario->Rol_id =  filter_var($Rol_id,FILTER_SANITIZE_NUMBER_INT);
            $Usuario->User =  filter_var($Dni,FILTER_SANITIZE_NUMBER_INT);
            $Usuario->Image = filter_var($srcImage,FILTER_SANITIZE_URL);
            $this->data = ($Usuario->update())
                            ?
                            $Usuario->find("order: Fch_update DESC")
                            :
                            false;
        }

        public function put_recoveryPassword($id){
            extract($this->param());
            $Usuario = (new Usuarios)->find_first("conditions: Id = $id");
            $Usuario->Pass =  password_hash($Pass,PASSWORD_DEFAULT);
            $this->data = ($Usuario->update())
                            ?
                            $Usuario
                            :
                            false;
        }
        
        public function delete($id){
            $Usuario = new Usuarios();
            $this->data = ($Usuario->delete("Id=$id"))
                            ?
                            $Usuario->find("order: Fch_update DESC")
                            :
                            false;
        }

        
        
       

        

    } 





?>