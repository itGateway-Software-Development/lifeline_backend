<?php

return [
    'panel_name' => 'Lifeline',

    'principle' => [
        'title' => 'Principles',
        'fields' => [
            'name' => 'Name',
            'country' => 'Country',
        ],
    ],

    'group' => [
        'title' => 'Group',
        'fields' => [
            'name' => 'Name',
            'photo' => 'Photo'
        ],
    ],

    'category' => [
        'title' => 'Category',
        'fields' => [
            'name' => 'Name',
            'group' => 'Group'
        ],
    ],

    'ingredient' => [
        'title' => 'Ingredient',
        'fields' => [
            'name' => 'Name',
        ],
    ],

    'product' => [
        'title' => 'Product',
        'fields' => [
            'name' => 'Name',
            'price' => 'Price',
            'ingredient' => 'Ingredients',
            'photo' => 'Photo',
            'principle' => 'Principle',
            'category' => 'Category',
            'group' => 'Group',
            'presentation' => 'Presentation',
            'dose' => 'Dose',
            'indication' => 'Indication'
        ],
    ],

    'photo_gallery' => [
        'title' => 'Photo Gallery',
        'fields' => [
            'title' => 'Title',
            'date' => 'Date',
            'photos' => 'Photos',
        ]
        ],

        'csr' => [
            'title' => 'CSR Activity',
            'fields' => [
                'title' => 'CSR Activity',
                'csr_title' => 'Title',
                'date' => 'Year',
                'content' => 'Content',
                'photos' => 'Photos'
            ]
        ],

        'news' => [
            'title' => 'New & Events',
            'fields' => [
                'title' => 'New & Events',
                'news_title' => 'Title',
                'date' => 'Date',
                'content' => 'Content',
                'photos' => 'Photos'
            ]
        ]
];
