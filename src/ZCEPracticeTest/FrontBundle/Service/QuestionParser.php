<?php

/**
 *
 *
 * PHP version 5.5
 *
 * @category Listener
 * @package  FrontBundle
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 *
 */
namespace ZCEPracticeTest\FrontBundle\Service;

class QuestionParser
{
    /**
     * Parse questions collection to json
     * @param $questions
     * @return string
     */
    public function parseToJson ($questions)
    {
        $json = array();

        foreach ($questions as $question) {
            $json[] = $question->jsonSerialize();
        }

        return json_encode($json);
    }
}