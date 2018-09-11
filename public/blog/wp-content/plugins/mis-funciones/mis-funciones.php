<?php
/*
Plugin Name: Mis funciones
Plugin URI: 
Description: 
Version: 
Author: Vincen Santaella
Author URI: 
License: 
License URI: 
*/
add_shortcode ('usuarios', function ($atributos, $contenido = null) {
     return is_user_logged_in() ? $contenido : false;
});