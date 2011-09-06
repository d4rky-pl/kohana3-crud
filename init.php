<?php

Route::set(Kohana::$config->load('crud')->route, 'crud/(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'directory'  => 'crud',
		'controller' => 'main',
		'action'     => 'index',
	));

