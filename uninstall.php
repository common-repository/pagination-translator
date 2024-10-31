<?php
if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') )
    exit();
    
global $wp_rewrite;

delete_option('pagination_translate');

$wp_rewrite->pagination_base = "page";
$wp_rewrite->flush_rules();
?>