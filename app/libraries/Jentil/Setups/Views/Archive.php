<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\Jentil\Setups\AbstractSetup;

final class Archive extends AbstractSetup
{
    public function run()
    {
        \add_action('jentil_after_title', [$this, 'renderDescription']);
    }

    /**
     * @action jentil_after_title
     */
    public function renderDescription()
    {
        $page = $this->app->utilities->page;

        if (!$page->is('archive')) {
            return;
        }

        if (!($description = $page->description())) {
            return;
        }

        echo '<div class="archive-description entry-summary" itemprop="description">'.
            $description.
        '</div>';
    }
}
