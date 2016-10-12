<?php

namespace Oni\Framework\Support;

class NullChecker
{
	public function check($code)
	{
		return collect([]);
	}
}