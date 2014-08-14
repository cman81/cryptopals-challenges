<?php

  function hex_to_base64($hex) {
    $hex = strtolower($hex);
    
    // loop through characters to create an array of 4-digit binary words
    foreach ($hex as $char) {
      // convert A-F to integer
      // convert into 4-digit binary
    }

    // join array to form really long binary string
    
    // pad with 0 until string length is equally divisible by 6

    // split string into array of 6-digit words, loop
    
    // convert word into a base64 character
    
    // join to form string of base64 characters, return
  }
