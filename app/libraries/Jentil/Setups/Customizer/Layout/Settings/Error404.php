<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Layout\Settings;

use GrottoPress\Jentil\Setups\Customizer\Layout;

final class Error404 extends AbstractSetting
{
    public function __construct(Layout $layout)
    {
        parent::__construct($layout);

        $theme_mod = $this->themeMod(['context' => '404']);

        $this->id = $theme_mod->id;

        $this->args['default'] = $theme_mod->default;
    }
}
