<?php

namespace WebCaravel\Admin\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use WebCaravel\Admin\Helper\StubHelper;

class CreateResourceCommand extends Command
{
    protected $signature = 'caravel-admin:make-resource {name}';
    protected $description = 'Generates all files for a new resource';
    private string $basepath;
    private array $data;
    private string $stubPath;


    public function handle()
    {
        // Input data
        $name = $this->argument("name");
        $model = $this->ask("model", '\\App\\Models\\'.$name);
        $icon = $this->ask("icon", 'fas fa-file');
        $label = $this->ask("label", Str::headline($name));
        $labelPlural = $this->ask("label plural", Str::plural($label));

        // Caclulate data
        $this->stubPath = __DIR__ . "/../../../stubs/Resources";
        $this->basepath = app_path("CaravelAdmin/Resources") . "/" . $name;
        $this->data = [
            "name" => $name,
            "model" => $model,
            "icon" => $icon,
            "label" => $label,
            "labelPlural" => $labelPlural,
        ];

        // Create dir
        $this->info("Generating $name classes");
        @mkdir($this->basepath, 0777);

        // Make classes
        $this->makeFile("Resource", $name);
        $this->makeFile("Form", $name);
        $this->makeFile("Table", $name);

        // Info
        $this->line("");
        $this->info("Please add route to your route file:");
        $this->line("\\App\CaravelAdmin\\Resources\\" . $name . "\\" . $name . "Resource::routes();");
        $this->line("");
        $this->info("Please add navipoint to your sidebar:");
        $this->line("\\App\CaravelAdmin\\Resources\\" . $name . "\\" . $name . "Resource::make()->sidebar()");
    }


    private function makeFile(string $type, string $name)
    {
        if(!is_file($this->basepath . "/" . $name . $type . ".php") || ($this->ask("File " . $name . $type . " already exists. Overwrite n/y", "n") == "y")) {
            StubHelper::make($this->stubPath."/". $type . ".php.stub", $this->data)->save($this->basepath . "/", $name . $type . ".php");
            $this->line("- " . $type . " created (" . $this->basepath . "/", $name . $type . ".php)");
        }
    }
}
