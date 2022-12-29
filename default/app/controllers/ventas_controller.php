<?php
   
    Load::lib('mailer');
    
    class VentasController extends RestController
    {
    
        public function getAll(){
            $Ventas = new Ventas();
            $data=[];
            $data = $Ventas->find("order: Clientes_id");
            $this->data = $data;
            

        }
        public function get_carritos($idventas){
            $sql = "SELECT vtas.Id AS 'Venta',car.Productos_id AS 'IdProd',car.Cant AS 'UnidProd',prod.Nom AS 'ProdNom',prod.final AS 'Final',prod.final*car.Cant AS 'SubTot',prod.SrcImages AS 'Images'"
                   ." FROM carrito AS car"
                   ." LEFT JOIN productos AS prod ON prod.id = car.Productos_id"
                   ." LEFT JOIN ventas AS vtas ON vtas.id = car.Ventas_id"
                   ." WHERE vtas.Id = $idventas"
                   ." ORDER BY prod.Nom";
            $this->data = [];
            $carrito = [];
            $oVentas = new Ventas();
            $total = 0;
            try {
                $paginVentas = $oVentas->find_all_by_sql($sql);
                foreach ($paginVentas as $key => $value) {
                    $carrito[$key]["Venta"]=$value->Venta;
                    $carrito[$key]["IdProd"]=$value->IdProd;
                    $carrito[$key]["UnidProd"]=$value->UnidProd;
                    $carrito[$key]["ProdNom"]=$value->ProdNom;
                    $carrito[$key]["Final"]=$value->Final;
                    $carrito[$key]["SubTot"]=$value->SubTot;
                    $carrito[$key]["HostUrl"]=$GLOBALS['HOSTURL'];
                    $carrito[$key]["Images"]=$value->Images;
                    
                }
                $sum = function($arrCart){
                     return $arrCart['SubTot'];
                };
                $total=array_sum(array_map($sum,$carrito));
                $this->data = ["carrito"=>$carrito,"total"=>$total];
            }catch (\Throwable $th) {
                $this->data=array();
                return false;
            }
            return $this->data;
        }
        public function get_buscarVentas($where='1=1'){
            if(strpos($where,"&")){
                $where = str_replace("&","%",$where);
            }
            
            $sql = "SELECT vtas.Id,CONCAT(users.Nom,', ',users.Ap) AS 'Usuario',users.Dni AS 'Dni',users.Mail AS 'Mail',users.Tel AS 'Tel',users.Dir AS 'Dir',vtas.Id AS 'NroVenta',vtas.TipoEnvio AS 'TipoEnvio',vtas.Detalle AS 'Detalle',"
                    . "vtas.Dir AS 'DirAlt',vtas.Estado AS 'Estado',DATE_FORMAT(vtas.Fch_insert, '%d/%m/%Y') AS 'FchIngreso',DATE_FORMAT(vtas.Fch_insert, '%T') AS 'HsIngreso',"
                    . "DATE_FORMAT(vtas.Entregado, '%d/%m/%Y') AS 'FchEntregado',DATE_FORMAT(vtas.Entregado,'%d/%m/%Y') AS 'HsEntregado',COUNT(car.Id) AS 'CantProd'"
                    . " FROM ventas AS vtas"
                    . " LEFT JOIN usuarios AS users ON users.Id = vtas.Clientes_id"
                    . " LEFT JOIN carrito AS car ON car.Ventas_id = vtas.Id"
                    . " LEFT JOIN productos AS prod ON prod.id = car.Productos_id"
                    . " GROUP BY vtas.Id"
                    . " ORDER BY vtas.Fch_insert, vtas.Entregado";

            $this->data=array();
            $oVentas = new Ventas();
            $paginVentas = $oVentas->find_all_by_sql($sql);
            foreach ($paginVentas as $key => $value) {
                $this->data[$key]["Id"]=$value->Id;  
                $this->data[$key]["Usuario"]=$value->Usuario;  
                $this->data[$key]["Dni"]=$value->Dni;  
                $this->data[$key]["Mail"]=$value->Mail;  
                $this->data[$key]["Tel"]=$value->Tel;  
                $this->data[$key]["Dir"]=$value->Dir;  
                $this->data[$key]["NroVenta"]=$value->NroVenta;  
                $this->data[$key]["Detalle"]=$value->Detalle;  
                $this->data[$key]["DirAlt"]=$value->DirAlt;  
                $this->data[$key]["Estado"]=$value->Estado;  
                $this->data[$key]["FchIngreso"]=$value->FchIngreso;  
                $this->data[$key]["TipoEnvio"]=(intval($value->TipoEnvio)==1)?"Retira en Local":"Envio a Domicilio";  
                $this->data[$key]["HsIngreso"]=$value->HsIngreso;  
                $this->data[$key]["FchEntregado"]=$value->FchEntregado;  
                $this->data[$key]["HsEntregado"]=$value->HsEntregado;  
                $this->data[$key]["CantProd"]=$value->CantProd;
                $sql = "SUM(prod.final*car.Cant)"
                ." FROM carrito AS car"
                ." LEFT JOIN productos AS prod ON prod.id = car.Productos_id"
                ." LEFT JOIN ventas AS vtas ON vtas.id = car.Ventas_id"
                ." WHERE vtas.Id = {$value->Id}";
                
                $this->data[$key]["Total"]=ActiveRecord::static_select_one($sql);  
                switch(intval($value->Estado)){
                    case 0:
                        $this->data[$key]["EstadoDescrip"]='En Proceso';
                        break;
                    case 1:
                        $this->data[$key]["EstadoDescrip"]='En Proceso de Env&iacute;o';
                        break;
                    case 2:
                        $this->data[$key]["EstadoDescrip"]='Finalizado';
                        break;
                  }
                
             
            }
                
         return $this->data;  
    }

        public function post(){
            ini_set( 'display_errors', 1 );
            error_reporting( E_ALL );
            $usuarios = new Usuarios();
            $input = $this->param()['venta'];
            $Ventas = new Ventas();
           $Ventas->Fpago_id = Filter::get(1,'htmlspecialchars');
           $Ventas->Clientes_id = Filter::get($input['Clientes_id'],'htmlspecialchars');
           $Ventas->Envio = Date("Y-m-d");
           $Ventas->Estado = 0;
           $sucursal = 1;
           $Ventas->CodeVenta = $sucursal.uniqid().Auth::get('Dni');
           $Ventas->Dir = Filter::get($input['Dir'],'htmlspecialchars', array('charset' => 'UTF-8'));
           $Ventas->TipoEnvio = $input['TipoEnvio'];
           if(isset($input['Detalle'])){
               $Ventas->Detalle = Filter::get($input['Detalle'],'htmlspecialchars', array('charset' => 'UTF-8'));
           }
           if($Ventas->save()){
               $idVenta = $Ventas->Id;
           
           foreach ($input['cart'] as $order) {
               $Carrito = new Carrito();
               $Carrito->Productos_id = Filter::get($order['Id'],'htmlspecialchars');
               $Carrito->Cant = Filter::get($order['Cant'],'htmlspecialchars');
               $Carrito->Ventas_id = $idVenta;
               if(!$Carrito->save()){
                   $Ventas->delete("Id=$idVenta");
                   return false;
               }
               
           }
            $usuario = $usuarios->find_first("conditions: Id=".$input['Clientes_id']);

            $carrito = $this->get_carritos($idVenta); 
            $tbody  = array();
            foreach ( $carrito["carrito"] as $key => $value) {
                $tbody[$key]="<tr>
                
                <td style='text-align: center;text-transform: capitalize;'>".$value['ProdNom']."</td>
                <td style='text-align: center;'>"."$ ".$value['Final']."</td>
                <td style='text-align: center;'>".$value['UnidProd']."</td>
                <td style='text-align: center;'>"."$ ".$value['SubTot']."</td>
                </tr>";
            }
            $bodymail=str_replace(["{NOMBRE}","{NROPEDIDO}","{TBODY}","{TOTAL}","{URLIMAGE}","{URLWEBSITE}","_parent","{VIEWDISPLAY}"],[$usuario->Nom.", ".$usuario->Ap,str_pad($idVenta,10,"0"),implode("",$tbody),$carrito["total"],$GLOBALS['HOSTURLROOT'],$GLOBALS['WEBURL'],"_parent",""],file_get_contents(APP_PATH.'views/templates/mail/ventaDetails.html'));
            mail($usuario->Mail,"Gracias por su compra",$bodymail,"MIME-Version: 1.0\r\nContent-type: text/html; charset=UTF-8\r\nFrom: 'El Bodegon' <ventas@vinotecaelbodegon.com>");
            $this->data = $bodymail;

        }else{
            $this->data = $this->error("No se pudo insertar el registro", 500);
            return false;
        }
            
            
        }

       
        public function put($id){

            $input = $this->param();
            $Ventas = new Ventas();
            $usuarios = new Usuarios();
            $venta = $Ventas->find_first("conditions: Id=$id");
            if(intval($input["Estado"])===2){
                $venta->Entregado = date(DATE_ATOM);    
            }
            $venta->Estado = $input["Estado"];
            //$mail = new mailer();
            if($venta->update()){
                $usuario = $usuarios->find_first("conditions: Id=".$venta->Clientes_id);
                $bodymail=str_replace("{NOMBRE}",$usuario->Nom.", ".$usuario->Ap,file_get_contents(APP_PATH.'views/templates/mail/despacho.html'));
                mail($usuario->Mail,"Tu pedido esta en camino",$bodymail,"MIME-Version: 1.0\r\nContent-type: text/html; charset=UTF-8\r\nFrom: 'El Bodegon' <ventas@vinotecaelbodegon.com>");
               $this->data = $this->get_buscarVentas("Id=$id")[0]; 
            }else{
                $this->data="NO_REG";
            }
            

        }

        public function delete($id){

            $Carrito = new Carrito();
            $producto = $Carrito->find_first("conditions: Id=$id");
            $producto->delete("Id=$id");

        }

    } 





?>