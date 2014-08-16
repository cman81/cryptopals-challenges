<?php

  function hex_to_base64($hex) { // http://cryptopals.com/sets/1/challenges/1/
    $hex = str_split(strtolower($hex));

    // loop through characters to create an array of 4-digit binary words
    $binary_str = ''; // form really long binary string
    foreach ($hex as $char) {
      // convert A-F to integer
      switch ($char) {
        case 'a': $char = 10; break;
        case 'b': $char = 11; break;
        case 'c': $char = 12; break;
        case 'd': $char = 13; break;
        case 'e': $char = 14; break;
        case 'f': $char = 15; break;
        default: $char = intval($char);
      }
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

  // returns 'SSdtIGtpbGxpbmcgeW91ciBicmFpbiBsaWtlIGEgcG9pc29ub3VzIG11c2hyb29t' as expected!
  print hex_to_base64('49276d206b696c6c696e6720796f757220627261696e206c696b65206120706f69736f6e6f7573206d757368726f6f6d');
