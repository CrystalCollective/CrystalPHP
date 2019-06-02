<?php
/*******************************************************************************
 *
 *   CrystalPHP Framework by Crystal Collective
 *   An open source application development framework for PHP
 *
 *   This file is part of CrystalPHP which is released under the MIT License (MIT)
 *
 *   Copyright (c) 2019 - 2019, Crystal Collective
 *
 *   For the full copyright and license information,
 *   please view the LICENSE file that was distributed with this source code.
 *
 ******************************************************************************/

use CrystalPHP\Document;

foreach(Document::getScriptLinks() as $script_link){
	echo "\t<script";
	foreach($script_link as $key => $value) echo " $key='$value'";
	echo "></script>\n";
}
?>
<script><?= Document::getScripts(true) . Document::getScriptsPageStr(); ?></script>