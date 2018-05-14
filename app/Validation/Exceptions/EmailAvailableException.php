<?php

namespace App\Validation\Exceptions;

use Respect\Validation\Exception\ValidationException;

class EmailAvailableException
{
	public static $defaultTemplates = [
		self::MODE_DEFAULT = [
			self::STANDARD => 'Email is taken.',
		];
	];
}