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

?>
<head>
    <meta charset="UTF-8">
    <!--[if IE]>
    <meta http-equiv="x-ua-compatible" content="IE=Edge"/>
    <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="EFLK1QFY5CFu8PzxiTsqZBinXDR8WA5v8KS5nUAl">
    <meta name="root_url" content="<?= HTTPS_SERVER ?>">
    <meta name="base" content="<?= HTTPS_SERVER ?>">

    <title><?= Document::get(Document::TITLE); ?></title>
    <link rel="canonical" href="<?= Document::getOgUrl() ?>"/>
	
	<?php
	$metas = array("keywords", "description");
	foreach($metas as $meta){
		if(${$meta}) ?><meta name="<?= $meta ?>" content="<?= ${$meta} ?>"/>
	<?php }
	
	$og_meta = [
		"site_name" => "CrystalPHP",
		"image" => HTTPS_SERVER . URI_REL_IMG . "/ic/logo/logo.jpg",
		"title" => Document::get(Document::TITLE),
		"description" => Document::get(Document::DESCRIPTION),
		"url" => Document::getOgUrl(),
	];
	foreach($og_meta as $og => $val){ ?>
       <meta property="og:<?= $og ?>" content="<?= $val ?>"/>
	<?php }
	?>
    <meta name="generator" content="CrystalPHP Framework v<?= VERSION; ?> - Crystal Collective"/>
	
	<?php if(isset($icon) && is_file(DIR_IMG . $icon)){
		?>
       <link rel="icon" href="<?= HTTPS_SERVER . URI_REL_IMG . $icon; ?>?" type="image/x-icon">
       <link rel="shortcut icon" href="<?= HTTPS_SERVER . URI_REL_IMG . $icon; ?>?" type="image/x-icon">
	<?php }
	if(isset($icon192) && is_file(DIR_IMG . $icon192)){
		?>
       <link rel="icon" href="<?= HTTPS_SERVER . URI_REL_IMG . $icon192; ?>" type="image/png" sizes="192x192">
	<?php }
	?>
    <link href="<?= HTTPS_SERVER . URI_REL_IMG . "/" ?>ic/logo/apple-touch-icon.png" rel="apple-touch-icon"/>
    <link href="<?= HTTPS_SERVER . URI_REL_IMG . "/" ?>ic/logo/apple-touch-icon-76x76.png" rel="apple-touch-icon" sizes="76x76"/>
    <link href="<?= HTTPS_SERVER . URI_REL_IMG . "/" ?>ic/logo/apple-touch-icon-120x120.png" rel="apple-touch-icon" sizes="120x120"/>
    <link href="<?= HTTPS_SERVER . URI_REL_IMG . "/" ?>ic/logo/apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152"/>
    <link href="<?= HTTPS_SERVER . URI_REL_IMG . "/" ?>ic/logo/apple-touch-icon-192x192.png" rel="apple-touch-icon" sizes="192x192"/>

    <meta http-equiv="Content-Security-Policy"
          content="default-src *; style-src 'self' http://* https://* 'unsafe-inline'; img-src 'self' data: http://* https://* 'unsafe-inline' 'unsafe-eval'; script-src 'self' http://* https://* 'unsafe-inline' 'unsafe-eval'; font-src 'self' http://* https://* 'unsafe-inline' 'unsafe-eval' ;"/>
    <link href="https://fonts.googleapis.com/css?family=Comfortaa|Concert+One" rel="stylesheet" media="none" onload="if(this.media!='all')this.media='all'">
    <link href="https://fonts.googleapis.com/css?family=Anton|Coiny|Felipa|Josefin+Sans|Josefin+Slab:400,600|Lato|Maven+Pro|Oswald|Titillium+Web|Ubuntu|ZCOOL+QingKe+HuangYou" rel="stylesheet"
          media="none" onload="if(this.media!='all')this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Comfortaa|Concert+One">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Anton|Coiny|Felipa|Josefin+Sans|Josefin+Slab:400,600|Lato|Maven+Pro|Oswald|Titillium+Web|Ubuntu|ZCOOL+QingKe+HuangYou">
    </noscript>
	<?php
	foreach(Document::getStyleLinks() as $styleLink){
		echo "\t<link";
		foreach($styleLink as $key => $value) echo " $key='$value'";
		echo ">\n";
	}
	?>
    <style><?= Document::getStyles(true) . Document::getStylesPageStr(); ?></style>
</head>
