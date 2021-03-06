<?php

namespace Pickle;

use Pickle\Engine;
use Pickle\Package\PHP;
use Pickle\Package\HHVM;


class Package
{
	protected static $instance = NULL;

	protected static function deliverFresh($force)
	{
		if ($force && self::$instance || is_null(self::$instance)) {
			/* XXX does this leak the previous instance? */
			self::$instance = NULl;

			return true;
		}

		return false;
	}

	public static function factory($name, $version, $prettyVersion, $force = false)
	{
		if (self::deliverFresh($force)) {
			$engine = Engine::factory();

			switch($engine->getName()) {
				case "php":
					self::$instance = new PHP\Package($name, $version, $prettyVersion);
					break;

				case "hhvm":
					self::$instance = new HHVM\Package($name, $version, $prettyVersion);
					break;

				default:
					throw new \Exception("Unsupported engine '{$engine->getName()}'. Implement it!");
			}

		}

		return self::$instance;
	}
}

