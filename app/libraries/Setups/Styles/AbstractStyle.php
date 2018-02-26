<?php

/**
 * Abstract Stylesheet
 *
 * @package GrottoPress\Jentil\Setups\Styles
 * @since 0.6.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Styles;

use GrottoPress\Jentil\Setups\AbstractSetup;

/**
 * Abstract Stylesheet
 *
 * @since 0.6.0
 */
abstract class AbstractStyle extends AbstractSetup
{
    /**
     * ID
     *
     * @since 0.6.0
     * @access protected
     *
     * @var string
     */
    protected $id;

    /**
     * Get ID
     *
     * @since 0.6.0
     * @access protected
     */
    protected function getID(): string
    {
        return $this->id;
    }

    /**
     * Run setup
     *
     * @since 0.6.0
     * @access public
     */
    public function run()
    {
        \add_action('wp_enqueue_scripts', [$this, 'enqueue']);
    }

    /**
     * Enqueue/dequeue stylesheet
     *
     * @since 0.6.0
     * @access public
     *
     * @action wp_enqueue_scripts
     */
    abstract public function enqueue();
}
