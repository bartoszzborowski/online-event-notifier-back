<?php

namespace App\Models;

use App\MyIndexConfigurator;
use Illuminate\Database\Eloquent\Model;
use ScoutElastic\Searchable;

class Article extends Model
{
    use Searchable;

    public function searchableAs()
    {
        return 'article';
    }

    /**
     * @var string
     */
    protected $indexConfigurator = MyIndexConfigurator::class;

    /**
     * @var array
     */
    protected $searchRules = [
        //
    ];

    // Here you can specify a mapping for model fields
    protected $mapping = [
        'properties' => [
            'body' => [
                'type' => 'text'
            ],
            'title' => [
                'type' => 'text',
            ],
            'tags' => [
                'type' => 'keyword',
            ]
        ]
    ];
}
