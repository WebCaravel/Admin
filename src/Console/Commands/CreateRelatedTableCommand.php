<?php

namespace WebCaravel\Admin\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use WebCaravel\Admin\Helper\StubHelper;

class CreateRelatedTableCommand extends Command
{
    use CreateStubTrait;

    protected $signature = 'caravel-admin:make-related-table {name} {related}';
    protected $description = 'Generates a new related table class';


    public function handle()
    {
        // Input data
        $name = $this->argument("name");
        $related = $this->argument("related");

        // Init
        $this->init($name);

        // Caclulate data
        $this->data = [
            "name" => $name,
            "related" => $related,
        ];

        // Make classes
        $this->makeFile("RelatedTable", "Related" . $related . "Table");
    }
}
