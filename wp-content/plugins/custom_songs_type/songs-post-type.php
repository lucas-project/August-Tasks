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
    // Debug: Log that this function is being called
    error_log('Custom post type function called');
    
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
        'rewrite'           => array('slug' => 'song'),
    );
    // Call the actual WordPress function
    // Parameter 1 is a name for the post type
    // Parameter 2 is the $args array
    register_post_type('song', $args);
    
    // Debug: Log that post type was registered
    error_log('Song post type registered with slug: song');
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



// Enqueue meta box styles
add_action( 'admin_enqueue_scripts', 'song_meta_box_styles' );
function song_meta_box_styles( $hook ) {
    global $post;
    
    // Only load on song post type edit screens
    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if ( 'song' === get_post_type( $post ) ) {
            wp_enqueue_style( 'song-meta-box-styles', plugins_url( 'css/meta-box-style.css', __FILE__ ) );
        }
    }
}

// Add meta box 
add_action("add_meta_boxes", "add_song_meta_box");

function add_song_meta_box() {
    add_meta_box(
        "song_meta_box", // Meta box ID
        "Song Details", // Meta box title
        "song_meta_box_callback", // Meta box callback function
        "song", // The custom post type parameter 1
        "normal", // Meta box location in the edit screen
        "high" // Meta box priority
    ); 
}

function song_meta_box_callback() { 
    wp_nonce_field('song-nonce', 'meta-box-nonce');
    global $post;
    
    // Get saved values
    $author_name = get_post_meta($post->ID, 'author_name', true);
    $release_date = get_post_meta($post->ID, 'release_date', true);
    $duration = get_post_meta($post->ID, 'duration', true);
    $featured_artists = get_post_meta($post->ID, 'featured_artists', true);
    $producer = get_post_meta($post->ID, 'producer', true);
    $lyrics = get_post_meta($post->ID, 'lyrics', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="author_name">Author Name</label></th>
            <td><input type="text" id="author_name" class="regular-text" name="author_name" value="<?php echo esc_attr($author_name); ?>" /></td>
        </tr>
        <tr>
            <th><label for="release_date">Release Date</label></th>
            <td><input type="date" id="release_date" class="regular-text" name="release_date" value="<?php echo esc_attr($release_date); ?>" /></td>
        </tr>
        <tr>
            <th><label for="duration">Duration (MM:SS)</label></th>
            <td><input type="text" id="duration" class="regular-text" name="duration" placeholder="e.g. 3:45" value="<?php echo esc_attr($duration); ?>" /></td>
        </tr>
        <tr>
            <th><label for="featured_artists">Featured Artists</label></th>
            <td><input type="text" id="featured_artists" class="regular-text" name="featured_artists" placeholder="Separate multiple artists with commas" value="<?php echo esc_attr($featured_artists); ?>" /></td>
        </tr>
        <tr>
            <th><label for="producer">Producer</label></th>
            <td><input type="text" id="producer" class="regular-text" name="producer" value="<?php echo esc_attr($producer); ?>" /></td>
        </tr>
        <tr>
            <th><label for="lyrics">Lyrics</label></th>
            <td><textarea id="lyrics" name="lyrics" rows="10" cols="50"><?php echo esc_textarea($lyrics); ?></textarea></td>
        </tr>
    </table>
    <?php  
}

// Save meta box data
add_action('save_post', 'author_save_postdata');
function author_save_postdata($post_id) {
    // If this is an autosave, our form has not been submitted
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // Verify nonce
    if (!isset($_POST['meta-box-nonce']) || !wp_verify_nonce($_POST['meta-box-nonce'], 'song-nonce')) {
        return $post_id;
    }

    // Retrieve post type
    if ('song' !== get_post_type($post_id)) {
        return $post_id;
    }

    // Check the user's permissions
    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    /* OK, it is safe to save the data now. */
    // Sanitize user input.
    // Define fields to save
   $meta_fields = array(
    'author_name' => 'sanitize_text_field',
    'release_date' => 'sanitize_text_field',
    'duration' => 'sanitize_text_field',
    'featured_artists' => 'sanitize_text_field',
    'producer' => 'sanitize_text_field',
    'lyrics' => 'sanitize_textarea_field'
   );

   // Save each field with appropriate sanitization
   foreach ($meta_fields as $field => $sanitize_callback) {
      if (isset($_POST[$field])) {
          $value = $sanitize_callback($_POST[$field]);
          update_post_meta($post_id, $field, $value);
      }
    } 
    
}

function display_contact_form() {
	ob_start();
	?>
	<form>
		<p>
			<label for="song-name">Name</label><br>
			<input type="text" id="song-name" name="name" required>
		</p>
		<p>
			<label for="song-email">Email</label><br>
			<input type="email" id="song-email" name="email" required>
		</p>
		<p>
			<input type="submit" value="Submit">
		</p>
	</form>
	<?php
	return ob_get_clean(); 
}
add_shortcode( 'song_contact_form', 'display_contact_form' );


