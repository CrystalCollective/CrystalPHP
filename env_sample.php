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

$ENV['mode'] = 'dev';
//$ENV['mode'] = 'prod';

$ENV['cache']['driver'] = 'file';

$ENV['enc']['unique_id'] = '123bbj3r2kbh2Gk5';
$ENV['enc']['key'] = 'c9eRT3j';

$ENV['mail']['driver'] = "smtp";
$ENV['mail']['host'] = "smtp.mailtrap.io";
$ENV['mail']['port'] = 2525;
$ENV['mail']['username'] = "";
$ENV['mail']['password'] = "";
$ENV['mail']['from_address'] = "from@example.com";
$ENV['mail']['from_name'] = "Example";

$ENV['pay']['imojo']['api_key'] = "";
$ENV['pay']['imojo']['auth_token'] = "";
$ENV['pay']['imojo']['salt'] = "";

//current development environment
$ENV['db']['driver'] = 'MySQL';
$ENV['db']['env'] = 'dev2';

//Different Environment configs
$ENV['db']['dev'] = [
	"host_match" => "",
	"host" => "localhost",
	"database" => "dbname",
	"username" => "dbuser",
	"password" => "userpass",
];
$ENV['db']['dev2'] = [
	"host_match" => "abc.com",
	"host" => "localhost",
	"database" => "dbname",
	"username" => "dbuser",
	"password" => "userpass",
];
$ENV['db']['prod'] = [
	"host_match" => "xyz.com",
	"host" => "localhost",
	"database" => "dbname",
	"username" => "dbuser",
	"password" => "userpass",
];

