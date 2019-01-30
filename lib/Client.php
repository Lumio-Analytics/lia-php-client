<?php
/**
 * Copyright © 2019 Lumio Analytics. All rights reserved.
 */

namespace Lumio\IntegrationAPI;

class Client
{
    public static $default_endpoint = 'https://api.lumio.page/integration';
    public static $default_user_agent = 'Lumio\IntegrationAPI 1.0';
    private $endpoint;
    private $user_agent;
    private $debug;
    private $logfile;

    private $success = false;
    private $headers;
    private $status;
    private $curl_result = null;
    private $json = null;

    public function __construct($endpoint = null, $debug = false, $logfile = null, $user_agent = null)
    {
        $this->debug      = $debug;
        $this->endpoint   = is_null($endpoint) ? self::$default_endpoint : $endpoint;
        $this->user_agent = is_null($user_agent) ?
            self::$default_endpoint . ' php v' . phpversion() :
            $default_user_agent;
    }

    public function registerIntegration(\Lumio\IntegrationAPI\Model\Integration $integration)
    {
        if (! $this->qualify($integration) && ! $this->debug) {
            return;
        }

        $this->initCurl($this->endpoint);
        $this->verbThePayload('POST', "" . $integration);
        if ($this->status == 200) {
            $this->success = true;
            $this->log("Registration result " . $this->status . ": Ok!");
        } elseif ($this->status >= 200 && $this->status <= 299 || $this->status == 409) {
            $this->json = json_decode($this->curl_result, true); // return array, not object
            $this->log("Registration result " . $this->status . ": " . $this->curl_result);
        }
        curl_close($this->ch);
    }

    public function qualify(\Lumio\IntegrationAPI\Model\Integration $integration)
    {
        return $integration->validate();
    }

    private function initCurl($url)
    {
        $this->success = $this->json = null;
        $this->ch      = curl_init($url);
        //curl_setopt($this->ch, CURLOPT_USERPWD, $this->_user . ':' . $this->_password);
        curl_setopt($this->ch, CURLOPT_USERAGENT, $this->user_agent);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_FAILONERROR, false);
        // Some versions of openssl seem to need this
        // http://www.supermind.org/blog/763/solved-curl-56-received-problem-2-in-the-chunky-parser
        curl_setopt($this->ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        // From http://it.toolbox.com/wiki/index.php/Use_curl_from_PHP_-_processing_response_headers
        curl_setopt($this->ch, CURLOPT_HEADERFUNCTION, array(&$this, 'storeHeaders'));
        $this->headers = '';
    }

    private function verbThePayload($verb, $payload)
    {
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $verb);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $payload);
        if ($this->debug) {
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        }
        curl_setopt(
            $this->ch,
            CURLOPT_HTTPHEADER,
            array(
                'Accept: application/json',
                'Content-Type: application/json',
                'Content-Length: ' . strlen($payload)
            )
        );
        $this->sendRequest();
    }

    private function sendRequest()
    {
        $this->curl_result = curl_exec($this->ch);
        $this->status      = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
    }

    private function log($msg)
    {
        if (!$this->debug) {
            return;
        }
        if (!$this->logfile) {
            error_log($msg);
        } else {
            error_log($msg . "\n", 3, $this->logfile);
        }
    }

    public function succeeded()
    {
        return $this->success;
    }

    public function getJson()
    {
        return $this->json;
    }

    // Private methods below

    public function getStatus()
    {
        return $this->status;
    }

    public function dump()
    {
        echo "Endpoit: \n";
        var_dump($this->endpoint);
        echo "\nStatus: \n";
        var_dump($this->status);
        echo "\njson: \n";
        var_dump($this->json);
        echo "\nsuccess: \n";
        var_dump($this->success);
    }

    private function storeHeaders($ch, $header)
    {
        $this->headers .= $header;

        return strlen($header);
    }
}
