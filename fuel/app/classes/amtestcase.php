<?php

// AspectMock\Testとしてインポート
use AspectMock\Test as test;

abstract class AmTestCase extends \Fuel\Core\TestCase
{
    protected function tearDown()
    {
        test::clean(); //登録したMockをすべて削除
    }
}
