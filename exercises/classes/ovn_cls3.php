<?php

class Ball
{
    // Properties
    private $color;
    private $radius;

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


$ball1 = new Ball();
$ball1->set_ball("red", "12");

$ball2 = new Ball();
$ball2->set_ball("blue", "12");

$ball3 = new Ball();
$ball3->set_ball("green", "12");

$balls = [$ball1->get_ball(), $ball2->get_ball(), $ball3->get_ball()];
print_r($balls);
