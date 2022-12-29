<?php
/**
 * KumbiaPHP Web Framework
 * Parámetros de conexión a la base de datos
 */
return [
    'development' => [
        /**
         * host: ip o nombre del host de la base de datos
         */
        'host'     => 'localhost',
        
        /**
         * username: usuario con permisos en la base de datos
         */
        'username' => 'baselweb', //no es recomendable usar el usuario root
        /**
         * password: clave del usuario de la base de datos
         */
        'password' => 'b4s3lW3b',
        /**
         * test: nombre de la base de datos
         */
        'name'     => 'ecomercedb',
        /**
         * type: tipo de motor de base de datos (mysql, pgsql, oracle o sqlite)
         */
        'type'     => 'mysql',
        /**
         * charset: Conjunto de caracteres de conexión, por ejemplo 'utf8'
         */
        'charset'  => 'utf8',
        /**
         * dsn: Cadena de conexión a la base de datos
         */
        //'dsn' => '',
        /**
         * pdo: activar conexiones PDO (On/Off); descomentar para usar
         */
        //'pdo' => 'On',
        ],

    'production' => [
         /**
         * host: ip o nombre del host de la base de datos
         */
        'host'     => '213.190.6.30',
        
        /**
         * username: usuario con permisos en la base de datos
         */
        'username' => 'u822821313_admin', //no es recomendable usar el usuario root
        /**
         * password: clave del usuario de la base de datos
         */
        'password' => 'D8u69=FOz~9',
        /**
         * test: nombre de la base de datos
         */
        'name'     => 'u822821313_dbshop',
        /**
         * type: tipo de motor de base de datos (mysql, pgsql, oracle o sqlite)
         */
        'type'     => 'mysql',
        /**
         * charset: Conjunto de caracteres de conexión, por ejemplo 'utf8'
         */
        'charset'  => 'utf8',
        /**
         * dsn: Cadena de conexión a la base de datos
         */
        //'dsn' => '',
        /**
         * pdo: activar conexiones PDO (On/Off); descomentar para usar
         */
        //'pdo' => 'On',
        ],
];

/**
 * Ejemplo de SQLite
 */
/*'development' => [
    'type' => 'sqlite',
    'dsn' => 'temp/data.sq3',
    'pdo' => 'On',
] */
