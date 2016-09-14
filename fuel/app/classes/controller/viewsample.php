<?php

class Controller_ViewSample extends Controller
{
    public function action_index()
    {
        $data = array();
/*
        $data['title'] = 'ビューのサンプル';
        $data['username'] = 'Ritsu';
        return View::forge('viewsample',$data);
*/
        $view = View::forge('viewsample',$data);
        $view ->set('title', 'ビューのサンプル2');
        $view ->set_safe('username', '<del>Azunyan</del>Azusan');
        return $view;
    }
}

