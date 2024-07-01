<?php
get_template_part('head');
?>

	<main id="primary" class="site-main main-404">
		<div class="site-width-centered main-404__inner">
			<section>
				<header>
					<h1><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'bareshelves' ); ?></h1>
				</header>

				<div>
					<p><?php esc_html_e( 'It looks like nothing was found at this location.', 'bareshelves' ); ?></p>
				</div>
			</section>
		</div>
	</main>

<?php
get_footer();
