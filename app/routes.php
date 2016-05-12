<?php namespace PodBuzzz;

/** @var \Herbert\Framework\Router $router */

$router->post([
    'as'   => 'setPodbuzzzKey',
    'uri'  => '/podbuzzz_api/key',
    'uses' => __NAMESPACE__ . '\Controllers\SettingsController@addKey'
]);

$router->get([
    'as'   => 'getPodbuzzzKey',
    'uri'  => '/podbuzzz_api/key',
    'uses' => __NAMESPACE__ . '\Controllers\SettingsController@getKey'
]);

$router->get([
    'as'   => 'verifyPodBuzzzScriptInstalled',
    'uri'  => '/podbuzzz_api/scriptInstalled',
    'uses' => __NAMESPACE__ . '\Controllers\SettingsController@scriptInstalled'
]);

$router->post([
    'as'   => 'enablePodBuzzzScript',
    'uri'  => '/podbuzzz_api/enableScript',
    'uses' => __NAMESPACE__ . '\Controllers\SettingsController@enableScript'
]);

$router->get([
    'as'   => 'PodBuzzzScriptIsEnabled',
    'uri'  => '/podbuzzz_api/scriptIsEnabled',
    'uses' => __NAMESPACE__ . '\Controllers\SettingsController@scriptIsEnabled'
]);
