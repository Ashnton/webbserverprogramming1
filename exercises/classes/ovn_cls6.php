<?php

class Ball
{
    // Properties
    private $color;
    private $radius;

    // Methods
    public function __construct($color, $radius)
    {
        $this->color = $color;
        $this->radius = $radius;
    }

    public function get_ball_color()
    {
        return $this->color;
    }
    public function get_ball_radius()
    {
        return $this->radius;
    }

    public function get_ball()
    {
        return $this;
    }
}

class BallMaterial extends Ball
{
    // Properties
    private $ball_material;

    public function __construct($color, $radius, $ball_material)
    {
        parent::__construct($color, $radius);
        $this->ball_material = $ball_material;
    }

    public function get_ball_material()
    {
        return [$this->ball_material];
    }

    public function get_ball()
    {
        return $this;
    }
}

class BallWeight extends BallMaterial
{
    // Properties
    private $ball_weight;

    public function __construct($color, $radius, $ball_material, $ball_weight)
    {
        parent::__construct($color, $radius, $ball_material);
        $this->ball_weight = $ball_weight;
    }
    public function get_ball_weight()
    {
        return [$this->ball_weight];
    }

    public function get_ball()
    {
        return $this;
    }
}



$ball1 = new BallWeight("red", "12", "stål", "2000");

$ball2 = new BallWeight("blue", "12", "gummi", "100");

$ball3 = new BallWeight("red", "12", "tyg", "10");

$balls = [$ball1->get_ball(), $ball2->get_ball(), $ball3->get_ball()];
print_r($balls);