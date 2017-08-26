<?php

/**
 * Section
 *
 * @package GrottoPress\Jentil\Setup\Customizer
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup\Customizer;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

use \WP_Customize_Manager as WP_Customizer;

/**
 * Section
 *
 * @since 0.1.0
 */
abstract class Section {
    /**
     * Customizer
     *
     * @since 0.1.0
     * @access protected
     * 
     * @var \GrottoPress\Jentil\Setup\Customizer\Customizer $customizer Customizer.
     */
    protected $customizer;

    /**
     * Section name
     *
     * @since 0.1.0
     * @access protected
     * 
     * @var string $name Section name.
     */
    protected $name;

    /**
     * Section arguments
     *
     * @since 0.1.0
     * @access protected
     * 
     * @var array $args Section arguments.
     */
    protected $args;
    
    /**
     * Constructor
     *
     * @var GrottoPress\Jentil\Setup\Customizer\Customizer $customizer Customizer.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct( Customizer $customizer ) {
        $this->customizer = $customizer;
    }

    /**
     * Customizer
     *
     * @since 0.1.0
     * @access public
     *
     * @return GrottoPress\Jentil\Setup\Customizer\Customizer Customizer.
     */
    final public function customizer(): Customizer {
        return $this->customizer;
    }

    /**
     * Name
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Name.
     */
    final public function name(): string {
        return $this->name;
    }

    /**
     * Get settings
     *
     * @since 0.1.0
     * @access protected
     *
     * @return array Settings.
     */
    abstract protected function settings(): array;

    /**
     * Add section
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    final public function add( WP_Customizer $wp_customize ) {
        if ( ! $this->name ) {
            return;
        }

        $wp_customize->add_section( $this->name, $this->args );

        if ( ! ( $settings = $this->settings() ) ) {
            return;
        }

        foreach ( $settings as $setting ) {
            $setting->add( $wp_customize );
        }
    }
}