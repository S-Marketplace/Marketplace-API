<?php

namespace Config;

use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\DebugToolbar;

class Filters extends BaseConfig
{
	/**
	 * Configures aliases for Filter classes to
	 * make reading things nicer and simpler.
	 *
	 * @var array
	 */
	public $aliases = [
		'csrf'     => CSRF::class,
		'toolbar'  => DebugToolbar::class,
		'honeypot' => Honeypot::class,
		'hakAkses' => [
			\App\Filters\LoginFilter::class,
			\App\Filters\RoleFilter::class
		],
		'apiKeyFilter' => \App\Filters\ApiKeyFilter::class,
		'apiFilter' => [
			\App\Filters\ApiKeyFilter::class,
			\App\Filters\TokenFilter::class,
		]
	];

	/**
	 * List of filter aliases that are always
	 * applied before and after every request.
	 *
	 * @var array
	 */
	public $globals = [
		'before' => [
			// 'honeypot',
			// 'csrf',
			'hakAkses' => ['except' => ['/', 'login', 'login/logout', 'login/*', 'api/*', 'antrian', 'antrian/*', 'cetak', 'cetak/*']],
		],
		'after'  => [
			'toolbar',
			// 'honeypot',
		],
	];

	/**
	 * List of filter aliases that works on a
	 * particular HTTP method (GET, POST, etc.).
	 *
	 * Example:
	 * 'post' => ['csrf', 'throttle']
	 *
	 * @var array
	 */
	public $methods = [];

	/**
	 * List of filter aliases that should run on any
	 * before or after URI patterns.
	 *
	 * Example:
	 * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
	 *
	 * @var array
	 */
	public $filters = [];
}
