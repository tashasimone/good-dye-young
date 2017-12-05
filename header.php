<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title(); ?></title>
     <link rel="profile" href="http://gmpg.org/xfn/11" />
     <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
     <link type="text/css" rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />
    <link type="text/css" rel="stylesheet" href="style.css" />
    <?php wp_head(); ?>
</head>

<body class="container">
    <header class="jumbotron row">
        <div class="col-sm-6 col-md-5">
         <h1><a href="index.php"><img src="http://mystic-ralph-3000.codio.io/wp-content/uploads/2017/04/logo-light-gray.png" alt="good dye young logo" class="img-responsive"/></a></h1>
         <p class="tagline">we are goodDYEyoung &#124; your new ride or DYE crew</p>
        </div>
        <div class="col-sm-6 col-md-7 nav-block">
         <nav class="nav nav-pills mobile">             
            <span class="glyphicon glyphicon-menu-hamburger visible-xs"></span>
             <?php 
             wp_nav_menu( array( 
                 'theme_location' => 'header-menu',
                 'container' => false,
                 'menu_class' => 'list-inline nav nav-pills menu'
             )); 
             ?>
         </nav>
         <a class="cart" href="http://mystic-ralph-3000.codio.io/index.php/products-page/checkout/"><span class="glyphicon glyphicon-shopping-cart"></span></a>
        </div>
     </header>
     <main>