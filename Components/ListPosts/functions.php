<?php
namespace Flynt\Components\ListPosts;

use Flynt\Features\Components\Component;

add_action('wp_enqueue_scripts', function () {
  Component::enqueueAssets('ListPosts');
});

add_filter('Flynt/addComponentData?name=ListPosts', function ($data) {
  $data['posts'] = [
    [
      'title' => 'My post title',
      'permalink' => '#',
      'excerpt' => 'Lorem ipsum dolor aset amet ipsum apet samir amet lorem ipsum dolor aset amet ipsum ol',
      'thumbnail' => 'http://placehold.it/250x250',
      'date' => '2017-01-21',
      'author' => 'Max Mustermann',
      'authorPermalink' => '#',
      'categories' => [
        [
          'title' => 'Category 1',
          'permalink' => '#'
        ],
        [
          'title' => 'Category 2',
          'permalink' => '#'
        ]
      ],
      'tags' => [
        [
          'title' => 'Tag 1',
          'permalink' => '#',
        ],
        [
          'title' => 'Tag 2',
          'permalink' => '#'
        ]
      ]
    ],
    [
      'title' => 'My post title',
      'permalink' => '#',
      'excerpt' => 'Lorem ipsum dolor aset amet ipsum apet samir amet lorem ipsum dolor aset amet ipsum ol',
      'thumbnail' => 'http://placehold.it/250x250',
      'date' => '2017-01-21',
      'author' => 'Max Mustermann',
      'authorPermalink' => '#',
      'categories' => [
        [
          'title' => 'Category 1',
          'permalink' => '#'
        ],
        [
          'title' => 'Category 2',
          'permalink' => '#'
        ]
      ],
      'tags' => [
        [
          'title' => 'Tag 1',
          'permalink' => '#',
        ],
        [
          'title' => 'Tag 2',
          'permalink' => '#'
        ]
      ]
    ],
    [
      'title' => 'My post title',
      'permalink' => '#',
      'excerpt' => 'Lorem ipsum dolor aset amet ipsum apet samir amet lorem ipsum dolor aset amet ipsum ol',
      'thumbnail' => 'http://placehold.it/250x250',
      'date' => '2017-01-21',
      'author' => 'Max Mustermann',
      'authorPermalink' => '#',
      'categories' => [
        [
          'title' => 'Category 1',
          'permalink' => '#'
        ],
        [
          'title' => 'Category 2',
          'permalink' => '#'
        ]
      ],
      'tags' => [
        [
          'title' => 'Tag 1',
          'permalink' => '#',
        ],
        [
          'title' => 'Tag 2',
          'permalink' => '#'
        ]
      ]
    ],
    [
      'title' => 'My post title',
      'permalink' => '#',
      'excerpt' => 'Lorem ipsum dolor aset amet ipsum apet samir amet lorem ipsum dolor aset amet ipsum ol',
      'thumbnail' => 'http://placehold.it/250x250',
      'date' => '2017-01-21',
      'author' => 'Max Mustermann',
      'authorPermalink' => '#',
      'categories' => [
        [
          'title' => 'Category 1',
          'permalink' => '#'
        ],
        [
          'title' => 'Category 2',
          'permalink' => '#'
        ]
      ],
      'tags' => [
        [
          'title' => 'Tag 1',
          'permalink' => '#',
        ],
        [
          'title' => 'Tag 2',
          'permalink' => '#'
        ]
      ]
    ],
    [
      'title' => 'My post title',
      'permalink' => '#',
      'excerpt' => 'Lorem ipsum dolor aset amet ipsum apet samir amet lorem ipsum dolor aset amet ipsum ol',
      'thumbnail' => 'http://placehold.it/250x250',
      'date' => '2017-01-21',
      'author' => 'Max Mustermann',
      'authorPermalink' => '#',
      'categories' => [
        [
          'title' => 'Category 1',
          'permalink' => '#'
        ],
        [
          'title' => 'Category 2',
          'permalink' => '#'
        ]
      ],
      'tags' => [
        [
          'title' => 'Tag 1',
          'permalink' => '#',
        ],
        [
          'title' => 'Tag 2',
          'permalink' => '#'
        ]
      ]
    ],
    [
      'title' => 'My post title',
      'permalink' => '#',
      'excerpt' => 'Lorem ipsum dolor aset amet ipsum apet samir amet lorem ipsum dolor aset amet ipsum ol',
      'thumbnail' => 'http://placehold.it/250x250',
      'date' => '2017-01-21',
      'author' => 'Max Mustermann',
      'authorPermalink' => '#',
      'categories' => [
        [
          'title' => 'Category 1',
          'permalink' => '#'
        ],
        [
          'title' => 'Category 2',
          'permalink' => '#'
        ]
      ],
      'tags' => [
        [
          'title' => 'Tag 1',
          'permalink' => '#',
        ],
        [
          'title' => 'Tag 2',
          'permalink' => '#'
        ]
      ]
    ],
    [
      'title' => 'My post title',
      'permalink' => '#',
      'excerpt' => 'Lorem ipsum dolor aset amet ipsum apet samir amet lorem ipsum dolor aset amet ipsum ol',
      'thumbnail' => 'http://placehold.it/250x250',
      'date' => '2017-01-21',
      'author' => 'Max Mustermann',
      'authorPermalink' => '#',
      'categories' => [
        [
          'title' => 'Category 1',
          'permalink' => '#'
        ],
        [
          'title' => 'Category 2',
          'permalink' => '#'
        ]
      ],
      'tags' => [
        [
          'title' => 'Tag 1',
          'permalink' => '#',
        ],
        [
          'title' => 'Tag 2',
          'permalink' => '#'
        ]
      ]
    ],
    [
      'title' => 'My post title',
      'permalink' => '#',
      'excerpt' => 'Lorem ipsum dolor aset amet ipsum apet samir amet lorem ipsum dolor aset amet ipsum ol',
      'thumbnail' => 'http://placehold.it/250x250',
      'date' => '2017-01-21',
      'author' => 'Max Mustermann',
      'authorPermalink' => '#',
      'categories' => [
        [
          'title' => 'Category 1',
          'permalink' => '#'
        ],
        [
          'title' => 'Category 2',
          'permalink' => '#'
        ]
      ],
      'tags' => [
        [
          'title' => 'Tag 1',
          'permalink' => '#',
        ],
        [
          'title' => 'Tag 2',
          'permalink' => '#'
        ]
      ]
    ],
    [
      'title' => 'My post title',
      'permalink' => '#',
      'excerpt' => 'Lorem ipsum dolor aset amet ipsum apet samir amet lorem ipsum dolor aset amet ipsum ol',
      'thumbnail' => 'http://placehold.it/250x250',
      'date' => '2017-01-21',
      'author' => 'Max Mustermann',
      'authorPermalink' => '#',
      'categories' => [
        [
          'title' => 'Category 1',
          'permalink' => '#'
        ],
        [
          'title' => 'Category 2',
          'permalink' => '#'
        ]
      ],
      'tags' => [
        [
          'title' => 'Tag 1',
          'permalink' => '#',
        ],
        [
          'title' => 'Tag 2',
          'permalink' => '#'
        ]
      ]
    ],
    [
      'title' => 'My post title',
      'permalink' => '#',
      'excerpt' => 'Lorem ipsum dolor aset amet ipsum apet samir amet lorem ipsum dolor aset amet ipsum ol',
      'thumbnail' => 'http://placehold.it/250x250',
      'date' => '2017-01-21',
      'author' => 'Max Mustermann',
      'authorPermalink' => '#',
      'categories' => [
        [
          'title' => 'Category 1',
          'permalink' => '#'
        ],
        [
          'title' => 'Category 2',
          'permalink' => '#'
        ]
      ],
      'tags' => [
        [
          'title' => 'Tag 1',
          'permalink' => '#',
        ],
        [
          'title' => 'Tag 2',
          'permalink' => '#'
        ]
      ]
    ]
  ];

  return $data;
});
