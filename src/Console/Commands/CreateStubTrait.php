<?php

namespace WebCaravel\Admin\Console\Commands;

use WebCaravel\Admin\Helper\StubHelper;

trait CreateStubTrait
{
    private string $basepath;
    private array $data;
    private string $stubPath;


    protected function init(string $name)
    {
        $this->stubPath = __DIR__ . "/../../../stubs/Resources";
        $this->basepath = app_path("CaravelAdmin/Resources") . "/" . $name;

        $this->info("Generating classes for $name");
        @mkdir($this->basepath, 0777);
    }


    protected function makeFile(string $type, string $filename)
    {
        if(!is_file($this->basepath . "/" . $filename . ".php") || ($this->ask("File " . $filename . " already exists. Overwrite n/y", "n") == "y")) {
            StubHelper::make($this->stubPath."/". $type . ".php.stub", $this->data)->save($this->basepath . "/", $filename . ".php");
            $this->line("- " . $type . " created (" . $this->basepath . "/", $filename . ".php)");
        }
    }
}
