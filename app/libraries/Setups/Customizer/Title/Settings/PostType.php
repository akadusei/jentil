<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Title\Settings;

use GrottoPress\Jentil\Setups\Customizer\Title\Title;
use WP_Post_Type;

final class PostType extends AbstractSetting
{
    public function __construct(Title $title, WP_Post_Type $post_type)
    {
        parent::__construct($title);

        $mod_context = (
            'post' === $post_type->name ? 'home' : 'post_type_archive'
        );

        $this->themeMod = $this->themeMod([
            'context' => $mod_context,
            'specific' => $post_type->name,
        ]);

        $this->id = $this->themeMod->id;

        $this->args['default'] = $this->themeMod->default;

        $this->control['active_callback'] = function () use ($post_type): bool {
            $page = $this->section->customizer->app->utilities
                ->page;

            if ('post' === $post_type->name) {
                return $page->is('home');
            }

            return $page->is('post_type_archive', $post_type->name);
        };

        $this->control['label'] = \sprintf(\esc_html__('%s Archive', 'jentil'), $post_type->labels->name);
    }
}
