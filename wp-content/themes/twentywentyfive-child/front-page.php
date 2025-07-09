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
        </div>
    </main>
</div>

<?php get_footer(); ?> 