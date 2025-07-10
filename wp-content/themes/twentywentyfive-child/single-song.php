<?php
get_header(); // Include the header

if (have_posts()) :
    while (have_posts()) : the_post(); ?>
        <h1><?php the_title(); ?></h1>
        <div><?php the_content(); ?></div>
        <p><strong>Author:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'author_name', true)); ?></p>
        <p><strong>Release Date:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'release_date', true)); ?></p>
        <p><strong>Duration:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'duration', true)); ?></p>
        <p><strong>Featured Artists:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'featured_artists', true)); ?></p>
        <p><strong>Producer:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'producer', true)); ?></p>
        <p><strong>Lyrics:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'lyrics', true)); ?></p>
    <?php endwhile;
else :
    echo '<p>No songs found.</p>';
endif;
?>

<p style="margin-top: 20px;">
    <a href="<?php echo esc_url( get_post_type_archive_link( 'song' ) ); ?>">&laquo; Back to All Songs</a>
</p>

<?php get_footer(); // Include the footer
?>