<?php
Load::lib('mailer');
class installController extends AppController{

    public function index(){
       
           $from ='ventas@vinotecaelbodegon.com';
           $to = "facundoleonardorios@gmail.com";
           $subject = "Checking PHP mail";
           $message = "Hola";
           $headers = "From:" . $from;
           $mail = new sendmail();
           mail($to,$subject,"<div style='background-color:red;color:black'>Anduvo la puta que te pario</div>","MIME-Version: 1.0\r\nContent-type: text/html; charset=UTF-8\r\nFrom: 'El Bodegon' <ventas@vinotecaelbodegon.com>");
           echo "The email message was sent.";
        
    }
}
?>