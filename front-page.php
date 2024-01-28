<?php
/*
  Template Name: Home Page
*/
use Timber\Timber;
use Timber\Post as TimberPost;

$context = Timber::context();

$timber_post = new TimberPost();
$context['page'] = $timber_post;
$context['cryptocurrencies'] = get_field('cryptocurrencies', 'option');

Timber::render(['front-page.twig'], $context);