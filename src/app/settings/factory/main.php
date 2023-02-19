<?php
return [
    'name' => 'Основные',
    'data' => [
        'site_name' => [
            'name' => 'Название сайта',
            'placeholder' => 'Название сайта',
            'rules' => 'string|max:250',
        ],
        'about' => [
            'name' => 'Описание',
            'type' => 'textarea',
            'placeholder' => 'Описание',
            'rules' => 'string|max:500|nullable',
        ]
    ]
];
