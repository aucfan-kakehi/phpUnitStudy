<?php
require "/Users/kakehi/zisyu/fuelphpStudy/fuel/app/person.php";

/**
 * Person class Tests
 *
 * @group App
 */

class person_Test extends \Fuel\Core\TestCase
{
    public function test_男性簿場合は性別を取得するとmaleである()
    {
        $person = new Person('Rintaro', 'male', '1991/12/14');

        $test = $person->get_gender();
        $expected = 'male';

        $this->assertEquals($expected, $test);
    }

}