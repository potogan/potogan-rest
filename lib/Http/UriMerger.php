<?php

namespace Potogan\REST\Http;

use Psr\Http\Message\UriInterface;

class UriMerger
{
    /**
     * Merges an uri into another one, resolving relative path if needed.
     *
     * @param UriInterface $uri
     * @param mixed        $merge (any type castable to a string)
     * 
     * @return UriInterface
     */
    public function merge(UriInterface $uri, $merge)
    {
        $parts = parse_url((string)$merge);

        if (isset($parts['scheme'])) {
            $uri = $uri->withScheme($parts['scheme']);
        }

        if (isset($parts['user'])) {
            $uri = $uri->withUserInfo(
                $parts['user'],
                isset($parts['pass']) ? $parts['pass'] : null
            );
        }

        if (isset($parts['host'])) {
            $uri = $uri
                ->withHost($parts['host'])
                ->withPort(isset($parts['port']) ? $parts['port'] : null)
            ;
        }

        if (isset($parts['path'])) {
            if (substr($parts['path'], 0, 1) === '/') {
                $uri = $uri->withPath($parts['path']);
            } else {
                $uri = $uri->withPath(rtrim(dirname($uri->getPath() . 'a'), '/') . '/' . $parts['path']);
            }
        }

        $uri = $uri
            ->withQuery(isset($parts['query']) ? $parts['query'] : '')
            ->withFragment(isset($parts['fragment']) ? $parts['fragment'] : '')
        ;

        return $uri;
    }
}
