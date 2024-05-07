<?php

namespace FFBlock\Ctrl\Hook;

use FFBlock\Ctrl\Hook\Type\Filter;
use FFBlock\Ctrl\Hook\Type\Action;

class HookCtrl
{
	public function __construct()
	{
		new Filter();
		new Action();
	}
}
