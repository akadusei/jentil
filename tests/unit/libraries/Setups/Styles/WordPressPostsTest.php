<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\Styles;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Setups\Styles\WordPressPosts;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\FileSystem;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class WordPressPostsTest extends AbstractTestCase
{
    public function testEnqueue()
    {
        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);
        $jentil->utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'dir' => 'http://my.url/dist/styles/posts.css'
        ]);

        $style = new WordPressPosts($jentil);

        $enqueue = FunctionMocker::replace('wp_enqueue_style');

        $style->enqueue();

        $enqueue->wasCalledOnce();
        $enqueue->wasCalledWithOnce([
            'wordpress-posts',
            'http://my.url/dist/styles/posts.css',
            ['normalize'],
        ]);
    }
}
