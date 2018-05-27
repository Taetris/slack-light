<?php

namespace Session;

use Base\BaseObject;

class SessionContext extends BaseObject {

	private static $exists;

	public static function create() : bool {
		if (!self::$exists) {
			self::$exists = session_start();
		}
		return self::$exists;
	}
}
