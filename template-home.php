<?php
/*
  Template Name: Home Page
*/

use Timber\Timber;
use Timber\Post as TimberPost;

$context = Timber::context();

$timber_post = new TimberPost();
$context['page'] = $timber_post;

$useProductionAPI = get_field('use_production_api', $timber_post->ID);
$context['use_production_api'] = $useProductionAPI;

$context['cryptocurrencies'] = get_field('cryptocurrencies', 'option');

$template = 'front-page.twig';

Timber::render($template, $context);
