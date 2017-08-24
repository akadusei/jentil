<?php

/**
 * Single Posts Template
 *
 * @package GrottoPress\Jentil
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

if ( ! \defined( 'WPINC' ) ) {
    die;
}

/**
 * Include header template
 *
 * @since 0.1.0
 */
\get_template_part( 'src/includes/partials/header' );

\the_post(); ?>

<div class="posts-wrap show-content big singular-post">
	<article data-post-id="<?php \the_ID(); ?>" id="post-<?php \the_ID(); ?>" <?php \post_class( [ 'post-wrap' ] ); ?> itemscope itemtype="http://schema.org/Article">

		<?php if ( $post->post_title ) { ?>

			<header class="p">

		<?php }

			/**
			 * @action jentil_before_title
			 *
			 * @since 0.1.0
			 */
			\do_action( 'jentil_before_title' );

			\the_title( '<h1 class="entry-title" itemprop="name headline mainEntityOfPage">', '</h1>' );
			
			\rewind_posts();
			
			/**
			 * @action jentil_after_title
			 *
			 * @since 0.1.0
			 */
 			\do_action( 'jentil_after_title' );

 		if ( $post->post_title ) { ?>
	 		
			</header>

		<?php }
		
		/**
		 * @action jentil_before_content
		 *
		 * @since 0.1.0
		 */
	 	\do_action( 'jentil_before_content' );

	 	\the_post(); ?>
		
		<div class="entry-content self-clear" itemprop="articleBody">

			<?php \the_content();

			\wp_link_pages( [
				'before' => '<nav class="page-links pagination p">'
					. \esc_html__( 'Pages: ', 'jentil' ),
				'after' => '</nav>',
			] ); ?>
			
		</div><!-- .entry-content -->

		<?php
		/**
		 * @action jentil_after_content
		 *
		 * @since 0.1.0
		 */
		\do_action( 'jentil_after_content' ); ?>

	</article>
</div>

<?php \rewind_posts();

/**
 * Include footer template
 *
 * @since 0.1.0
 */
\get_template_part( 'src/includes/partials/footer' );