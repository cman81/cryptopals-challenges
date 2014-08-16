<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

  function hex_to_base64($hex) { // http://cryptopals.com/sets/1/challenges/2/
    $hex = str_split(strtolower($hex));

    // loop through characters to create an array of 4-digit binary words
    $binary_str = ''; // form really long binary string
    foreach ($hex as $char) {
      // convert A-F to integer
      $char = hex_to_int($char);
      // convert into 4-digit binary
      $divisor = 8;
      while ($divisor >= 1) {
        if ($char >= $divisor) {
          $char -= $divisor;
          $binary_str .= '1';
        } else {
          $binary_str .= '0';
        }
        $divisor /= 2;
      }
    }
    
    // pad with 0 until string length is equally divisible by 6
    while (strlen($binary_str) % 6 != 0) {
      $binary_str = '0' . $binary_str;
    }

    // split string into array of 6-digit words, loop
    $six_words = str_split($binary_str, 6);

    // convert word into a base64 character (http://www.garykessler.net/library/base64.html)
    $char_map = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/');
    $base64 = '';
    foreach ($six_words as $value) {
      $digits = str_split($value);
      $multiplier = 1;
      $index = 0;
      while (count($digits)) {
        $this_digit = array_pop($digits);
        if ($this_digit == '1') { $index += $multiplier; }
        $multiplier *= 2;
      }
      $base64 .= $char_map[$index];
    }

    // join to form string of base64 characters, return
    return $base64;
  }

  /**
   * Write a function that takes two equal-length buffers and produces their XOR combination.
   * http://cryptopals.com/sets/1/challenges/2/
   */
  function fixed_xor($a, $b) {
    if (strlen($a) != strlen($b)) {
      return FALSE;
    }

    $a = str_split($a);
    $b = str_split($b);
    $result = '';

    for ($i = 0; $i < count($a); $i++) {
      // decode hex
      $int_a = hex_to_int($a[$i]);
      $int_b = hex_to_int($b[$i]);
      // perform XOR
      $int_result = $int_a ^ $int_b;
      // encode result to hex
      $result .= int_to_hex($int_result);
    }

    return $result;
  }

  function hex_to_int($hex) {
    switch ($hex) {
      case 'a': return 10;
      case 'b': return 11;
      case 'c': return 12;
      case 'd': return 13;
      case 'e': return 14;
      case 'f': return 15;
      default: return intval($hex);
    }
  }

  function int_to_hex($int) {
    $char_map = str_split('0123456789abcdef');
    return $char_map[$int];
  }

  var_dump(hex_to_base64('49276d206b696c6c696e6720796f757220627261696e206c696b65206120706f69736f6e6f7573206d757368726f6f6d'));
  var_dump(fixed_xor('1c0111001f010100061a024b53535009181c', '686974207468652062756c6c277320657965'));
