<?php
/*
  Template Name: Home Test Page
*/
use Timber\Timber;
use Timber\Post as TimberPost;

$context = Timber::context();

$timber_post = new TimberPost();
$context['page'] = $timber_post;

Timber::render(['front-page2.twig'], $context);