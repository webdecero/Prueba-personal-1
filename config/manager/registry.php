<?php

 use App\Models\Registry;
return [
    'model' =>  Registry::class,
    'store' =>
    [
        'rules' => [
            'name' => ['required', 'string'],
            'status' => ['required'],
            'deviceId' => ['required', 'string'],
            'locationKey' => ['required', 'string'],
            'metadata' => ['sometimes','array'],
        ],
        'autorize' => []


    ],
    'update' =>
    [
        'rules' => [
            'name' => ['required', 'string'],
            'status' => ['required'],
            'deviceId' => ['required', 'string'],
            'locationKey' => ['required', 'string'],
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
    'status' =>
    [
        'rules' => [
            'status' => ['required']
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
                'key' => 'status',
                'operation' => '$eq'
            ]
        ]


    ]
];
