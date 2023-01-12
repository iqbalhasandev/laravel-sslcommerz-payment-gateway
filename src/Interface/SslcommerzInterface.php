<?php

namespace Nanopkg\SslcommerzPaymentGateway\Interface;

interface SslcommerzInterface
{
    /**
     * Make payment
     * @param array $data
     * @return mixed
     */
    function makePayment(array $data);

    /**
     * Order validate
     * @param array $requestData
     * @param string $trxID
     * @param string $amount
     * @param string $currency
     * @return mixed
     */
    function orderValidate(array $requestData, string $trxID, string $amount, string $currency);

    /**
     * Set parameters
     * @param array $data
     * @return mixed
     */
    function setParams(array $data);

    /**
     * Set required info
     * @param array $data
     * @return mixed
     */
    function setRequiredInfo(array $data);

    /**
     * Set customer info
     * @param array $data
     * @return mixed
     */
    function setCustomerInfo(array $data);

    /**
     * Set shipment info
     * @param array $data
     * @return mixed
     */
    function setShipmentInfo(array $data);

    /**
     * Set product info
     * @param array $data
     * @return mixed
     */
    function setProductInfo(array $data);

    /**
     * Set additional info
     * @param array $data
     * @return mixed
     */
    function setAdditionalInfo(array $data);

    /**
     * Set emi info
     * @param array $data
     * @param array $header=[]
     * @param bool $url_verify=false
     * @return mixed
     */
    function callToApi(array $data, array $header = [], bool $url_verify = false);
}
