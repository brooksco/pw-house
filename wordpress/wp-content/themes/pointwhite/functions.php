<?php 

function load_my_scripts()
{

	wp_deregister_script( 'jquery' );  
    wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');  
    wp_enqueue_script('jquery');  
    wp_register_script('myscript', get_template_directory_uri().'/js/dev/custom-ck.js', array('jquery') );  
    wp_enqueue_script('myscript');  


	// wp_enqueue_script( 'custom-script', '/js/custom-min.js' );
}
add_action( 'wp_enqueue_scripts', 'load_my_scripts' );

?>