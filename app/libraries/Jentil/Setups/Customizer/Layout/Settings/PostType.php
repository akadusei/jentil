<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Layout\Settings;

use GrottoPress\Jentil\Setups\Customizer\Layout;
use WP_Post_Type;

final class PostType extends AbstractSetting
{
    public function __construct(Layout $layout, WP_Post_Type $post_type)
    {
        parent::__construct($layout);

        $mod_context = (
            'post' === $post_type->name ? 'home' : 'post_type_archive'
        );

        $theme_mod = $this->themeMod([
            'context' => $mod_context,
            'specific' => $post_type->name,
        ]);

        $this->id = $theme_mod->id;

        $this->args['default'] = $theme_mod->default;
    }
}
