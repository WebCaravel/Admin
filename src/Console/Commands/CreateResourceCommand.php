<?php

namespace WebCaravel\Admin\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use WebCaravel\Admin\Helper\StubHelper;

class CreateResourceCommand extends Command
{
    use CreateStubTrait;

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

        // Init
        $this->init($name);

        // Caclulate data
        $this->data = [
            "name" => $name,
            "model" => $model,
            "icon" => $icon,
            "label" => $label,
            "labelPlural" => $labelPlural,
        ];

        // Make classes
        $this->makeFile("Resource", $name . "Resource");
        $this->makeFile("Form", $name . "Form");
        $this->makeFile("Table", $name . "Table");

        // Info
        $this->line("");
        $this->info("Please add route to your route file:");
        $this->line("\\App\CaravelAdmin\\Resources\\" . $name . "\\" . $name . "Resource::routes();");
        $this->line("");
        $this->info("Please add navipoint to your sidebar:");
        $this->line("\\App\CaravelAdmin\\Resources\\" . $name . "\\" . $name . "Resource::make()->sidebar()");
    }
}
