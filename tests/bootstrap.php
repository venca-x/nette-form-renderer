<?php

declare(strict_types=1);
use Tester\Environment;

if (@!include __DIR__ . '/../vendor/autoload.php') {
	echo 'Install Nette Tester using `composer install`';
	exit(1);
}


Environment::setup();
date_default_timezone_set('Europe/Prague');


/**
 * @param Closure|null $function
 * @return mixed|void|null
 */
function before(?Closure $function = null)
{
	static $val;
	if (!func_num_args()) {
		return $val ? $val() : null;
	}
	$val = $function;
}


function test(string $title, Closure $function): void
{
	before();
	$function();
}
