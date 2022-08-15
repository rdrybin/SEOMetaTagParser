<?php
require('php-punycode-master/punycode.php');


class URLPunicode extends Punycode
{

function punycode_encodeURL($url)
{
	$parts = parse_url($url);
	$out = '';
	if (!empty($parts['scheme'])) $out .= $parts['scheme'] . ':';
	if (!empty($parts['host'])) $out .= '//';
	if (!empty($parts['user'])) $out .= $parts['user'];
	if (!empty($parts['pass'])) $out .= ':' . $parts['pass'];
	if (!empty($parts['user'])) $out .= '@';
	if (!empty($parts['host'])) $out .= $this->encode($parts['host']);
	if (!empty($parts['port'])) $out .= ':' . $parts['port'];
	if (!empty($parts['path'])) $out .= $parts['path'];
	if (!empty($parts['query'])) $out .= '?' . $parts['query'];
	if (!empty($parts['fragment'])) $out .= '#' . $parts['fragment'];

	return $out;
}

function punycode_decodeURL($url)
{
	$parts = parse_url($url);
	$out = '';
	if (!empty($parts['scheme'])) $out .= $parts['scheme'] . ':';
	if (!empty($parts['host'])) $out .= '//';
	if (!empty($parts['user'])) $out .= $parts['user'];
	if (!empty($parts['pass'])) $out .= ':' . $parts['pass'];
	if (!empty($parts['user'])) $out .= '@';
	if (!empty($parts['host'])) $out .= $this->decode($parts['host']);
	if (!empty($parts['port'])) $out .= ':' . $parts['port'];
	if (!empty($parts['path'])) $out .= $parts['path'];
	if (!empty($parts['query'])) $out .= '?' . $parts['query'];
	if (!empty($parts['fragment'])) $out .= '#' . $parts['fragment'];

	return $out;
}

}


