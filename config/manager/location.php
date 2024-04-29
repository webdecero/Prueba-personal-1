<?php

return [
    'model' =>  \App\Models\Location::class,
    'store' =>
    [
        'rules' => [
            'name' => ['required', 'string',],
            'metadata' => ['sometimes','array'],
        ],
        'autorize' => []

    ],
    'update' =>
    [
        'rules' => [
            'name' => ['required', 'string'],
            'metadata' => ['sometimes','array'],
        ],
        'autorize' => []
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
                'key' => 'key',
                'operation' => '$eq'
            ]
        ]


    ]
];
