<?php
use Illuminate\Support\Facades\Facade;

return [
'aliases' => Facade::defaultAliases()->merge([
        // 'ExampleClass' => App\Example\ExampleClass::class,
        'Aws' => App\Helpers\Aws::class,
    ])->toArray(),
];