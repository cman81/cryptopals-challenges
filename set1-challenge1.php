<?php

  function hex_to_base64($hex) {
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
        $divisor = $divisor / 2;
      }
    }
    
    // pad with 0 until string length is equally divisible by 6
    while (strlen($binary_str) % 6 != 0) {
      $binary_str = '0' . $binary_str;
    }

    // split string into array of 6-digit words, loop
    $six_words = str_split($binary_str, 6);

    // convert word into a base64 character
    foreach ($six_words as $value) {

    }

    // join to form string of base64 characters, return

    return $hex;
  }

  print hex_to_base64('49276d206b696c6c696e6720796f757220627261696e206c696b65206120706f69736f6e6f7573206d757368726f6f6d');
