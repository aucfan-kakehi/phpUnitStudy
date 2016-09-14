<?php

class Controller_RoutingTest extends \Fuel\Core\Controller
{
    public function router($resource, $arguments)
    {
        //ルート情報を表示
        Debug::dump($this->request->route);
        //名前付きパラメータの一覧を表示
        Debug::dump($this->params());
    }
}