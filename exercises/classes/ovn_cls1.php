<?php

class Ball
{
    // Properties
    public $color;
    public $radius;

    // Methods
    function set_ball($color, $radius)
    {
        $this->color = $color;
        $this->radius = $radius;
    }

    function get_ball()
    {
        return [$this->color, $this->radius];
    }
}


$my_ball = new Ball();
$my_ball->set_ball("red", "12");
print_r($my_ball->get_ball());
