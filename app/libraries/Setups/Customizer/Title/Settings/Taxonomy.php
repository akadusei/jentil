<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Title\Settings;

use GrottoPress\Jentil\Setups\Customizer\Title\Title;
use GrottoPress\Jentil\Utilities\ThemeMods\Title as TitleMod;
use WP_Taxonomy;
use WP_Term;

final class Taxonomy extends AbstractSetting
{
    public function __construct(
        Title $title,
        WP_Taxonomy $taxonomy,
        WP_Term $term = null
    ) {
        parent::__construct($title);

        $theme_mod = $this->getThemeMod($taxonomy, $term);

        $this->id = $theme_mod->id;

        $this->args['default'] = $theme_mod->default;

        $this->setControl($taxonomy, $term);
    }

    private function getThemeMod(
        WP_Taxonomy $taxonomy,
        WP_Term $term = null
    ): TitleMod {
        $mod_context = 'tax';

        if ('post_tag' === $taxonomy->name) {
            $mod_context = 'tag';
        } elseif ('category' === $taxonomy->name) {
            $mod_context = 'category';
        }

        if ($term) {
            return $this->themeMod([
                'context' => $mod_context,
                'specific' => $taxonomy->name,
                'more_specific' => $term->term_id,
            ]);
        }

        return $this->themeMod([
            'context' => $mod_context,
            'specific' => $taxonomy->name
        ]);
    }

    private function setControl(WP_Taxonomy $taxonomy, WP_Term $term = null)
    {
        $this->control['active_callback'] = function () use (
            $taxonomy,
            $term
        ): bool {
            $page = $this->customizer->app->utilities->page;

            if ($term) {
                return (
                    $page->is('tag', $term->term_id) ||
                    $page->is('category', $term->term_id) ||
                    $page->is('tax', $taxonomy, $term->term_id)
                );
            }

            if ('post_tag' === $taxonomy->name) {
                return $page->is('tag');
            }

            if ('category' === $taxonomy->name) {
                return $page->is('category');
            }

            return $page->is('tax', $taxonomy->name);
        };

        if ($term) {
            $this->control['label'] = \sprintf(\esc_html__(
                '%1$s Archive: %2$s',
                'jentil'
            ), $taxonomy->labels->singular_name, $term->name);
        } else {
            $this->control['label'] = \sprintf(\esc_html__(
                '%1$s Archives',
                'jentil'
            ), $taxonomy->labels->singular_name);
        }
    }
}
