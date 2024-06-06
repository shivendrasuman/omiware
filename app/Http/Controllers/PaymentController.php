<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Paymentrequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    protected $omconfig;

    public function __construct()
    {
        $this->omconfig = (object) Config::get('omiwaregateway');
    }
    public function index(Request $request)
    {
        $search = $request->input('s');
        $perPage = 10;
        $currentPage = $request->input('page');
        $where = [];
        if (!empty($search)) {
            //$where['order_id'] = $search;
            $where['transaction_id'] = $search;
        }
        $PaymnetData = Paymentrequest::where($where)
            ->orderBy('creation_datetime', 'DESC')
            ->paginate($perPage);
        return view('paymenthistory', compact('PaymnetData', 'currentPage', 'perPage'));
    }

    public function submitresponse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_price' => 'required|numeric|min:5|max:50',
            'user_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'user_mobile' => 'required|numeric',
            'user_email' => 'required|email',
            'user_address' => 'required',
            'user_address2' => 'required',
            'country' => 'required',
            'state' => 'required|regex:/^[\pL\s\-]+$/u',
            'city' => 'required|regex:/^[\pL\s\-]+$/u',
            'zip' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->route('/')
                ->withInput()
                ->withErrors($validator);
        }
        try {
            //store payment data in database
           $postData = $this->storePaymentData($request);
            if ($postData) {
                $api_key = $this->omconfig->api_key;
                $postData['api_key'] = $api_key;
                $postData['return_url'] = url($this->omconfig->return_url);
                $postData['hash'] = $this->generateHashKey($postData, $this->omconfig->salt);
                $api_url = $this->omconfig->api_url;
                $encryption_key = $this->omconfig->req_encryption_key;
                $EncryptPostData = $this->encryptData(json_encode($postData), $encryption_key);
                $encrypted_data = $EncryptPostData[0];
                $iv = $EncryptPostData[1];
                return view('paymentsubmit', compact('api_url', 'encrypted_data', 'iv', 'api_key', 'postData'));
            } else {
                $errormessage = 'somthing went wrong! Please try again later.';
                return redirect()
                    ->route('/')
                    ->withErrors(['errorMessage' => $errormessage]);
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            return redirect()
                ->route('/')
                ->withErrors(['errorMessage' => $exception]);
        }
    }

    public function response(Request $request)
    {
        $api_key = isset($request->api_key) && !empty($request->api_key) ? $request->api_key : '';
        $encrypted_data = isset($request->encrypted_data) && !empty($request->encrypted_data) ? $request->encrypted_data : '';
        $iv = isset($request->iv) && !empty($request->iv) ? $request->iv : '';
        //validate api key and data
        if (empty($iv) || empty($api_key) || $api_key != $this->omconfig->api_key) {
            $errormessage = 'Sorry! we are facing issues to validate your paymante.';
            return redirect()
                ->route('/')
                ->withErrors(['errorMessage' => $errormessage]);
        }

        $decryption_key = $this->omconfig->res_decryption_key;
        $DecreptedResonseDatajson = $this->decryptData($encrypted_data, $decryption_key, $iv);
        $DecreptedResponseData = json_decode($DecreptedResonseDatajson, true);
        //validate hash for data security
        $validateHash = $this->paymentResponseValidte($DecreptedResponseData);

        // $validateHash = true;
        if ($validateHash) {
            //update database
            $orderID = $DecreptedResponseData['order_id'];
            $response_code = $DecreptedResponseData['response_code'];
            $Paymnetrequest['response_code'] = $response_code;
            $Paymnetrequest['payment_status'] = Lang::get("omniresponsecode.$response_code") ?? 'N/A';
            $Paymnetrequest['transaction_id'] = $DecreptedResponseData['transaction_id'];
            $Paymnetrequest['payment_channel'] = $DecreptedResponseData['payment_channel'];
            $Paymnetrequest['payment_mode'] = $DecreptedResponseData['payment_mode'];
            $Paymnetrequest['payment_datetime'] = $DecreptedResponseData['payment_datetime'];
            $Paymnetrequest['response_message'] = $DecreptedResponseData['response_message'];

            $PaymentUpdate = Paymentrequest::where('order_id', $orderID)->update($Paymnetrequest);
            return view('paymentsuccess', compact('DecreptedResponseData'));
        } else {
            $errormessage = $DecreptedResponseData['response_message'] ?? 'Sorry! we are facing issues to validate your paymante.';
            return redirect()
                ->route('/')
                ->withErrors(['errorMessage' => $errormessage]);
        }
    }

    public function refund($id)
    {
        $orderID = Crypt::decrypt($id); //order id
        $PaymentRequestArray = Paymentrequest::where('order_id', '=', $orderID)->first();
        $amount = $PaymentRequestArray['amount'];
        $currency = $PaymentRequestArray['currency'];
        $refundDataset = ['api_key' => $this->omconfig->api_key, 'amount' => $amount, 'description' => $PaymentRequestArray['description'], 'transaction_id' => $PaymentRequestArray['transaction_id']];
        $refundHash = $this->generateHashKey($refundDataset, $this->omconfig->salt);
        $refundDataset['hash'] = $refundHash;
        $refundResponseSet = Http::post($this->omconfig->api_refund, [
            'hash' => $refundDataset['hash'],
            'api_key' => $refundDataset['api_key'],
            'amount' => $refundDataset['amount'],
            'description' => $refundDataset['description'],
            'transaction_id' => $refundDataset['transaction_id'],
        ]);
        $refundResponseData = json_decode($refundResponseSet, true);
        $errorCode = isset($refundResponseData['error']['code']) && !empty($refundResponseData['error']['code']) ? $refundResponseData['error']['code'] : '';
        $errorMessage = isset($refundResponseData['error']['message']) && !empty($refundResponseData['error']['message']) ? $refundResponseData['error']['message'] : '';
        $transaction_id = isset($refundResponseData['data']['transaction_id']) && !empty($refundResponseData['data']['transaction_id']) ? $refundResponseData['data']['transaction_id'] : '';
        $refund_id = isset($refundResponseData['data']['refund_id']) && !empty($refundResponseData['data']['refund_id']) ? $refundResponseData['data']['refund_id'] : '';
        $refund_reference_no = isset($refundResponseData['data']['refund_reference_no']) && !empty($refundResponseData['data']['refund_reference_no']) ? $refundResponseData['data']['refund_reference_no'] : '';
        $merchant_order_id = isset($refundResponseData['data']['merchant_order_id']) && !empty($refundResponseData['data']['merchant_order_id']) ? $refundResponseData['data']['merchant_order_id'] : '';

        if (!$errorCode) {
            //update database if no error
            $updateRefundData = ['refund_id' => $refund_id, 'refund_reference_no' => $refund_reference_no, 'payment_status' => 'REFUND-INITIATED'];
            $refundtUpdate = Paymentrequest::where('order_id', $merchant_order_id)
                ->where('transaction_id', $transaction_id)
                ->update($updateRefundData);
        }

        return view('refundstatus', compact('amount', 'currency', 'errorCode', 'errorMessage', 'merchant_order_id', 'refund_id', 'refund_reference_no', 'transaction_id'));
    }

