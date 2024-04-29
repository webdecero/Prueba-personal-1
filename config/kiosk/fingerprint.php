<?php

return [
    'model' =>  \App\Models\Fingerprint::class,
    'store' =>
    [
        'rules' => [
            "typeFinger"=>"required" ,
            "typeHand"=>"required" ,
            "pathTemplateFingerPrint"=>"required" ,
            "pathImageFingerPrint"=>"required",
            "parentModelClass"=>"required" ,
            "parentModelKey"=>"required" ,
            "parentModelIndex"=>"required",
            "metadata"=>"required" ,
            "user_id"=>"required" ,
            "parentModel_id"=>"required"
        ],
        'autorize' => []


    ],
    'update' =>
    [
        'rules' => [
            "typeFinger"=>"required" ,
            "typeHand"=>"required" ,
            "pathTemplateFingerPrint"=>"required" ,
            "pathImageFingerPrint"=>"required",
            "parentModelClass"=>"required" ,
            "parentModelKey"=>"required" ,
            "parentModelIndex"=>"required",
            "metadata"=>"required" ,
            "user_id"=>"required" ,
            "parentModel_id"=>"required"
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