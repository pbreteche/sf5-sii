<?php


namespace App\Service;


class SearchExpressionParser
{


    public function parse(string $expression)
    {
        return explode(' ', $expression);
    }
}