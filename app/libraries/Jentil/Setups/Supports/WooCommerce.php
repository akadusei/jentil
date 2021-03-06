<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Supports;

use GrottoPress\Jentil\Setups\AbstractSetup;
use WooCommerce as WooCommercePlugin;
use WC_Template_Loader as WooCommerceLoader;
use WP_Customize_Manager as WPCustomizer;

final class WooCommerce extends AbstractSetup
{
    public function run()
    {
        \add_action('after_setup_theme', [$this, 'loadComments']);
        \add_action('customize_register', [$this, 'removeCustomizerItems'], 20);
        \add_action('wp', [$this, 'removeSingularViews']);
    }

    /**
     * @action after_setup_theme
     */
    public function loadComments()
    {
        if (!\class_exists(WooCommerceLoader::class)) {
            return;
        }

        \add_filter(
            'comments_template',
            [WooCommerceLoader::class, 'comments_template_loader']
        );
    }

    /**
     * @action customize_register
     */
    public function removeCustomizerItems(WPCustomizer $wp_customizer)
    {
        if (!\class_exists(WooCommercePlugin::class)) {
            return;
        }

        $taxes = ['product_tag', 'product_cat'];
        $shop_page = (int)\get_option('woocommerce_shop_page_id');

        $related_page_active_cb = $this->app->setups['Customizer']
            ->panels['Posts']->sections['Related_page']
            ->get($wp_customizer)->active_callback;

        $single_page_active_cb = $this->app->setups['Customizer']
            ->panels['Posts']->sections['Singular_page']
            ->get($wp_customizer)->active_callback;

        \array_walk(
            $taxes,
            function (string $tax, int $i) use ($wp_customizer) {
                $this->app->setups['Customizer']
                    ->panels['Posts']->sections["Taxonomy_{$tax}"]
                    ->remove($wp_customizer);

                $this->app->setups['Customizer']
                    ->sections['Title']->settings["Taxonomy_{$tax}"]
                    ->remove($wp_customizer);
            }
        );

        $this->app->setups['Customizer']
            ->panels['Posts']->sections['Related_product']
            ->remove($wp_customizer);

        $this->app->setups['Customizer']
            ->panels['Posts']->sections['Singular_product']
            ->remove($wp_customizer);

        $this->app->setups['Customizer']
            ->panels['Posts']->sections['Singular_page']
            ->get($wp_customizer)->active_callback =
                function () use ($shop_page, $single_page_active_cb): bool {
                    return (
                        !$this->app->utilities->page->is('page', $shop_page) && (bool)$single_page_active_cb()
                    );
                };

        $this->app->setups['Customizer']
            ->panels['Posts']->sections['Related_page']
            ->get($wp_customizer)->active_callback =
                function () use ($shop_page, $related_page_active_cb): bool {
                    return (
                        !$this->app->utilities->page->is('page', $shop_page) && (bool)$related_page_active_cb()
                    );
                };
    }

    /**
     * @action wp
     */
    public function removeSingularViews()
    {
        if (!\class_exists(WooCommercePlugin::class)) {
            return;
        }

        $shop_page = (int)\get_option('woocommerce_shop_page_id');

        if (!$this->app->utilities->page->is('singular', 'product') &&
            !$this->app->utilities->page->is('page', $shop_page)
        ) {
            return;
        }

        \remove_action(
            'jentil_before_title',
            [$this->app->setups['Views\Singular'], 'renderPostsBeforeTitle']
        );

        \remove_action(
            'jentil_after_title',
            [$this->app->setups['Views\Singular'], 'renderPostsAfterTitle']
        );

        \remove_action(
            'jentil_after_content',
            [$this->app->setups['Views\Singular'], 'renderPostsAfterContent']
        );

        \remove_action(
            'jentil_after_content',
            [$this->app->setups['Views\Singular'], 'renderRelatedPosts']
        );
    }
}
