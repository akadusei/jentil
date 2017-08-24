<?php

/**
 * Title Section
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Title
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup\Customizer\Title;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Setup\Customizer\Section;
use GrottoPress\Jentil\Setup\Customizer\Customizer;

/**
 * Title Section
 *
 * @since 0.1.0
 */
final class Title extends Section {
    /**
     * Constructor
     *
     * @var GrottoPress\Jentil\Setup\Customizer\Customizer $customizer Customizer.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct( Customizer $customizer ) {
        parent::__construct( $customizer );

        $this->name = 'title';
        $this->args = [
            'title' => \esc_html__( 'Title', 'jentil' ),
            // 'description' => \esc_html__( 'Description here', 'jentil' ),
        ];
    }

    /**
     * Get settings
     *
     * @since 0.1.0
     * @access protected
     *
     * @return array Settings.
     */
    protected function settings(): array {
        $settings = [];

        $settings['author'] = new Settings\Author( $this );
        $settings['date'] = new Settings\Date( $this );
        $settings['error_404'] = new Settings\Error_404( $this );
        $settings['search'] = new Settings\Search( $this );

        if ( ( $taxonomies = $this->customizer->taxonomies() ) ) {
            foreach ( $taxonomies as $taxonomy ) {
                $settings[ 'taxonomy_' . $taxonomy->name ] = new Settings\Taxonomy( $this, $taxonomy );
            }
        }

        if ( ( $post_types = $this->customizer->archive_post_types() ) ) {
            foreach ( $post_types as $post_type ) {
                $settings[ 'post_type_' . $post_type->name ] = new Settings\Post_Type( $this, $post_type );
            }
        }

        return $settings;
    }
}