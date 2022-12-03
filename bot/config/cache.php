<?php

class Cache
{
    private $host = "127.0.0.1";
    private $port = 11211;

    public function getConnection(): Memcache
    {
        $memcache = new Memcache();

        $memcache->connect($this->host, $this->port);
        return $memcache;
    }
}


