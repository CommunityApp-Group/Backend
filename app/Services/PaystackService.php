<?php

namespace App\Services;

use GuzzleHttp\Client;

class PaystackService {
    public $secret_key, $client;

    public function __construct()
    {
        $this->secret_key = config('paystack.secret_key');
        $this->client = new Client([
            'base_uri' => config('paystack.base_url'),
            'timeout'  => 3.0, 
            [
                'headers' => [
                    'Accept'     => 'application/json',
                    'Authorization' => 'Bearer '. $this->secret_key
                ]
            ]
        ]);
    }


    public function get_list_of_banks() {
        $list_banks_endpoint = config('paystack.endpoints.list_banks').'?perPage=100&type=nuban';
        return $this->client->request('GET', $list_banks_endpoint);
    }
    public function verifyAccountNumber($acc_no, $bank_code) {
        $list_banks_endpoint = config('paystack.endpoints.resolve_bank')."?account_number={{$acc_no}}&bank_code={{$bank_code}}";
        return $this->client->request('GET', $list_banks_endpoint);
    }

    public function post() {

    }

    public function patch() {

    }

    public function list_banks() {

    }
}