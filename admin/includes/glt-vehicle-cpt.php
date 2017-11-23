<?php
//===========================================================================
//    CREATE CUSTOM POST TYPE
//===========================================================================
add_action( 'init', 'gltv_custom_post_type' );
function gltv_custom_post_type() {
  register_post_type( 'gltv',
    array(
      'labels' => array(
        'name' => 'Vehicle Slider',
        'singular_name' => 'Vehicle Slider',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Vehicle Slider',
        'edit' => 'Edit',
        'edit_item' => 'Edit Vehicle Slider',
        'new_item' => 'New Vehicle Slider',
        'view' => 'View',
        'view_item' => 'View Vehicle Slider',
        'search_items' => 'Search Vehicle Slider',
        'not_found' => 'No Vehicle Slider found',
        'not_found_in_trash' => 'No Vehicle Slider found in Trash',
        'parent' => 'Parent Vehicle Slider'
      ),

      'public' => true,
      'menu_position' => 0,
      'supports' => array( 'title', 'thumbnail' ),
      'taxonomies' => array( '' ),
      'menu_icon' => 'dashicons-performance',
      'has_archive' => true
    )
  );
}