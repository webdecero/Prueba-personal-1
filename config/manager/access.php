<?php

return [
    'model' =>  \App\Models\Access::class,
    'store' =>
    [
        'rules' => [
            'name' => 'required',
            'status' => 'required',
            'metadata' => 'array'
        ],
        'autorize' => []


    ],
    'update' =>
    [
        'rules' => [
            'name' => 'required',
            'status' => 'required',
            'metadata' => 'array'
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
