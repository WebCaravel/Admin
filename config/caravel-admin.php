<?php

return [
    "resources" => [
        "path" => app_path('CaravelAdmin/Resources'),
        "controller" => \App\Http\Controllers\ResourceController::class,
        "namespace" => "App\\CaravelAdmin\\Resources",
        "prefix" => "caravel-admin.",
        "route_prefix" => "app.",
    ],
    "settings" => [
        "path" => app_path('CaravelAdmin/Settings'),
        "namespace" => "App\\CaravelAdmin\\Settings",
        "prefix" => "caravel-admin.",
        "route_prefix" => "admin.",
    ],
    "component-aliases" => [

    ],
    "tables" => [
        "action_icons" => true,
        "action_labels" => true
    ]
];
