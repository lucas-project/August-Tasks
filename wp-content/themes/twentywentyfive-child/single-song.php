<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

    <h1><?php the_title(); ?></h1>

    <p>
        <strong>Author:</strong> <?php echo esc_html( get_post_meta( get_the_ID(), 'author_name', true ) ); ?>
    </p>
    <p>
        <strong>Release Date:</strong> <?php echo esc_html( get_post_meta( get_the_ID(), 'release_date', true ) ); ?>
    </p>
    <p>
        <strong>Duration:</strong> <?php echo esc_html( get_post_meta( get_the_ID(), 'duration', true ) ); ?>
    </p>
    <p>
        <strong>Producer:</strong> <?php echo esc_html( get_post_meta( get_the_ID(), 'producer', true ) ); ?>
    </p>
    <p>
        <strong>Featured Artists:</strong> <?php echo esc_html( get_post_meta( get_the_ID(), 'featured_artists', true ) ); ?>
    </p>

    <hr>

    <h3>Description</h3>
    <div><?php the_content(); ?></div>

    <?php
        $lyrics = get_post_meta( get_the_ID(), 'lyrics', true );
        if ( ! empty( $lyrics ) ) :
    ?>
        <hr>
        <h3>Lyrics</h3>
        <div>
            <?php echo nl2br( esc_html( $lyrics ) ); ?>
        </div>
    <?php endif; ?>

    <hr>
    <div>
        <?php echo get_the_term_list( get_the_ID(), 'genre', '<strong>Genres:</strong> ', ', ', '' ); ?>
    </div>

<?php endwhile; ?>

<p style="margin-top: 20px;">
    <a href="<?php echo esc_url( get_post_type_archive_link( 'song' ) ); ?>">&laquo; Back to All Songs</a>
</p>

<?php get_footer(); ?>