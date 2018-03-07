<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
    <title><?php seo_title(); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta name="theme-color" content="#181818">
		<?php /* <link rel="shortcut icon" href="<?php echo esc_url( get_template_directory_uri() ) ; ?>/favicon.ico"> */?>
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
	<div id="main">
	<header>
	   <div class="row">
	    	<a id="logo" href="/" style="background: url(<?php the_field("logo","options"); ?>);background-size: 100%;background-repeat: no-repeat;" ></a>
	        <nav>
						<div class="memutext">Menu</div>
						<div class='menuopen'><span class='first'></span><span class='center'></span><span class='last'></span></div>
	            <?php wp_nav_menu(array('container' => false, 'items_wrap' => '<ul>%3$s</ul>', 'theme_location'  => 'general')); ?>
	        </nav>
	    </div>
	</header>