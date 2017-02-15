<?php

/**
 * Content 'previous pagination label' setting
 *
 * Add setting and control for our content 'previous pagination label'
 * setting in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Content\Settings;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup;

/**
 * Content 'previous pagination label' setting
 *
 * Add setting and control for our content 'previous pagination label'
 * setting in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class Pagination_Previous_Label extends Setup\Customizer\Setting {
    /**
     * Content section
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var     \GrottoPress\Jentil\Setup\Customizer\Content\Content     $content     Content section instance
     */
    private $content;
    
    /**
	 * Constructor
     *
     * @var         object      $content        Instance of section of this setting
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( $content ) {
        $this->content = $content;

        $this->name = $this->content->get( 'name' ) . '_pagination_previous_label';
        
        $this->args = array(
            'default' => ( $this->content->get( 'default' ) )['pagination_previous_label'],
            //'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        );

        $this->control = array(
            'section' => $this->content->get( 'name' ),
            'label' => esc_html__( 'Previous page link label', 'jentil' ),
            'type' => 'text',
        );
	}
}