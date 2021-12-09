<?php

declare(strict_types=1);

namespace Tests\NSPaloHtmlHelper;

use NSPaloHtmlHelper\JulzHtmlHelper;
use PHPUnit\Framework\TestCase;

final class JulsHtmlHelperTest extends TestCase
{
    /**
     * @return iterable<string, mixed>
     */
    public function getTestData(): iterable
    {
        yield 'Html String 0' => [
            'one two three',
            'one',
            'one',
        ];

        yield 'Html String 1' => [
            '<p>one two three</p>',
            'two',
            '<p>two</p>',
        ];

        yield 'Html String 2' => [
            '<div><p>one two three</p></div>',
            'three',
            '<div><p>three</p></div>',
        ];

        yield 'Html String 3' => [
            '<div><p>one</p><p>two</p><p>three</p></div>',
            'two',
            '<div><p>two</p></div>',
        ];

        yield 'Html String 4' => [
            '<div><p>one</p><p>two three</p><p>four and five</p></div>',
            'four',
            '<div><p>four</p></div>',
        ];

        yield 'Html String 5' => [
            '<div><p>one</p><p>two<p>three</p></p><p>four and five</p></div>',
            'three',
            '<div><p>three</p></div>',
        ];
    }

    /**
     * @dataProvider getTestData
     */
    public function testFind(string $htmlString, string $search, string $expected): void
    {
        $htmlHelper = new JulzHtmlHelper();
        $result = $htmlHelper->findByTextAndReturnWithTags($htmlString, $search);

        self::assertSame($expected, $result);
    }
}