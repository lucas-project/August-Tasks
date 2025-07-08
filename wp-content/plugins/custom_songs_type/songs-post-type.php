<?php
/*
Plugin Name: Custom Songs Post Types
Description: Add post types for custom songs, only admin users can manage
Author: lucas
*/

// Hook custom_post_custom_songs() to the init action hook
add_action( 'init', 'custom_post_custom_songs' );
// The custom function to register a custom song post type
function custom_post_custom_songs() {
    // Set the labels. This variable is used in the $args array
    $labels = array(
        'name'               => __( 'Songs' ),
        'singular_name'      => __( 'Song' ),
        'add_new'            => __( 'Add New Song' ),
        'add_new_item'       => __( 'Add New Song' ),
        'edit_item'          => __( 'Edit Song' ),
        'new_item'           => __( 'New Song' ),
        'all_items'          => __( 'All Songs' ),
        'view_item'          => __( 'View Song' ),
        'search_items'       => __( 'Search Songs' ),
        'featured_image'     => 'Poster',
        'set_featured_image' => 'Add Poster'
    );
// The arguments for our post type, to be entered as parameter 2 of register_post_type()
    $args = array(
        'labels'            => $labels,
        'description'       => 'Holds our custom song post specific data',
        'public'            => true,
        'menu_position'     => 5,
        'supports'          => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
        'has_archive'       => true,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'query_var'         => true,
    );
    // Call the actual WordPress function
    // Parameter 1 is a name for the post type
    // Parameter 2 is the $args array
    register_post_type('song', $args);
}

// Register Song Genre Taxonomy
add_action( 'init', 'create_genre_taxonomy', 0 );
function create_genre_taxonomy() {
    $labels = array(
        'name'              => _x( 'Genres', 'taxonomy general name' ),
        'singular_name'     => _x( 'Genre', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Genres' ),
        'all_items'         => __( 'All Genres' ),
        'parent_item'       => __( 'Parent Genre' ),
        'parent_item_colon' => __( 'Parent Genre:' ),
        'edit_item'         => __( 'Edit Genre' ),
        'update_item'       => __( 'Update Genre' ),
        'add_new_item'      => __( 'Add New Genre' ),
        'new_item_name'     => __( 'New Genre Name' ),
        'menu_name'         => __( 'Genres' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'genre' ),
    );

    register_taxonomy( 'genre', array( 'song' ), $args );
    // Create default genre terms if they don't exist
    if (!term_exists('Classical', 'genre')) {
        wp_insert_term('Classical', 'genre');
    }
}


