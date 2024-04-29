<?php

use Illuminate\Validation\Rule;
use App\Http\Enums\TerminalType;

return [
    'model' =>  \App\Models\User::class,
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
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['sometimes', 'string'],
            'avatar' =>  ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeImage],
            'status' => ['required'],
            'address' => ['sometimes', 'string'],
            'phone' => ['sometimes', 'string'],

            'terminalType' => ['required', Rule::enum(TerminalType::class)],
            'terminalKey' => ['required', 'string'],

            'locations' => ['sometimes', 'array'],
            'metadata' => ['sometimes', 'array'],

            'parentModelIndex' => ['sometimes', 'string'],

        ],
        'autorize' => []


    ],
    'update' =>
    [
        'rules' => [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['sometimes', 'string'],
            'avatar' =>  ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeImage],
            'status' => ['sometimes', 'string'],
            'address' => ['sometimes', 'string'],
            'phone' => ['sometimes', 'string'],

            'terminalType' => ['required', Rule::enum(TerminalType::class)],
            'terminalKey' => ['required', 'string'],

            'locations' => ['sometimes', 'array'],
            'metadata' => ['sometimes', 'array'],

            'parentModelIndex' => ['sometimes', 'string'],
        ],
        'autorize' => []


    ],
    'destroy' =>
    [

        //Funcion del modelo que borra en Cascada
        'childs' => ['fingerprints'],
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
                'key' => 'name',
                'options' => 'i'
            ],
            [
                'key' => 'email',
                'options' => 'i'

            ],
            [
                'key' => 'phone',
                'options' => 'i'
            ]
        ],
        'and' =>  [

            [
                'key' => 'locations',
                'operation' => '$in'
            ],
            [
                'key' => 'terminal_key',
                'operation' => '$eq'
            ],
            [
                'key' => 'status',
                'operation' => '$eq'
            ]
        ]


    ]
];
