<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class WrapClass extends AbstractSetting
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $themeMod = $this->themeMod('wrap_class');

        $this->id = $themeMod->id;

        $this->args['default'] = $themeMod->default;
        $this->args['sanitize_callback'] = 'sanitize_text_field';

        $this->control['label'] = \esc_html__('Wrapper class', 'jentil');
        $this->control['description'] = \esc_html__(
            'Comma- or space-separated',
            'jentil'
        );
        $this->control['type'] = 'text';
    }
}
