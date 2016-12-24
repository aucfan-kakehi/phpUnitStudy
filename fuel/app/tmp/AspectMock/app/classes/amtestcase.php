<?php

// AspectMock\Testとしてインポート
use AspectMock\Test as test;

abstract class AmTestCase extends \Fuel\Core\TestCase
{
    protected function tearDown()
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
        test::clean(); //登録したMockをすべて削除
    }
}
