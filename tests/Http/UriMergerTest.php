<?php

namespace Potogan\REST\Tests;

use GuzzleHttp\Psr7\Uri;
use PHPUnit_Framework_TestCase;
use Potogan\REST\Http\UriMerger;

class UriMergerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->merger = new UriMerger();
    }

    /**
     * @dataProvider provideMergeSamples
     */
    public function testMerge($uri, $merge, $expected)
    {
        $this->assertEquals(
            $expected,
            (string)$this->merger->merge(
                new Uri($uri),
                $merge
            )
        );
    }

    public function provideMergeSamples()
    {
        return [
            ['http://example.com/', 'test', 'http://example.com/test'],
            ['http://example.com/sub', 'test', 'http://example.com/test'],
            ['http://example.com/sub/', 'test', 'http://example.com/sub/test'],
            ['http://example.com/sub/dir/', '/test', 'http://example.com/test'],
            ['http://example.com/', '#test', 'http://example.com/#test'],
            ['http://example.com/', 'https://other.com', 'https://other.com/'],
            ['http://example.com/', 'https://user:pass@other.com', 'https://user:pass@other.com/'],
            ['http://example.com/', '?test', 'http://example.com/?test'],
            ['http://example.com/?test#anchor', 'sub/', 'http://example.com/sub/'],
            ['http://example.com/some/path?test#anchor', '', 'http://example.com/some/'],
        ];
    }
}
