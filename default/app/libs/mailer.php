<?php
 class sendmail{
    private $configMail=[];
    function __construct(){
        $this->configMail["from"] =  "ventas@vinotecaelbodegon.com";
        $this->configMail["headers"] =  "MIME-Version: 1.0\r\nContent-type: text/html; charset=UTF-8\r\nFrom: 'El Bodegon' <ventas@vinotecaelbodegon.com>";
    }
    public function enviarMail($addressTo,$subject,$message,$nameTo){
           ini_set( 'display_errors', 1 );
           error_reporting( E_ALL );
           mail($addressTo,$subject,$message,$this->configMail["headers"]."To: $nameTo <$addressTo>");
    }
    
 }


?>