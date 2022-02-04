<?php

return [
    "resources" => [
        "path" => app_path('CaravelAdmin/Resources'),
        "controller" => \App\Http\Controllers\ResourceController::class,
        "namespace" => "App\\CaravelAdmin\\Resources",
        "prefix" => "caravel-admin.",
        "route_prefix" => "app.",
    ],
    "component-aliases" => [

    ],
    "tables" => [
        "action_icons" => true,
        "action_labels" => true
    ]
];
