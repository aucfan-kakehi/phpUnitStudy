<?php

class Controller_Weather extends \Fuel\Core\Controller_Rest
{
    public function get_today()
    {
        $location = Input::get('loc');
        $weather = 'fine';

        $this->response(array(
            'location' => $location,
            'weather' => $weather,
        ));
    }
}