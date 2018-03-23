<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Layout\Settings;

use GrottoPress\Jentil\Setups\Customizer\Layout\Layout;

final class Author extends AbstractSetting
{
    public function __construct(Layout $layout)
    {
        parent::__construct($layout);

        $this->themeMod = $this->themeMod(['context' => 'author']);

        $this->id = $this->themeMod->id;

        $this->args['default'] = $this->themeMod->default;

        $this->control['active_callback'] = function (): bool {
            return $this->section->customizer->app->utilities
                ->page->is('author');
        };

        $this->control['label'] = \esc_html__('Author Archives', 'jentil');
    }
}
