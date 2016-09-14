<?php

class Model_Status extends Model
{
    public static function find_body_by_username($username)
    {
        $data = array(
            array(
                'date' => '2016/09/11 15:02',
                'body' => '新入居者歓迎会ウィル',
            ),
            array(
                'date' => '2016/09/18 15:02',
                'body' => '君の名はなう',
            ),
        );
        return $data;
    }
}
