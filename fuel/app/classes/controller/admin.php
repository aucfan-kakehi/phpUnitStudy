<?php

class Controller_Admin extends Controller
{
    public function action_index()
    {
        return Html::anchor(Router::get('admin'), '管理ページ');
    }
}

