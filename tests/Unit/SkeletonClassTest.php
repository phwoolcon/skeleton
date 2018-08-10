<?php

namespace Phwoolcon\Skeleton;

use League\Skeleton\SkeletonClass;
use Phwoolcon\TestStarter\TestCase;

class SkeletonClassTest extends TestCase
{

    public function testEchoPhrase()
    {
        $this->assertEquals($text = 'foo', (new SkeletonClass())->echoPhrase($text));
    }
}
