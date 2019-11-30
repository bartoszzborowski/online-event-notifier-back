<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ScoutElastic\Searchable;

/**
 * App\MyModel
 *
 * @property \ScoutElastic\Highlight|null $highlight
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MyModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MyModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MyModel query()
 * @mixin \Eloquent
 */
class MyModel extends Model
{
    use Searchable;

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
            'title' => [
                'type' => 'text',
                // Also you can configure multi-fields, more details you can find here https://www.elastic.co/guide/en/elasticsearch/reference/current/multi-fields.html
                'fields' => [
                    'raw' => [
                        'type' => 'keyword',
                    ]
                ]
            ],
        ]
    ];
}