/**
 * @param $request
 * 
 * @return array|boolean
 */
    public function storePaymentData($request){
        $orderID = $this->generateUniqueCode(); //generate order id
            $Product_description = $this->omconfig->default_parameters['description'];
            $postData['order_id'] = $orderID;
            $postData['amount'] = number_format((float) $request->input('product_price'), 2, '.', '');
            $postData['name'] = $request->input('user_name');
            $postData['email'] = $request->input('user_email');
            $postData['phone'] = substr(preg_replace('/^\+?1|\|1|\D/', '', $request->input('user_mobile')), -10);
            $postData['address_line_1'] = $request->input('user_address');
            $postData['address_line_2'] = $request->input('user_address2');
            $postData['country'] = $request->input('country');
            $postData['state'] = $request->input('state');
            $postData['city'] = $request->input('city');
            $postData['zip_code'] = $request->input('zip');
            $postData['currency'] = $this->omconfig->default_parameters['currency'];
            $postData['description'] = isset($Product_description) && !empty($Product_description) ? $Product_description : $this->omconfig->default_parameters['description'];
            $postData['mode'] = $this->omconfig->mode;
            $postData['creation_datetime']= date("Y-m-d h:i:s");
            $StoreData = Paymentrequest::insert($postData); // save data first in database
            return $StoreData ? $postData: false;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function generateUniqueCode()
    {
        do {
            $uuid = 'omni' . random_int(100000000, 999999999);
        } while (Paymentrequest::where('order_id', '=', $uuid)->first());

        return $uuid;
    }

    /**
     * AES-256-CBC Encryption method, First it encrypts the data and then encodes it to base64
     * @param string $plain_data Plain text Data to be encrypted
     * @param string $encryption_key Provided by Payment Gateway
     * @return array
     */
    function encryptData($plain_data, $encryption_key)
    {
        $iv = openssl_random_pseudo_bytes(16); //random 16 byte/char long string or unixtimestamp(10chars)+random-string(6chars) time().mt_rand(100000, 999999)
        $encrypted = openssl_encrypt($plain_data, 'AES-256-CBC', $encryption_key, OPENSSL_RAW_DATA, $iv);
        return [base64_encode($encrypted), base64_encode($iv)];
    }
    /**
     * AES-256-CBC Decryption method, First it decodes base64 encoded encrypted data and
     * then decrypts it to get JSON data string
     * @param String $encrypted_data Encrypted data received in response
     * @param String $decryption_key Provided by Payment Gateway
     * @param String $iv Initial Vector iv as received in response
     */
    function decryptData($encrypted_data, $decryption_key, $iv)
    {
        return openssl_decrypt(base64_decode($encrypted_data), 'AES-256-CBC', $decryption_key, OPENSSL_RAW_DATA, base64_decode($iv));
    }

    /**
     * @param array $parameters
     * @param string $salt
     * @param string $hashing_method
     * @return null|string
     */
    function generateHashKey($parameters, $salt, $hashing_method = 'sha512')
    {
        $secure_hash = null;
        ksort($parameters);
        $hash_data = $salt;
        foreach ($parameters as $key => $value) {
            if (strlen($value) > 0) {
                $hash_data .= '|' . trim($value);
            }
        }
        if (strlen($hash_data) > 0) {
            $secure_hash = strtoupper(hash($hashing_method, $hash_data));
        }
        return $secure_hash;
    }
    /**
     * check server response
     * @param array $responseData
     * @return true|false
     */

    function paymentResponseValidte($responseData)
    {
        $returnstatus = false;
        if (isset($responseData['hash']) && !empty($responseData['hash'])) {
            //generate hash key from response data
            $returnstatus = $this->responseDataHashValidate($responseData);
        }
        return $returnstatus;
    }
    /**
     * @param $responseDataArray
     * @return true|false
     */
    public function responseDataHashValidate($responseDataArray)
    {
        if (is_null($responseDataArray['hash'])) {
            return true;
        }
        $responseDataHash = $responseDataArray['hash'];
        unset($responseDataArray['hash']);
        //generte hash key
        $HashKey = $this->generateHashKey($responseDataArray, $this->omconfig->salt);
        return $HashKey == $responseDataHash ? true : false;
    }
  
}
