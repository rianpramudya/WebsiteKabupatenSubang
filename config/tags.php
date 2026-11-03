<?php

return [

    'slugger' => null,

    'tag_model' => Spatie\Tags\Tag::class,

    'taggable' => [
        'table_name' => 'taggables',
        'morph_name' => 'taggable',

        'class_name' => Illuminate\Database\Eloquent\Relations\MorphPivot::class,
    ]
];
