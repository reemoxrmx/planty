<?php

namespace FFBlock\Ctrl;

use FFBlock\Ctrl\Asset\AssetCtrl;
use FFBlock\Ctrl\Hook\HookCtrl;
use FFBlock\Ctrl\StyleGenerator;
use FFBlock\Ctrl\BlockCtrl;
use FFBlock\Ctrl\FontLoader;

class MainCtrl
{

	public function __construct()
	{
		new AssetCtrl();
		new HookCtrl();
		new BlockCtrl();
		StyleGenerator::getInstance();
		FontLoader::getInstance();
	}
}
