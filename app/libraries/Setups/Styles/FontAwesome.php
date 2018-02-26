<?php

/**
 * Normalize CSS
 *
 * @package GrottoPress\Jentil\Setups\Styles
 * @since 0.6.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Styles;

/**
 * Normalize CSS
 *
 * @since 0.6.0
 */
final class FontAwesome extends AbstractStyle
{
    /**
     * Enqueue Stylesheet
     *
     * @since 0.6.0
     * @access public
     *
     * @action wp_enqueue_scripts
     */
    public function enqueue()
    {
        $this->id = 'font-awesome';

        \wp_enqueue_style(
            $this->id,
            $this->app->utilities->fileSystem->dir(
                'url',
                '/assets/vendor/font-awesome/css/font-awesome.min.css'
            ),
            ['normalize']
        );
    }
}
