<?php

class Script_Installed {
  
  // Verifies the script is installed
  function verify() {
    if (function_exists('curl_version')) { // Curl installed
      $url = get_site_url().'/';
      // Curl request
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => $url,
        CURLOPT_SSL_VERIFYPEER, false,
        CURLOPT_FOLLOWLOCATION, true
      ));
      $htmlSource = curl_exec($curl);
      curl_close($curl);
      // Determine if script is installed
      if (strpos($htmlSource, '<script async src="https://www.podbuzzz.com/') > -1) { // Script installed
        return 'installed';
      } else { // Script not installed
        return 'not_installed';
      }
    } else { // Curl not installed
      return 'no_curl';
    }
  }
  
}
