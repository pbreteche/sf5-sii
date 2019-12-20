<?php


namespace App\Service;


use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SearchExpressionParser
{
    public const LABELS = ['title', 'after', 'before'];

    /**
     * @return string[]
     */
    public function parse(string $expression)
    {
        $criteriaStrings = explode(' ', $expression);

        $result = [];
        foreach ($criteriaStrings as &$criteriaString) {
            if (false === strpos($criteriaString, ':')) {
                $criteriaString = 'title:'.$criteriaString;
            }

            if (preg_match('/(?<label>[^:]+):(?<term>[^:]+)/', $criteriaString, $matches)) {
                dump($matches);
                if (!in_array($matches['label'], self::LABELS)) {
                    throw new BadRequestHttpException('Critère '.$matches['label'].' inconnu');
                }
                $result[] = $matches;
            }
        }
        return $result;
    }
}