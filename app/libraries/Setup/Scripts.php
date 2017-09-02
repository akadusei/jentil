<?php

/**
 * Scripts (JavaScript)
 *
 * @package GrottoPress\Jentil\Setup
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

/**
 * Scripts (JavaScript)
 *
 * @since 0.1.0
 */
final class Scripts extends Setup {
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run() {
        \add_action( 'wp_footer', [ $this, 'enqueue' ] );
        \add_filter( 'body_class', [ $this, 'add_body_classes' ] );
    }
    
    /**
     * Enqueue Styles
     * 
     * @since 0.1.0
     * @access public
     * 
     * @action wp_footer
     */
    public function enqueue() {
        echo '<script type="text/javascript">
            jQuery(function($) {
                $( "body" ).removeClass( "has-js no-js" ).addClass( "has-js" );
            });
        </script>';
    }

    /**
     * Add 'no-js' class to body
     *
     * This should be removed by javascript if
     * javascript is supported by client.
     *
     * @since 0.1.0
     * @access public
     * 
     * @filter body_class
     */
    public function add_body_classes( array $classes ): array {
        if ( ! \in_array( 'no-js', $classes ) ) {
            $classes[] = 'no-js';
        }

        return $classes;
    }
}