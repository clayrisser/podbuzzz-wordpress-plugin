<?php namespace PodBuzzz\Controllers;

class SettingsController {

    /**
     * Updates the PodBuzzz key.
     */
    public function addKey() {
        $response = (object)[];
        if (current_user_can('administrator')) { // Is admin
            $key = $_REQUEST['key'];
            if ($key) {
                update_option('podbuzzz_key', $key);
                $response->message = 'Key successfully updated as '.$key.'.';
                $response->key = $key;
                $response->success = true;
            } else {
                $response->message = 'Enter a valid key.';
                $response->success = false;
            }
        } else { // Not admin
            $response->message = 'You do not have the proper priviledges to update this.';
            $response->success = false;
        }
        header('Content-Type: application/json');
        return json_encode($response);
    }
    
    /**
     * Gets the current PodBuzzz key.
     */
    public function getKey() {
        $response = (object)[];
        if (current_user_can('administrator')) { // Is admin
            $key = get_option('podbuzzz_key');
            if ($key) {
                $response->message = $key;
                $response->key = $key;
                $response->success = true;
            } else {
                $response->message = 'Invalid key';
                $response->success = false;
            }
        } else { // Not admin
            $response->message = 'You do not have the proper priviledges to update this.';
            $response->success = false;
        }
        header('Content-Type: application/json');
        return json_encode($response);
    }
    
    /**
     * Verifies that the PodBuzzz script is installed.
     */
    public function scriptInstalled() {
        $response = (object)[];
        if (current_user_can('administrator')) { // Is admin
            if (function_exists('curl_version')) { // Curl installed
                $response->curl = true;
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
                    $response->message = 'Your podcast widget is installed!';
                    $response->success = true;
                } else { // Script not installed
                    $response->message = 'The script is not installed. Make sure you have a valid key and the plugin is enabled.';
                    $response->success = false;
                }
            } else { // Curl not installed
                $response->curl = false;
                $response->message = 'Cannot check if script is installed without the PHP curl module.';
                $success = false;
            }
        } else { // Not admin
            $response->message = 'You do not have the proper priviledges to update this.';
            $response->success = false;
        }
        header('Content-Type: application/json');
        return json_encode($response);
    }
    
    /**
     * Enables/Disables PodBuzzz.
     */
    public function enableScript() {
        $response = (object)[];
        if (current_user_can('administrator')) { // Is admin
            $enabled = get_option('podbuzzz_enabled');
            $enable = strtolower($_REQUEST['enable']);
            if ($enable == 'true') {
                update_option('podbuzzz_enabled', true);
                $response->message = 'PodBuzzz was enabled.';
                $response->success = true;
            } else if ($enable == 'false') {
                update_option('podbuzzz_enabled', false);
                $response->message = 'PodBuzzz was disabled.';
                $response->success = true;
            } else {
                $response->message = 'You must either enable or disable this option.';
                $response->success = false;
            }
        } else { // Not admin
            $response->message = 'You do not have the proper priviledges to update this.';
            $response->success = false;
        }
        header('Content-Type: application/json');
        return json_encode($response);
    }
    
    /**
     * Enables/Disables PodBuzzz.
     */
    public function scriptIsEnabled() {
        $response = (object)[];
        if (current_user_can('administrator')) { // Is admin
            $enabled = get_option('podbuzzz_enabled');
            if ($enabled) {
                $response->message = 'PodBuzzz script is enabled.';
            } else {
                $response->message = 'PodBuzzz script is not enabled.';
            }
            $response->enabled = $enabled;
            $response->success = true;
        } else { // Not admin
            $response->message = 'You do not have the proper priviledges to update this.';
            $response->success = false;
        }
        header('Content-Type: application/json');
        return json_encode($response);
    }

}
