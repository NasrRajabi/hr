<?php

declare(strict_types=1);
namespace App\Application\Actions\Role\Util;

class ColorGenerator 
{
    function random_color_part()
    {
        return str_pad(dechex(mt_rand(210, 255)), 2, '0', STR_PAD_LEFT);
    }

    function random_color()
    {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }
}