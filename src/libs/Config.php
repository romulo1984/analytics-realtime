<?php

class Config {
    public $ids = 'ga:48267993';
    public $metrics = 'rt:activeUsers';

    // https://developers.google.com/analytics/devguides/reporting/core/v3/reference?hl=pt-br
    public $operators = [
        'metrics' => [
            'igual' => '==',
            'não igual' => '!=',
            'maior que' => '>',
            'menor que' => '<',
            'maior ou igual' => '>=',
            'menor ou igual' => '<='
        ],
        'dimension' => [
            'exato' => '==',
            'diferente' => '!=',
            'contém' => '=@',
            'não contém' => '!@',
            'contem (regex)' => '=~',
            'não contém (regex)' => '!~'
        ]
    ];

    public function __construct () {
        putenv('GOOGLE_APPLICATION_CREDENTIALS='.  __DIR__ . '/service_account.json');
    }
}