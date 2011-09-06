<?php

Route::set('crud', 'crud/(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'directory'  => 'crud',
		'controller' => 'main',
		'action'     => 'index',
	));

