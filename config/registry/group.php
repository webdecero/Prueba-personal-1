<?php

use Illuminate\Validation\Rule;
use App\Http\Enums\TerminalType;


return [
    'model' =>  App\Models\Group::class,
    'parentRelation' =>
    [
        //Modelo relacion de parent a user, parentModel
        'related' =>  App\Models\Test::class,
        //Llave foranea en User para la relación
        'foreignKey' => 'parentModelIndex',
        //indice de referencia en parent Model para busqueda| parentModelIndex
        'otherKey' => 'key'
    ],
    'store' =>
    [
        'rules' => [
            'title' => ['string'],
            'description' => ['string'],
            'address' => ['string'],
            'phone' => ['string'],
            'image' =>  ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeImage],
            'status' => ['required'],

            'terminalType' => ['required', Rule::enum(TerminalType::class)],
            'terminalKey' => ['required', 'string'],

            'locations' => ['required', 'array'],
            'metadata' => ['sometimes', 'array'],

            'parentModelIndex' => ['sometimes', 'string'],




        ],
        'autorize' => []


    ],
    'update' =>
    [
        'rules' => [
            'title' => ['string'],
            'description' => ['string'],
            'address' => ['string'],
            'phone' => ['string'],
            'image' =>  ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeImage],
            'status' => ['sometimes'],
            'terminalType' => ['required', Rule::enum(TerminalType::class)],
            'terminalKey' => ['required', 'string'],

            'locations' => ['required', 'array'],
            'metadata' => ['sometimes', 'array'],

            'parentModelIndex' => ['sometimes', 'string'],
        ],
        'autorize' => []


    ],
    'destroy' =>
    [
        'childs' => [],
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
        'except' => ['paginate', 'orderKey', 'orderBy', 'query', 'initDate', 'endDate'],
        'or' =>  [

            [
                'key' => 'title',
                'options' => 'i'
            ]
        ],
        'and' =>  [

            [
                'key' => 'locations',
                'operation' => '$in'
            ],
            [
                'key' => 'status',
                'operation' => '$eq'
            ]
        ]


    ]
];
