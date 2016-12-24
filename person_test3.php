<?php
require __DIR__ . "/person.php";

class Person_Test3 extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider provider_人データ
     */
    public function test_設定した性別は取得した性別と一致する($name, $gender, $birthdate)
    {
        fwrite(STDOUT, __METHOD__ . "\n");


        $person = new Person($name, $gender, $birthdate);

        $test = $person->get_gender();
        $expected = $gender;

        $this->assertEquals($expected, $test);
    }

    public function provider_人データ()
    {
        fwrite(STDOUT, __METHOD__ . "\n");


        return array(
            ["Rintaro", "male", "1991/12/14"],
            ["Mayuri", "female", "1994/2/1"],
            ["Suzuha", "female", "2007/9/27"],
        );
    }

}