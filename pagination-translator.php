<?php
/*
Plugin Name: Pagination Translator
Plugin URI: http://szkandy.cz/
Description: Translating wordpress pagination URL (from "page" to anything else). After activating plugin you can set your translation on <a href="options-permalink.php">Permalinks page</a>.
Version: 1.1
Author: Patrik "Szkandy" Szkandera
Author URI: http://szkandy.cz/
*/

new PaginationTranslator;

class PaginationTranslator {

  // Adding hooks, filters
  public function __construct() {
    add_filter( 'admin_init' , array( &$this , 'adminSettings' ) );
    
    // Default
    add_action( 'wp_loaded', array(&$this, 'setPagination') );

  }
 
  public function adminSettings()
  {
    // register_setting( 'permalink', 'pagination_translation', 'esc_attr' );
    /*
      register_setting is bugged at "Permalink page" - https://core.trac.wordpress.org/ticket/9296
      Plugin checks for $_POST and update option_value on its own
    */
    if (isset($_POST['pagination_translation']) && $pagenow = "options-permalink.php")
      update_option("pagination_translation", $_POST['pagination_translation']);


    add_settings_field('pag_translation', '<label for="pagination_translation">'.__('Pagination base' , 'pagination-translator' ).'</label>' , array(&$this, 'adminOutput') , 'permalink', 'optional' );
  }
  
  // Display and fill the form field
  public function adminOutput() 
  {
    $value = get_option( 'pagination_translation' ); 
    ?>
      <input id='pagination_translation' name='pagination_translation' type='text' class="regular-text" value='<?php echo $value; ?>' /> 
    <?php
  }
  
  public function setPagination() 
  {
    global $wp_rewrite;

    $page_name = get_option( 'pagination_translation' ); 
    
    if ($page_name == "")
      $page_name = "page";
    
    $wp_rewrite->pagination_base = $page_name;
  }
  
    
}

?>