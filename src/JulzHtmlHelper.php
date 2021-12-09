<?php

declare(strict_types=1);

namespace NSPaloHtmlHelper;

final class JulzHtmlHelper
{
    private const REGEX_HTML_TAGS = '/(<.+?>)/';

    public function findByTextAndReturnWithTags(string $htmlContent, string $searchFor): string
    {
        /**
         * Parse each html and text into one array element
         */
        $parseContent = \preg_split(self::REGEX_HTML_TAGS, $htmlContent, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

        /**
         * Test search to see if the word can be found in one of the array element
         */
        $searchFoundAtIndex = \array_search($searchFor, $parseContent, true);

        /**
         * If nothing was found, it means, the word must be part of a string.
         */
        if ($searchFoundAtIndex === false) {
            $regex = '/' . $searchFor .'/i';

            /**
             * Search for the word in the one of the array element as a string
             * and return the index where the word was found
             */
            $searchFoundAtIndex  = \array_key_first(\preg_grep($regex, $parseContent));

            /**
             * Using the index, extract word from the string
             */
            \preg_match($regex, $parseContent[$searchFoundAtIndex], $extractedText);

            /**
             * Replace the string with the extracted word
             */
            $parseContent = \array_replace($parseContent, [$searchFoundAtIndex => \array_shift($extractedText)]);
        }

        /**
         * Early return if it's the only element
         */
        if (\count($parseContent) === 1) {
            return $parseContent[$searchFoundAtIndex];
        }

        /**
         * Extract the word and the adjacent element; one element before and after
         */
        $rawContent = \array_splice( $parseContent, $searchFoundAtIndex - 1, 3);

        /**
         * If the adjacent element is not the first element,
         * then prepend & append the first and last element
         */
        if ($searchFoundAtIndex - 1 !== 0) {
            \array_unshift($rawContent , $parseContent[\array_key_first($parseContent)]);
            $rawContent[] = $parseContent[\array_key_last($parseContent)];
        }

        /**
         * Make it a string
         */
        return \implode($rawContent);
    }
}