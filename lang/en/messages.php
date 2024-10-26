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
                'photos' => 'Photos',
                'videos' => 'Videos'
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
        ],

        'academic' => [
            'title' => 'Academic Activities',
            'fields' => [
                'title' => 'Academic Activities',
                'academic_title' => 'Title',
                'link' => 'Short Video Link',
                'full_link' => 'Full Video Link'
            ]
        ],

        'services' => [
            'title' => 'Services',
            'fields' => [
                'title' => 'Services',
                'service_title' => 'Title',
                'content' => 'Content',
                'status' => 'Status',
            ]
        ],

        'promotions' => [
            'title' => 'Promotions',
            'fields' => [
                'title' => 'Promotions',
                'promotion_title' => 'Title',
                'content' => 'Content',
                'status' => 'Status',
                'main_img' => 'Main Image',
                'info_img' => 'Information Image'
            ]
        ],

        'locations' => [
            'title' => 'Locations',
            'fields' => [
                'title' => 'Locations',
                'name' => 'Location Name',
                'description' => 'Description',
            ]
        ],

        'positions' => [
            'title' => 'Positions',
            'fields' => [
                'title' => 'Positions',
                'name' => 'Name',
                'description' => 'Description',
            ]
        ],

        'departments' => [
            'title' => 'Departments',
            'fields' => [
                'title' => 'Departments',
                'name' => 'Name',
                'description' => 'Description',
            ]
        ],

        'careers' => [
            'title' => 'Careers',
            'fields' => [
                'title' => 'Careers',
                'careers_title' => 'Title',
                'location' => 'Location',
                'position' => 'Position',
                'department' => 'Department',
                'posts' => 'Number of Posts',
                'requirements' => 'Requirements',
            ]
        ],
];
