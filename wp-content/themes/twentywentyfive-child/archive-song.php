<?php
get_header(); // Include the header

if (have_posts()) : ?>
    <h1><?php post_type_archive_title(); ?></h1>
    <ul>
        <?php while (have_posts()) : the_post(); ?>
            <li>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                <p><?php echo esc_html(get_post_meta(get_the_ID(), 'duration', true)); ?></p>
            </li>
        <?php endwhile; ?>
    </ul>
<?php else : ?>
    <p>No songs found.</p>
<?php endif; ?>

<?php get_footer(); // Include the footer ?>