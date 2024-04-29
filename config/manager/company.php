<?php

return [
    'model' =>  App\Models\Company::class,
    'store' => [
        'image' =>  ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeImage ],
        'name' => ['sometimes','string'],
        'isMultiLocation' => ['sometimes', 'string'],
        'isGroupActive'=> ['sometimes','string'],
        'resources' => ['sometimes', 'array'],
        'metadata' => ['sometimes', 'array'],
    ],

    'update' => [

    ],
    'destroy' =>
    [
        'childs' => [
        ],
        'autorize' => []


    ],
    'search' =>
    [
        'except' =>['paginate', 'orderKey', 'orderBy', 'query', 'initDate', 'endDate'],
        'or' =>  [

            [
                'key' => 'name',
                'options' => 'i'
            ]
        ],
        'and' =>  [

            [
                'key' => 'metadata.location',
                'operation' => '$eq'
            ],
            [
                'key' => 'status',
                'operation' => '$eq'
            ]
        ]
    ]
];
