<?php


namespace App\Http\Controllers;


//use App\Http\Controllers\Controller;

use Carbon\Carbon;
use http\Env\Request;

class KaiOSController extends Controller
{
    public function __construct()
    {
        //
    }
    public function getToken() {
        $hawk = new \Hawk();
        $post_parameters = array(
            "grant_type" => "password",
            "user_name" => "mobeen.khalid@finja.pk",
            "password" => "r3It7sc4GK1dU28eQnaQ7yLVExeNt9OgDfkVlI1Aafs=",
            "scope" => "core",
            "device" => array(
                "device_type" => 10,
                "brand" => "Dell",
                "model" => "Lattitude 7500",
                "reference" => "rewkaf345fa",
                "os" => "Windows",
                "os_version" => "10",
                "device_id" => "0axeWR245ERFewrsaf"
            ),
            "application" => array(
                "id" => "lr9Cts0RhbaNRJ5i_gKf"
            ),
            "partner" => array(
                "id" => "ddsMreKpOJixSvYF5cvz"
            )
        );

        $header = array(
            "Content-Type: application/json",
            "Content-Type: text/plain"
        );

        $params = json_encode($post_parameters);
        $token = $hawk->sendRequest('/oauth2/v1.0/tokens', 'POST', $header, $params);
        print_r($token); die;
    }

    public function getAccounts() {
        $current_timestamp = Carbon::now('UTC')->timestamp;

        $hawk = new \Hawk();
        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'GET', '/core/v1.0/accounts/me', 'rQHTgys7n6AbOP5e6ctqAC8UQeNKUIICmTpfW0zKg4w=');

        $curl = curl_init();
        $header = array(
            "GET /core/v1.0/accounts/me HTTP/1.1",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="VzgiDoRSh4qlc0INYVPK+5RW1O0=", ts='.$current_timestamp.', nonce="'.$nonce.'", mac="'.$compute_header.'"'
        );

        $response = $hawk->sendRequest('/core/v1.0/accounts/me', 'GET', $header);
        print_r($response); die;
    }

    public function notifyPaid() {
        $hawk = new \Hawk();
        $current_timestamp = Carbon::now('UTC')->timestamp;

        $params = json_encode(array('next_pay_dl' => 1591568817), true);

        $encoded_hash = $hawk->normalizePayload($params);
        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'POST',
            '/financier_be/v1.0/devices/192168718812411/notify_paid', 'rQHTgys7n6AbOP5e6ctqAC8UQeNKUIICmTpfW0zKg4w=',
            $encoded_hash);

        $header = array(
            "POST /financier_be/v1.0/devices/192168718812411/notify_paid HTTP/1.1",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="VzgiDoRSh4qlc0INYVPK+5RW1O0=", ts=' . $current_timestamp . ', nonce="' . $nonce . '", hash="' . $encoded_hash . '", mac="' . $compute_header . '"'
        );

        $notify = $hawk->sendRequest('/financier_be/v1.0/devices/192168718812411/notify_paid', 'POST', $header, $params);
        print_r($notify); die;
    }
}
