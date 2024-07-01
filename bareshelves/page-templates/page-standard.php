<?php
/** Template Name: Standard Page Template */

get_template_part('head');
?>

<main id="primary" class="site-main main-standard">
	<div class="site-width-centered main-standard__inner">
		<header class="standard-page__header site-width-centered">
			<?php the_title( '<h1 class="standard-page__title">', '</h1>' ); ?>
		</header>

		<div class="standard-page__content site-width-centered">
			<?php
			the_content();
			?>
		</div>
	</div>
</main>

<?php
get_footer();
