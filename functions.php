<?php 

function register_menus() {
     register_nav_menus(
         array( 'header-menu' => __( 'Header Menu' ) )
     );
 }
 add_action( 'init', 'register_menus' );

function trim_title(&$title, $max_chars=20) {
    $title_len = strlen($title);
    if ($title_len > $max_chars) {
        $title = substr($title, 0, $max_chars)
            . '...';
    }
}
?>