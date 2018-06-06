<?php

namespace Tests\Traits;

trait Paths
{
    private function projectRoot()
    {
        /* 2 folders up from tests/traits */
        return dirname(dirname(__DIR__));
    }

    private function outputFolder(string $file = null)
    {
        return $this->appendFile(dirname(__DIR__).'/output', $file);
    }

    private function inputFolder(string $file = null)
    {
        return $this->appendFile(dirname(__DIR__).'/input', $file);
    }

    private function expectedFolder(string $file = null)
    {
        return $this->appendFile(dirname(__DIR__).'/expected', $file);
    }

    private function appendFile(string $path, string $file = null)
    {
        if(! is_null($file)) $path .= "/$file";
        return $path;
    }
}
