<?php

namespace Tests\Traits;

trait CleansOutput
{
    use Paths;

    public function setUp()
    {
        $this->cleanOutput();
    }

    protected function cleanOutput()
    {
        $this->removeDirectoryContents($this->outputFolder());
    }

    private function removeDirectoryContents(string $dir, int $level = 1)
    {
        if(! is_dir($dir)) return;
        
        $objects = scandir($dir); 

        foreach ($objects as $object) { 
            if ($object != "." && $object != "..") { 
                if (is_dir($dir."/".$object)) {
                    $this->removeDirectoryContents($dir."/".$object, $level+1);
                }
                else {
                    unlink($dir."/".$object); 
                }
            } 
        }
        if($level > 1) rmdir($dir); 
    }
}
