<?php

class Base52
{
	const CONVERT_ENCODE = true;

	const CONVERT_DECODE = false;

	const PARSE_CHARACTERS = 'ABCDEFGHIJabcdefghijklmnopqrstuv';
	
	const PARSE_COMPRESS = [
		'K' => 'AA',
		'L' => 'AAA',
		'M' => 'AAAA',
		'N' => 'AAAAA',
		'O' => 'AAAAAA',
		'P' => 'AAAAAAA',
		'Q' => 'AAAAAAAA',
		'R' => 'AAAAAAAAA',
		'S' => 'AAAAAAAAAA',
		'T' => 'AAAAAAAAAAA',
		'U' => 'vv',
		'V' => 'vvv',
		'W' => 'vvvv',
		'X' => 'vvvvv',
		'Y' => 'vvvvvv',
		'Z' => 'vvvvvvv',
		'w' => 'vvvvvvvv',
		'x' => 'vvvvvvvvv',
		'y' => 'vvvvvvvvvv',
		'z' => 'vvvvvvvvvvv'
	];
	
	private static $_convert = null;

	public static function encode($data)
	{
		return self::parse(self::convert($data, self::CONVERT_ENCODE), self::PARSE_COMPRESS, true);
	}

	public static function decode($data)
	{
		return self::convert(self::parse($data, self::PARSE_COMPRESS), self::CONVERT_DECODE);
	}

	private static function parse($data, $replace_pairs, $flip = false)
	{
		return strtr($data, $flip? array_flip($replace_pairs): $replace_pairs);
	}

	private static function convert(&$data, $encode)
	{
		if (self::$_convert === null) {
			self::$_convert = new \Base2n(5, self::PARSE_CHARACTERS);
		}

		return $encode?
			self::$_convert->encode($data):
			self::$_convert->decode($data);
	}
}
