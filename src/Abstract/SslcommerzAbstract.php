<?php

namespace Nanopkg\SslcommerzPaymentGateway\Abstract;

use Nanopkg\SslcommerzPaymentGateway\Interface\SslcommerzInterface;

abstract class SslcommerzAbstract implements SslcommerzInterface
{
    // api url
    protected $api_url;
    // store id
    protected $store_id;
    // store password
    protected $store_password;

    /**
     * Set store id
     * @param $storeID
     * @return void
     */
    protected function setStoreId($store_id): void
    {
        $this->store_id = $store_id;
    }

    /**
     * Getting store id
     * @return string
     */
    protected function getStoreId(): string
    {
        return $this->store_id;
    }

    /**
     * Set store password
     * @param $storePassword
     * @return void
     */
    protected function setStorePassword($store_password): void
    {
        $this->store_password = $store_password;
    }

    /**
     * Getting store password
     * @return string
     */
    protected function getStorePassword(): string
    {
        return $this->store_password;
    }

    /**
     * Set api url
     * @param $url
     * @return void
     */
    protected function setApiUrl($api_url): void
    {
        $this->api_url = $api_url;
    }

    /**
     * Getting api url
     * @return string
     */
    protected function getApiUrl(): string
    {
        return $this->api_url;
    }

    /**
     * Call to api
     * @param $data
     * @param array $header
     * @param bool $setLocalhost
     * @return bool|string
     */
    public function callToApi($data, $header = [], $setLocalhost = false)
    {
        $curl = curl_init();

        if (!$setLocalhost) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // The default value for this option is 2. It means, it has to have the same name in the certificate as is in the URL you operate against.
        } else {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // When the verify value is 0, the connection succeeds regardless of the names in the certificate.
        }

        curl_setopt($curl, CURLOPT_URL, $this->getApiUrl());
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlErrorNo = curl_errno($curl);
        curl_close($curl);

        if ($code == 200 & !($curlErrorNo)) {
            return $response;
        } else {
            return "FAILED TO CONNECT WITH SSLCOMMERZ API";
            //return "cURL Error #:" . $err;
        }
    }

    /**
     * @param $response
     * @param string $type
     * @param string $pattern
     * @return false|mixed|string
     */
    public function formatResponse($response, $type = 'checkout', $pattern = 'json')
    {
        $sslcz = json_decode($response, true);

        if ($type != 'checkout') {
            return $sslcz;
        } else {
            if (!empty($sslcz['GatewayPageURL'])) {
                // this is important to show the popup, return or echo to send json response back
                if (!empty($this->getApiUrl()) && $this->getApiUrl() == 'https://securepay.sslcommerz.com') {
                    $response = json_encode(['status' => 'SUCCESS', 'data' => $sslcz['GatewayPageURL'], 'logo' => $sslcz['storeLogo']]);
                } else {
                    $response = json_encode(['status' => 'success', 'data' => $sslcz['GatewayPageURL'], 'logo' => $sslcz['storeLogo']]);
                }
            } else {
                if (strpos($sslcz['failedreason'], 'Store Credential') === false) {
                    $message = $sslcz['failedreason'];
                } else {
                    $message = "Check the SSLCZ_TESTMODE and SSLCZ_STORE_PASSWORD value in your .env; DO NOT USE MERCHANT PANEL PASSWORD HERE.";
                }
                $response = json_encode(['status' => 'fail', 'data' => null, 'message' => $message]);
            }

            if ($pattern == 'json') {
                return $response;
            } else {
                echo $response;
            }
        }
    }

    /**
     * Redirect to url
     * @param string $url
     * @param bool $permanent
     * @return void
     */
    public function redirect(string $url, $permanent = false): void
    {
        header('Location: ' . $url, true, $permanent ? 301 : 302);
        exit();
    }
}
