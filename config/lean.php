<?php

return [
    'scripts' => [
        'alpine' => '<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.min.js" defer></script>',
        'moment' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>',
        'pikaday' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.2/pikaday.min.js" integrity="sha512-dkMzAitT+RFxzaHsyXAd1KtYpmuP/Jl6yOPYUu1s20dLfizq6cpbzDFNSAANb3IZbyhVhAbZxAyeqORpjkF3oQ==" crossorigin="anonymous"></script>',
        'trix' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.0/trix.min.js" integrity="sha512-9JcmG1JOs44Iob11CgdOsTJdYnzXVlZsEmt5hsX+4uQYCKkitcCuwgSIkHpm0ATqBgvdSA1pJsYwt9HdPEb1Nw==" crossorigin="anonymous"></script>',
    ],

    'styles' => [
        'pikaday' => '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.2/css/pikaday.min.css" integrity="sha512-exu2USmctkp0epKmtBa9LgBAoSZWufqYq+Yw6mVxqwXEcIIfOn8oVF+uHXJga+Aq+Ny8UKOtALNVmekxQhUGIA==" crossorigin="anonymous" />',
        'trix' => '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.0/trix.min.css" integrity="sha512-5m1IeUDKtuFGvfgz32VVD0Jd/ySGX7xdLxhqemTmThxHdgqlgPdupWoSN8ThtUSLpAGBvA8DY2oO7jJCrGdxoA==" crossorigin="anonymous" />',
    ],

    'actions' => [
        'index' => [
            'results_per_page' => 10,
        ],
    ],

    'relations' => [
        'hasmany' => [
            'index' => [
                'results_per_page' => 3,
            ],
        ],
    ],

    'fields' => [
        'textarea' => [
            'index_excerpt_words' => 10,
        ],
        'trix' => [
            'index_excerpt_words' => 10,
        ],
    ],
];
