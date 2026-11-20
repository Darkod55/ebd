<?php

/**
 * Issue 01 running order.
 *
 * Teasers only. Full copy is in articles.php, linked with Read more.
 * Layouts stay full-bleed, split, and closing.
 */

return [
    'title' => 'Issue 01',
    'spreads' => [
        [
            'slug' => 'cover',
            'title' => 'Show the Love',
            'layout' => 'full-bleed',
            'thumbnail' => null,
            'article' => [],
            'data' => [
                'tone' => 'dark',
                'kicker' => 'Draft · Cover',
                'heading' => 'Show the Love',
                'dek' => 'Redefining what luxury looks like.',
                'aside' => 'Cover photograph to come. Draft headline only.',
            ],
        ],
        [
            'slug' => 'letter',
            'title' => 'Letter from the Editor',
            'layout' => 'split',
            'thumbnail' => null,
            'article' => [],
            'data' => [
                'kicker' => 'To come',
                'heading' => 'Letter from the Editor',
                'dek' => 'This letter is still to come. It will open the issue.',
                'aside' => 'Photograph to come',
            ],
        ],
        [
            'slug' => 'formula-1',
            'title' => 'Formula 1 - Beyond the Glitz, Glamour & Technical Innovations',
            'layout' => 'full-bleed',
            'thumbnail' => 'Formula_1_Grand_Prix_Race_EBD_Magazine_2026.webp',
            'article' => ['label' => 'Read more', 'read' => 'formula-1'],
            'data' => [
                'tone' => 'dark',
                'long_title' => true,
                'kicker' => 'Motorsport',
                'heading' => 'Formula 1 - Beyond the Glitz, Glamour & Technical Innovations',
                'dek' => 'Fast cars and breakneck speeds. Exotic locations. Glitz and glamour. The best of the best.',
                'byline' => 'Thiemo Albers-Daly',
                'image' => 'Formula_1_Grand_Prix_Race_EBD_Magazine_2026.webp',
                'image_alt' => 'Formula 1 cars racing at night beneath a large Heineken 0.0 sign.',
            ],
        ],
        [
            'slug' => 'family-values',
            'title' => 'Putting Family Values into Practice',
            'layout' => 'split',
            'thumbnail' => null,
            'article' => ['label' => 'Read more', 'read' => 'family-values'],
            'data' => [
                'kicker' => 'Family',
                'heading' => 'Putting Family Values into Practice',
                'dek' => 'At the end of a family retreat, the values cards go back in their box.',
                'byline' => 'Dr. Stacy Feiner',
                'aside' => 'Photograph to come',
            ],
        ],
        [
            'slug' => 'extraordinary-difference',
            'title' => 'The Greatest Myth About Luxury?',
            'layout' => 'split',
            'thumbnail' => null,
            'article' => ['label' => 'Read more', 'read' => 'extraordinary-difference'],
            'data' => [
                'long_title' => true,
                'kicker' => 'Impact',
                'heading' => 'The Greatest Myth About Luxury? That Making an Extraordinary Difference Is Reserved for the Few.',
                'dek' => 'What if life\'s greatest luxury is the power we already have to change lives, create possibilities, and leave a meaningful legacy?',
                'byline' => 'Priscilla Stephan',
                'aside' => 'Photograph to come',
            ],
        ],
        [
            'slug' => 'freedom-to-choose',
            'title' => 'What If the Greatest Luxury Is The Freedom to Choose?',
            'layout' => 'split',
            'thumbnail' => null,
            'article' => ['label' => 'Read more', 'read' => 'freedom-to-choose'],
            'data' => [
                'long_title' => true,
                'kicker' => 'Wealth',
                'heading' => 'What If the Greatest Luxury Is The Freedom to Choose?',
                'dek' => 'On wealth, family expectations and the future we make possible.',
                'byline' => 'Ildiko Markus',
                'aside' => 'Photograph to come',
            ],
        ],
        [
            'slug' => 'orveda',
            'title' => 'Orveda: The Green Beauty Brand Worth Stopping For',
            'layout' => 'split',
            'thumbnail' => 'Packshot_Orveda_Omnipotent_Concentrate_EBD_Magazine_2026.webp',
            'article' => ['label' => 'Read more', 'read' => 'orveda'],
            'data' => [
                'long_title' => true,
                'kicker' => 'Beauty Editor\'s Pick',
                'heading' => 'Orveda: The Green Beauty Brand Worth Stopping For',
                'dek' => 'Exclusive to Harrods, Orveda combines biotechnology, vegan formulations and a skin-first philosophy in a collection that prioritises radiance, hydration and long-term skin health.',
                'byline' => 'Viorela Coman',
                'image' => 'Packshot_Orveda_Omnipotent_Concentrate_EBD_Magazine_2026.webp',
                'image_alt' => 'Orveda Omnipotent Concentrate bottle.',
                'image_fit' => 'contain',
            ],
        ],
        [
            'slug' => 'the-edit',
            'title' => 'The Edit',
            'layout' => 'split',
            'thumbnail' => null,
            'article' => ['label' => 'Read more', 'read' => 'the-edit'],
            'data' => [
                'kicker' => 'The Edit',
                'heading' => 'Brands in this issue',
                'dek' => 'Names only, as supplied. Directory pages are still to come.',
                'aside' => 'Photographs to come',
                'items' => [
                    'The Reclaimery',
                    'Sylvia Piechulla',
                    'Sanyukta Shtrestha',
                    'Haus Dhalia',
                    'Loft & Daughter',
                    'Jia De Lara',
                ],
            ],
        ],
        [
            'slug' => 'contributors',
            'title' => 'Contributors',
            'layout' => 'closing',
            'thumbnail' => null,
            'article' => ['label' => 'Read more', 'read' => 'contributors'],
            'data' => [
                'kicker' => 'Colophon',
                'heading' => 'Contributors',
                'dek' => 'Roberta Lee, Editor-in-Chief. Hermione, editor and fact checker. The writers of this issue.',
            ],
        ],
    ],
];
