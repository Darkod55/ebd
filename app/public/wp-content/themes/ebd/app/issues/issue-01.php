<?php

/**
 * Issue 01 — spread list.
 *
 * This file is the whole issue. Order is reading order.
 * A future CPT/ACF row maps 1:1 onto one item:
 *   slug, title, layout, thumbnail, article, data.
 *
 * Add a spread: append an item. Slug becomes /issue-01/{slug}/.
 * The first item must use slug "cover" (also served at /issue-01/).
 * layout is a Blade view: resources/views/issue/layouts/{layout}.blade.php
 * thumbnail is null or an image URL (overview plate).
 * article.demo is a DemoCatalog preview key, or set article.url instead.
 * data is passed to that layout. Placeholder copy only.
 *
 * New layout: add the Blade file, then name it here. No other registry.
 */

return [
    'title' => 'Placeholder · Issue 01',
    'spreads' => [
        [
            'slug' => 'cover',
            'title' => 'Placeholder · Cover',
            'layout' => 'full-bleed',
            'thumbnail' => null,
            'article' => ['label' => 'Placeholder · Read the story', 'demo' => 'article'],
            'data' => [
                'tone' => 'dark',
                'kicker' => 'Placeholder · Issue 01',
                'heading' => 'Placeholder cover line',
                'dek' => 'Placeholder dek. One sentence for the cover.',
            ],
        ],
        [
            'slug' => 'opener',
            'title' => 'Placeholder · Opener',
            'layout' => 'split',
            'thumbnail' => null,
            'article' => ['label' => 'Placeholder · Read the story', 'demo' => 'article'],
            'data' => [
                'kicker' => 'Placeholder · Opener',
                'heading' => 'Placeholder opener title',
                'dek' => 'Placeholder dek for a split spread.',
                'aside' => 'Placeholder · Plate',
            ],
        ],
        [
            'slug' => 'feature',
            'title' => 'Placeholder · Feature',
            'layout' => 'split',
            'thumbnail' => null,
            'article' => ['label' => 'Placeholder · Read the story', 'demo' => 'article'],
            'data' => [
                'kicker' => 'Placeholder · Feature',
                'heading' => 'Placeholder feature title',
                'dek' => 'Placeholder dek. The long article is a separate page.',
                'aside' => 'Placeholder · Plate',
            ],
        ],
        [
            'slug' => 'picture',
            'title' => 'Placeholder · Picture',
            'layout' => 'full-bleed',
            'thumbnail' => null,
            'article' => ['label' => 'Placeholder · Editor’s picks', 'demo' => 'article-picks'],
            'data' => [
                'tone' => 'dark',
                'kicker' => 'Placeholder · Picture',
                'heading' => 'Placeholder picture line',
                'dek' => 'Placeholder dek on a full-bleed plate.',
            ],
        ],
        [
            'slug' => 'conversation',
            'title' => 'Placeholder · Conversation',
            'layout' => 'split',
            'thumbnail' => null,
            'article' => ['label' => 'Placeholder · Read the story', 'demo' => 'article'],
            'data' => [
                'kicker' => 'Placeholder · Conversation',
                'heading' => 'Placeholder conversation title',
                'dek' => 'Placeholder dek. Two voices, one spread.',
                'aside' => 'Placeholder · Plate',
            ],
        ],
        [
            'slug' => 'note',
            'title' => 'Placeholder · Note',
            'layout' => 'full-bleed',
            'thumbnail' => null,
            'article' => ['label' => 'Placeholder · Read the story', 'demo' => 'article'],
            'data' => [
                'tone' => 'paper',
                'kicker' => 'Placeholder · Note',
                'heading' => 'Placeholder note line',
                'dek' => 'Placeholder dek. A short spread between features.',
            ],
        ],
        [
            'slug' => 'directory',
            'title' => 'Placeholder · Directory',
            'layout' => 'split',
            'thumbnail' => null,
            'article' => ['label' => 'Placeholder · The Edit', 'demo' => 'the-edit'],
            'data' => [
                'kicker' => 'Placeholder · Directory',
                'heading' => 'Placeholder directory title',
                'dek' => 'Placeholder dek. Brands stay on their own page.',
                'aside' => 'Placeholder · Plate',
            ],
        ],
        [
            'slug' => 'colophon',
            'title' => 'Placeholder · Close',
            'layout' => 'closing',
            'thumbnail' => null,
            'article' => ['label' => 'Placeholder · Contributors', 'demo' => 'contributors'],
            'data' => [
                'kicker' => 'Placeholder · Close',
                'heading' => 'Placeholder closing line',
                'dek' => 'Placeholder dek. End of this issue.',
            ],
        ],
    ],
];
