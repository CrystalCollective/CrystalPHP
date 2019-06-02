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
?><!DOCTYPE html>
<html lang="<?= Document::get(Document::LANG) ?>">
<?= $head ?>
<body style="min-height: 100%;margin:0;padding-bottom:50px">
<?= $navbar_top ?>
<div id="page" class="page" style="position: relative;min-height: 100%; margin: 0; padding-bottom: 50px;">
    <div class="page-overlay overlay">
    </div>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="container-fluid ">
					<?= $content ?>
            </div>
        </div>
    </div>
	<?= $footer ?>
</div>
<?= $foot; ?>
</body>
</html>