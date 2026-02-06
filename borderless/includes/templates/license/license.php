<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

define( 'BORDERLESS_MAIN_FILE', __FILE__ );

// Carrega a classe do SDK
require_once BORDERLESS__INC . '/templates/license/license-client.php';

// Inicializa o gerenciador de licença depois de plugins_loaded
function borderless_init_license_manager() {

    if ( ! class_exists( 'BORDERLESS_LICENSE' ) ) {
        return;
    }

    $wcam_lib_custom_menu = array(
        'menu_type'   => 'add_submenu_page',
        'parent_slug' => 'borderless.php',
        'page_title'  => __( 'License', 'vslmd' ),
        'menu_title'  => __( 'License', 'vslmd' ),
    );

    global $borderless_license;

    $borderless_license = new BORDERLESS_LICENSE(
        BORDERLESS_MAIN_FILE,         // usa o principal do plugin
        '',                           // product_id vazio, vai usar o select
        null,
        '1.0.0',
        'plugin',
        'https://visualmodo.com/',
        __( 'Borderless Pro', 'vslmd' ),
        'vslmd',
        $wcam_lib_custom_menu
    );
}
add_action( 'plugins_loaded', 'borderless_init_license_manager' );
