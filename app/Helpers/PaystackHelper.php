<?php

namespace App\Helpers;

use App\Services\PaystackService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

class PaystackHelper {
    public $paystack;

    public function __construct(PaystackService $paystack)
    {
        $this->paystack = $paystack;
    }
    public function listBanks() {
        try {
            $banks = Cache::remember('paystack_banks', (3600 * 24 * 7), function () {
                $banks = $this->paystack->get_list_of_banks();
                $response = json_decode($banks->getBody(), true);
                $Nigeria_banks = collect($response['data'])->map(function($item) {
                    return [
                        'name' => $item['name'],
                        'code' => $item['code']
                    ];
                })->sortBy('name');

                $banks = $Nigeria_banks->values();

                return response()->success("Banks successfully retrieved", $banks);
            });
            
            return $banks;
        } catch(RequestException $e) {
            if($e->hasResponse()) {
                $response = $e->getResponse();
                $responseBodyAsString = $response->getBody()->getContents();
                Log::critical($responseBodyAsString);
            }
    
            return response()->errorResponse("Error fetching banks", $responseBodyAsString);
    
        } catch(ConnectException $e) {
            return response()->errorResponse("Error connecting to the internet");
        }
    }

    public function resolveAccountNumber($account_number, $bank_code) {
        try {
            $verify_banks = $this->paystack->verifyAccountNumber($account_number, $bank_code);
            $response = json_decode($verify_banks->getBody(), true);

            return response()->success("Banks successfully retrieved", $response);
        } catch(RequestException $e) {
            if($e->hasResponse()) {
                $response = $e->getResponse();
                $responseBodyAsString = $response->getBody()->getContents();
                Log::critical($responseBodyAsString);
            }
    
            return response()->errorResponse("Error Verifying Account Details", $responseBodyAsString);
    
        } catch(ConnectException $e) {
            return response()->errorResponse("Error connecting to the internet");
        }
    }
}
