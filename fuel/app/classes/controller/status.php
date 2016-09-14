<?php

class Controller_Status extends Controller
{
    public function action_index()
    {
        //Statusモデルから結果を取得する
        $results = Model_Status::find_body_by_username('foo');

        //$resultsをダンプして管区人s塗る
        Debug::dump($results);
    }
}