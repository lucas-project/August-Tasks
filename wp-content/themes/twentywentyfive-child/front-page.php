<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div style="text-align: center; padding: 50px 20px;">
            <h1>Welcome to the Music Site</h1>
            <p>Check out our collection of songs!</p>
            
            <div style="margin-top: 30px;">
                <a href="<?php echo esc_url(get_post_type_archive_link('song')); ?>" 
                   style="display: inline-block; background-color: #0693e3; color: white; 
                          padding: 15px 30px; text-decoration: none; border-radius: 8px; 
                          font-weight: bold; font-size: 16px;">
                    Browse All Songs
                </a>
            </div>

            <?php
            $genres = get_terms( array(
                'taxonomy' => 'genre',
                'hide_empty' => false,
            ) );

            if ( ! empty( $genres ) && ! is_wp_error( $genres ) ) {
                echo '<div class="genre-list" style="margin-top: 30px;">';
                echo '<h4>Or browse by genre:</h4>';
                $genre_links = array();
                foreach ( $genres as $genre ) {
                    $term_link = get_term_link( $genre );
                    if ( ! is_wp_error( $term_link ) ) {
                         $genre_links[] = '<a href="' . esc_url( $term_link ) . '" style="margin: 0 10px; text-decoration: none; color: #0693e3;">' . esc_html( $genre->name ) . '</a>';
                    }
                }
                echo implode( ' | ', $genre_links );
                echo '</div>';
            }
            ?>
        </div>
    </main>
</div>

<?php get_footer(); ?> 