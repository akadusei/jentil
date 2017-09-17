<?php

/**
 * Section
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Posts
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup\Customizer\Posts;

use GrottoPress\Jentil\Setup\Customizer\Section as C_Section;

/**
 * Section
 *
 * @since 0.1.0
 */
abstract class Section extends C_Section
{
    /**
     * Constructor
     *
     * @since 0.1.0
     * @access protected
     *
     * @var array $mod_args Mod args.
     */
    protected $mod_args;

     /**
     * Constructor
     *
     * @param Posts $posts Posts.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Posts $posts)
    {
        $this->posts = $posts;

        parent::__construct($this->posts->customizer());

        $this->args = [
            'title' => \esc_html__('Posts', 'jentil'),
            'panel' => $this->posts->name(),
        ];

        $this->mod_args = [
            'context' => '',
            'specific' => '',
            'more_specific' => '',
        ];
    }

    /**
     * Posts
     *
     * @since 0.1.0
     * @access public
     *
     * @return Posts Posts.
     */
    final public function posts(): Posts
    {
        return $this->posts;
    }

    /**
     * Mod args
     *
     * @since 0.1.0
     * @access public
     *
     * @return array Mod args.
     */
    final public function modArgs(): array
    {
        return $this->mod_args;
    }

    /**
     * Get settings
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function settings(): array
    {
        $settings = [];

        $settings['wrap_class'] = new Settings\WrapClass($this);
        // $settings['wrap_tag'] = new Settings\WrapTag($this);
        // $settings['layout'] = new Settings\Layout($this);
        $settings['before_title'] = new Settings\BeforeTitle($this);
        $settings['before_title_separator'] =
            new Settings\BeforeTitleSeparator($this);
        $settings['title_words'] = new Settings\TitleWords($this);
        $settings['title_position'] = new Settings\TitlePosition($this);
        $settings['after_title'] = new Settings\AfterTitle($this);
        $settings['after_title_separator'] =
            new Settings\AfterTitleSeparator($this);
        $settings['image'] = new Settings\Image($this);
        $settings['image_alignment'] = new Settings\ImageAlignment($this);
        $settings['image_margin'] = new Settings\ImageMargin($this);
        $settings['text_offset'] = new Settings\TextOffset($this);
        $settings['excerpt'] = new Settings\Excerpt($this);
        $settings['more_link'] = new Settings\MoreText($this);
        $settings['after_content'] = new Settings\AfterContent($this);
        $settings['after_content_separator'] =
            new Settings\AfterContentSeparator($this);
        
        return $settings;
    }
}
