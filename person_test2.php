<?php

require __DIR__ . '/person.php';

class Person_Test2 extends PHPUnit_Framework_TestCase
{
//    public static function setUpBeforeClass()
//    {
//        fwrite(STDOUT, __METHOD__ . "\n");
//    }

    public static function setUpBeforeClass()
    {
        fwrite(STDOUT, __METHOD__ . "\n");

        parent::setUpBeforeClass(); // TODO: Change the autogenerated stub
    }


    protected function setUp()
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    }

    public function test_男性場合は性別を取得するとmaleである()
    {
        fwrite(STDOUT, __METHOD__ . "\n");
        $person = new Person('Rintaro', 'male', '1991/12/14');

        $test = $person->get_gender();
        $expected = 'male';

        $this->assertEquals($expected, $test);
    }

    public function test_女性場合は性別を取得するとfemaleである()
    {
        fwrite(STDOUT, __METHOD__ . "\n");
        $person = new Person('Mayuri', 'female', '1991/12/14');

        $test = $person->get_gender();
        $expected = 'female';

        $this->assertEquals($expected, $test);
    }

    protected function tearDown()
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    }


    public static function tearDownAfterClass()
    {
        fwrite(STDOUT, __METHOD__ . "\n");

        parent::tearDownAfterClass(); // TODO: Change the autogenerated stub
    }

}


