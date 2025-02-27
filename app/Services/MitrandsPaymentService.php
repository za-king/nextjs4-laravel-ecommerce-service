<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MitrandsPaymentService
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = env('MITRANDS_API_URL');
        $this->apiKey = env('MITRANDS_API_KEY');
    }

    /**
     * Membuat pembayaran baru di Mitrands
     */
    public function createPayment($amount, $currency, $callbackUrl)
    {
        $response = Http::post("{$this->apiUrl}/create-payment", [
            'amount' => $amount,
            'currency' => $currency,
            'callback_url' => $callbackUrl,
            'api_key' => $this->apiKey,
        ]);

        return $response->json();
    }

    /**
     * Mengecek status pembayaran
     */
    public function checkPaymentStatus($paymentId)
    {
        $response = Http::get("{$this->apiUrl}/payment-status", [
            'payment_id' => $paymentId,
            'api_key' => $this->apiKey,
        ]);

        return $response->json();
    }
}
