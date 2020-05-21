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

    public function getDeviceImei()
    {

        $hawk = new \Hawk();
        $current_timestamp = Carbon::now('UTC')->timestamp;
     //   $params = json_encode(array('next_pay_dl' => 1591568817), true);

    //    $encoded_hash = $hawk->normalizePayload($params);
        $nonce = $hawk->generateNonce();


        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'GET',
            '/financier_be/v1.0/devices/192168718812411', 'm5n8EEom2nhkDD2R5K5nq1dhcuAQ8kSXbskaIjQF3Qg=');

        $header = array(
            "GET /financier_be/v1.0/devices/192168718812411 HTTP/1.1",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="0X/IdtuBm1HRdmiQX9SVsZuUOoQ=", ts=' . $current_timestamp . ', nonce="' . $nonce . '",  mac="' . $compute_header . '"'
        );

        $notify = $hawk->sendRequest('/financier_be/v1.0/devices/192168718812411', 'GET', $header);

        print_r($notify); die;
    }





    public function imeiPing()
    {


        $hawk = new \Hawk();
        $current_timestamp = Carbon::now('UTC')->timestamp;
        //   $params = json_encode(array('next_pay_dl' => 1591568817), true);

        //    $encoded_hash = $hawk->normalizePayload($params);
        $nonce = $hawk->generateNonce();


        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'GET',
            '/financier_be/v1.0/devices/192168718812411/ping', 'm5n8EEom2nhkDD2R5K5nq1dhcuAQ8kSXbskaIjQF3Qg=');

        $header = array(
            "GET /financier_be/v1.0/devices/192168718812411/ping HTTP/1.1",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="0X/IdtuBm1HRdmiQX9SVsZuUOoQ=", ts=' . $current_timestamp . ', nonce="' . $nonce . '",  mac="' . $compute_header . '"'
        );

        $notify = $hawk->sendRequest('/financier_be/v1.0/devices/192168718812411/ping', 'GET', $header);

        print_r($notify); die;
    }


    public function massPaymentnotify() {
        $hawk = new \Hawk();
        $current_timestamp = Carbon::now('UTC')->timestamp;
      //  $params = json_encode(array('next_pay_dl' => 1591568817), true);
        $params = json_encode(array("390101540012341" => array("next_pay_dl" => 1591568817),"390101540012343" => array("next_pay_dl" =>1591568817)),true);


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

    public function creditCompletion() {
        $hawk = new \Hawk();
        $current_timestamp = Carbon::now('UTC')->timestamp;
        //  $params = json_encode(array('next_pay_dl' => 1591568817), true);
      //  $params = json_encode(array('"390101540012341":' => array('next_pay_dl' => 1591568817)), true);
      //  return($params);

     //   $encoded_hash = $hawk->normalizePayload($params);
        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'POST',
            '/financier_be/v1.0/devices/192168718812411/notify_credit_completed', 'rQHTgys7n6AbOP5e6ctqAC8UQeNKUIICmTpfW0zKg4w=');

        $header = array(
            "POST /financier_be/v1.0/devices/192168718812411/notify_credit_completed HTTP/1.1",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="VzgiDoRSh4qlc0INYVPK+5RW1O0=", ts=' . $current_timestamp . ', nonce="' . $nonce . '",  mac="' . $compute_header . '"'
        );
        $notify = $hawk->sendRequest('/financier_be/v1.0/devices/192168718812411/notify_credit_completed', 'POST', $header);
        print_r($notify); die;
    }


    public function masscreditCompletionNotify() {

        $hawk = new \Hawk();
        $current_timestamp = Carbon::now('UTC')->timestamp;

          $params = json_encode(array("390101540012341","390101540075318","390101540509512"), true);
        //  $params = json_encode(array('"390101540012341":' => array('next_pay_dl' => 1591568817)), true);
          return($params);

        //   $encoded_hash = $hawk->normalizePayload($params);

        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'POST',
            '/financier_be/v1.0/devices/192168718812411/notify_credit_completed', 'rQHTgys7n6AbOP5e6ctqAC8UQeNKUIICmTpfW0zKg4w=');

        $header = array(
            "POST /financier_be/v1.0/devices/192168718812411/notify_credit_completed HTTP/1.1",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="VzgiDoRSh4qlc0INYVPK+5RW1O0=", ts=' . $current_timestamp . ', nonce="' . $nonce . '",  mac="' . $compute_header . '"'
        );

        $notify = $hawk->sendRequest('/financier_be/v1.0/devices/192168718812411/notify_credit_completed', 'POST', $header);
        print_r($notify); die;
    }


    /*Array
    (
        [refresh_token] => eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJhb2siOnRydWUsImF0aCI6Imhhd2siLCJhdWQiOiJhdXRoLnRlc3Qua2Fpb3N0ZWNoLmNvbSIsImJyYW5kIjoiRGVsbCIsImN1IjoicmV3a2FmMzQ1ZmEiLCJkaWQiOiJOY0NmOXdEUTlwN01yVW1wdWU4ZVhQZl9EQ1hpTmdDUmRCa2hVa0dYUVlsQjZwa1JVN0hSdFl6OVMySmwiLCJkdHlwZSI6IjAiLCJlb2siOnRydWUsImV4cCI6MTU5MDA1MjY5MCwiaWF0IjoxNTg5OTY2MjkwLCJpY2NfbWNjIjowLCJpY2NfbWNjMiI6MCwiaWNjX21uYyI6MCwiaWNjX21uYzIiOjAsImlzcyI6ImF1dGgudGVzdC5rYWlvc3RlY2guY29tIiwianRpIjoidTVmcWZIbHRZREhyZGpCdmpVMzEiLCJtb2RlbCI6IkxhdHRpdHVkZSA3NTAwIiwibW9rIjpmYWxzZSwibmV0X21jYyI6MCwibmV0X21jYzIiOjAsIm5ldF9tbmMiOjAsIm5ldF9tbmMyIjowLCJvcyI6IldpbmRvd3MiLCJvc3YiOiIxMCIsInBpZCI6IiIsInJ0dGwiOjg2NDAwLCJzY3AiOiJyfGNvcmUjYWNjb3VudDpjZHJzdSBjb3JlI2RldmljZTpjZHJzdSBjb3JlI2xiczpjZHJzdSBjb3JlI3B1c2g6Y2Ryc3UgZmluYW5jaWVyI2ZhZG1pbjpjZHJzdSBvYXV0aDI6Y2Ryc3UgcGF5bWVudCNvcHRpb25zOnMgcGF5bWVudCNwcmljZXM6cyBwYXltZW50I3Byb2R1Y3RzOnJzIHBheW1lbnQjcHVyY2hhc2VzOmNkcnUgcGF5bWVudCN0cmFuc2FjdGlvbnM6Y3Igc2MjYXBwczpycyBzYyNtZXRyaWNzOmMiLCJzaWQiOiJscjlDdHMwUmhiYU5SSjVpX2dLZiIsInR0bCI6ODY0MDAsInR5cCI6InJlZnJlc2hfdG9rZW4iLCJ1aWQiOiJOY0NmOXdEUTlwN01yVW1wdWU4ZVhQZl9EQ1hpTmdDUmRCa2hVa0dYIiwidXRwIjoiYWNjb3VudCJ9.jpdP6bmbmJC-VAnIcMQxO0BtQcoMLWymstkbM8CxqWjw94_H36Np6iR9x034fgg-f6JAJhXysrxBqHAfR_k4UGnyM5vmMzcz2ZQK2ZDxSENc0CB_cjYb1oK3rc6QwepSq8v2LkIzoLxntx9oTZHSd13n4H9OwfgN-iXtiaGd54q4x2URdW4z5m3Bmtdrz_FBRqXOHSaMy6276sPSoMQEkmhOOEUDHm2VWbky4TswwkipvaObOH-mOETHDDL6N0z4YwMKABpK9_WLJWvCBAPSXIsjbVAUkuVJa7UIrKtJePYRehPOKnRWFF8gOLZhSKduF7j-APvgC1EyWoFXfs5e0w [token_type] => hawk [scope] => r|core#account:cdrsu core#device:cdrsu core#lbs:cdrsu core#push:cdrsu financier#fadmin:cdrsu oauth2:cdrsu payment#options:s payment#prices:s payment#products:rs payment#purchases:cdru payment#transactions:cr sc#apps:rs sc#metrics:c [expires_in] => 86400 [kid] => 0X/IdtuBm1HRdmiQX9SVsZuUOoQ= [mac_key] => m5n8EEom2nhkDD2R5K5nq1dhcuAQ8kSXbskaIjQF3Qg= [mac_algorithm] => hmac-sha-256 [email_is_valid] => 1 )
    y*/
}
