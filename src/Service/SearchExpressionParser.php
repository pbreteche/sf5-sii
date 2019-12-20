<?php


namespace App\Service;


class SearchExpressionParser
{

    /**
     * @return string[]
     */
    public function parse(string $expression)
    {
        return explode(' ', $expression);
    }
}