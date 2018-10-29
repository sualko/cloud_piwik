<?php

return [
	'routes' => [
		['name' => 'settings#index', 'url' => '/settings', 'verb' => 'GET'],
		['name' => 'settings#update', 'url' => '/settings/{key}', 'verb' => 'PUT'],
		['name' => 'JavaScript#tracking', 'url' => '/js/tracking.js', 'verb' => 'GET']
	],
];
?>