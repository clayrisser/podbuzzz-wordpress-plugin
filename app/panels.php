<?php namespace PodBuzzz;

/** @var \Herbert\Framework\Panel $panel */

$panel->add([
    'type'   => 'wp-sub-panel',
    'parent' => 'options-general.php',
    'as'     => 'podbuzzz',
    'title'  => 'PodBuzzz',
    'slug'   => 'podbuzzz',
    'uses'   => function() {
        return view('@PodBuzzz/panels/home.twig', [
            'siteUrl' => get_site_url().'/podbuzzz_api'
        ]);
    }
]);
