<?php
use AspectMock\Test as test;

/**
 * Controller Form Class Tests
 *
 * @group AppController
 */
class controller_form_test extends AmTestCase
{
    //アクションをgetするとコンタクトフォームページが返る
    public function test_index()
    {
        //HMVCリクエストを生成
        $request = Request::forge('form/index');
        //リクエストを実行し、レスポンスを取得
        $response = $request->execute()->response();

        //HTTPステータスコードのテスト
        $status = $response->status;
        $expected = 200;
        $this->assertEquals($expected, $status);

        //titleのテスト
        $title = $response->body->title;
        $expected = 'コンタクトフォーム';
        $this->assertEquals($expected, $title);

        //HTMLのテスト
        $body = $response->body()->render();
        $pattern = '/' . preg_quote('お問い合わせ'. '/') . '/u';
        $this->assertRegExp($pattern, $body);
    }


}