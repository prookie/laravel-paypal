<?php

namespace Srmklive\PayPal\Traits\PayPalAPI;

trait PaymentCaptures
{
    /**
     * Show details for a captured payment.
     *
     * @param string $capture_id
     *
     * @throws \Throwable
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @see https://developer.paypal.com/docs/api/payments/v2/#captures_get
     */
    public function showCapturedPaymentDetails(string $capture_id)
    {
        $this->apiEndPoint = "v2/payments/captures/{$capture_id}";

        $this->verb = 'get';

        return $this->doPayPalRequest();
    }

    /**
     * Refund a captured payment.
     *
     * @param string $capture_id
     * @param string $invoice_id
     * @param float  $amount
     * @param string $note
     *
     * @throws \Throwable
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @see https://developer.paypal.com/docs/api/payments/v2/#captures_refund
     */
    public function refundCapturedPayment(string $capture_id, ?string $invoice_id = null, ?string $amount = null, ?string $note = null)
    {
        $this->apiEndPoint = "v2/payments/captures/{$capture_id}/refund";

        $this->options['json'] = [];
        
        if ($amount !== null) {
            $this->options['json']['amount'] = [
                'value'         => $amount,
                'currency_code' => $this->currency,
            ];
        }
        if ($invoice_id !== null) {
            $this->options['json']['invoice_id'] = $invoice_id;
        }
        if ($note !== null) {
            $this->options['json']['note_to_payer'] = $note;
        }

        $this->verb = 'post';

        return $this->doPayPalRequest();
    }
}
