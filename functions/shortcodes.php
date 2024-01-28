<?php

add_action('init', function () {
	add_shortcode('get_url_param', function ($attrs) {
	    $attrs = shortcode_atts(['param' => 'paramname'], $attrs);
	    return $_GET[$attrs['param']] ?? '';
	});

	add_shortcode('cf-country', function ($attrs) {
	    return $_SERVER['HTTP_CF_IPCOUNTRY'] ?? null;
	});
});
