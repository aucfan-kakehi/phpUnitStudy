<?php
//ソースファイルの文字エンコーディングがutf8なら、日本語でも大丈夫



//
class Person_Test extends PHPUnit_Framework_TestCase
{
    public function test_男性簿場合は性別を取得するとmaleである()
    {
        $person = new Person('Rintaro', 'male', '1991/12/14');

        $test = $person->get_gender();
        $expected = 'male';

        $this->assertEquals($expected, $test);
    }

}
