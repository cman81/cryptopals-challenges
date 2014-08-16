<?php
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

  /**
   * XOR against a single byte character
   * the 'single character' is an 8-bit character (not hex, not base64)
   * the result is encoded in ascii (not base64)
   */
  function single_byte_cipher($hex_input, $index) {
    // create an array of 2-digit words to XOR against
    $hex = str_split($hex_input, 2);

    // convert to an array of integers
    $int = array();
    foreach ($hex as $value) {
      $int[] = hex_to_int($value[0]) * 16 + hex_to_int($value[1]);
    }

    // perform XOR
    $phrase = '';
    foreach ($int as $value) {
      $phrase .= chr($value ^ $index);
    }

    // generate score based on letter frequency
    $letter_freq_map = array_reverse(str_split('etaoinsrhdlucmfywgpbvkxqjz'));
    
    $letters = str_split(strtolower($phrase));
    $score = 0;
    foreach ($letters as $value) {
      foreach ($letter_freq_map as $k => $v) {
        if ($value == $v) {
          $score += $k;
          break;
        }
      }
    }

    return array(
      'hex_input' => $hex_input,
      'char' => chr($index),
      'score' => $score,
      'phrase' => $phrase,
    );
  }

  function get_best_guess($hex_string, $limit = 0) {
    $candidates = array();
    for ($i = 0; $i < 256; $i++) {
      $candidates[] = single_byte_cipher($hex_string, $i, $j);
    }
    usort($candidates, 'highest_score_first');
    return ($limit > 0) ? array_slice($candidates, 0, $limit) : $candidates;
  }

  function highest_score_first($a, $b) {
    if ($a['score'] == $b['score']) {
        return 0;
    }
    return ($a['score'] > $b['score']) ? -1 : 1;
  }

  var_dump(array(
    's1c1' => hex_to_base64('49276d206b696c6c696e6720796f757220627261696e206c696b65206120706f69736f6e6f7573206d757368726f6f6d'),
    's1c2' => fixed_xor('1c0111001f010100061a024b53535009181c', '686974207468652062756c6c277320657965'),
    's1c3' => get_best_guess('1b37373331363f78151b7f2b783431333d78397828372d363c78373e783a393b3736', 2),
  ));
