
<!--
    ---------------------------------
-->

<!-- This piece has 'd-none' on the end, so it is not being shown -->
<div class="d-flex justify-content-between align-items-center mb-4 container-title-sidemenu">
    <h5 class="title-sidemenu">ACESSO RÁPIDO</h5>
    <img
        src="https://www.farmacia.ufmg.br/wp-content/uploads/2024/03/icon.png"
        alt="Ícone Acesso Rápido"
    />
</div>

<?php

/*
    Was defined that:
        The Primary Menu would be the header menu;
        The Secondary Menu would be the home page sidemenu;
    
    So...
*/

function get_institucional_menu() {

    $INSTITUCIONAL_MENU_ID = 4;

    return $INSTITUCIONAL_MENU_ID;

}

function get_secondary_menu() {

    /*
        Gets wherever menu was set as secondary to be
        shown at home page
    */

    $menu = array();

    $menu_locations = get_nav_menu_locations();

    $secondary_menu_location = 'secondary_menu';

    if ( isset( $menu_locations[ $secondary_menu_location ] ) ) {

        $secondary_menu_id = $menu_locations[ $secondary_menu_location ];

        $menu = wp_get_nav_menu_object( $secondary_menu_id );

    } else {

        // 'Secondary Menu' not found
        $menu = get_institucional_menu();
        
    }

    return $menu;

}

function get_menu_by_current_content() {

    $category = get_the_category();

    if( isset( $category[0] ) ) { // get_queried_object()->post_type == "post"
        
        return $category[0]->slug;

    } 

    if ( get_post_field( 'post_author' ) != "" ) { // get_queried_object()->post_type == "page"

        $post_author_id = get_post_field( 'post_author' );

        $user = get_user_by( 'id', $post_author_id );

        return $user->data->user_nicename;
    }
    
    return get_institucional_menu();
}

// Get menu by user as default option
$menu = get_menu_by_current_content();

if ( is_home() ) {

    $menu = get_secondary_menu();

}

/* 
    Rendering the sidemenu with custom Menu Walker
*/

wp_nav_menu(array(
    'menu'            => $menu,
    'depth'           => 2,
    'menu_class'      => 'm-0 list-group rounded-0',
    'item_classes'    => array( 'list-group-item','list-group-item-action','rounded-0','fafar-side-menu-item', 'd-flex', 'align-items-center' ),
    'walker'          => new FAFAR_Menu_Walker(),
));

