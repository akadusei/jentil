<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page;

use GrottoPress\Jentil\Utilities\Page;
use GrottoPress\Jentil\Utilities\ThemeMods\Posts as PostsMod;
use GrottoPress\Getter\GetterTrait;

class Posts
{
    use GetterTrait;

    /**
     * @var Page
     */
    private $page;

    /**
     * @var Posts\Sticky
     */
    private $sticky;

    /**
     * @var Posts\Related
     */
    private $related;

    /**
     * @var Posts\Singular
     */
    private $singular;

    /**
     * @var Posts\Archive
     */
    private $archive;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    private function getPage(): Page
    {
        return $this->page;
    }

    private function getSingular(): Posts\Singular
    {
        $this->singular = $this->singular ?: new Posts\Singular($this);

        return $this->singular;
    }

    private function getSticky(): Posts\Sticky
    {
        $this->sticky = $this->sticky ?: new Posts\Sticky($this);

        return $this->sticky;
    }

    private function getRelated(): Posts\Related
    {
        $this->related = $this->related ?: new Posts\Related($this);

        return $this->related;
    }

    private function getArchive(): Posts\Archive
    {
        $this->archive = $this->archive ?: new Posts\Archive($this);

        return $this->archive;
    }

    public function render(): string
    {
        if ($this->page->is('singular')) {
            return $this->getSingular()->posts()->render();
        }

        $out = '';

        if (!$this->getArchive()->isPaged() &&
            $this->getSticky()->isSet() &&
            $this->getSticky()->get($this->getArchive()->postType())
        ) {
            $out .= $this->getSticky()->posts()->render();
        }

        $out .= $this->getArchive()->posts()->render();

        return $out;
    }

    /**
     * @return \WP_Post_Type[string] Public post types.
     */
    public function postTypes(): array
    {
        return \get_post_types(['public' => true], 'objects');
    }

    /**
     * @return \WP_Taxonomy[string] Public taxonomies.
     */
    public function taxonomies(): array
    {
        return \get_taxonomies(['public' => true], 'objects');
    }

    /**
     * @param mixed[string] $args
     */
    public function themeMod(string $setting, array $args = []): PostsMod
    {
        if (!empty($args['context'])) {
            return $this->page->utilities->themeMods->posts(
                $setting,
                $args
            );
        }

        $page = $this->page->type;

        $specific = '';
        $more_specific = 0;

        foreach ($page as $type) {
            if ('post_type_archive' === $type) {
                $specific = \get_query_var('post_type');
            } elseif ('tax' === $type) {
                $specific = \get_query_var('taxonomy');
            } elseif ('category' === $type) {
                $specific = 'category';
            } elseif ('tag' === $type) {
                $specific = 'post_tag';
            }

            if (\is_array($specific)) {
                $specific = $specific[0];
            }

            if (\is_array($more_specific)) {
                $more_specific = $more_specific[0];
            }

            $mod = $this->page->utilities->themeMods->posts($setting, [
                'context' => $type,
                'specific' => $specific,
                'more_specific' => $more_specific,
            ]);

            if ($mod->id) {
                return $mod;
            }
        }

        return $mod;
    }

    /**
     * @return string[string]
     */
    public function imageSizes(): array
    {
        $sizes = \wp_get_additional_image_sizes();

        $return = [];

        foreach ($sizes as $id => $atrr) {
            $return[$id] = "{$id} ({$atrr['width']} x {$atrr['height']})";
        }

        return $return;
    }
}
