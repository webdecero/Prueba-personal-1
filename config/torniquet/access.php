<?php

return [
    'model' =>  \App\Models\Access::class,
    'store' =>
    [
        'rules' => [
            "type"=>'required' ,
            "metadata"=>'required' ,
            "dateString"=>'required' ,
            //"company_key",
            //"company_name",
            //"location_key",
            //"location_name",
            //"terminal_key",
            //"terminal_name",
            "user_id"=>'required' ,
            "user_name"=>'required',
            //"user_parent_model_id",
            //"access_parent_model_id",
            //"group_key"
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
