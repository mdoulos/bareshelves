<?php defined( 'ABSPATH' ) || exit;
/** Used as the fallback template for any page that doesn't have a template. */
get_template_part('head');
?>

	<main id="primary" class="site-main main-index">
        <div class="site-width-centered main-index__inner">
            <?php
                if ( have_posts() ) {

                    while ( have_posts() ) {
                        the_post();
                    }

                    the_posts_navigation();

                }
            ?>
        </div>
	</main>

<?php
get_footer();