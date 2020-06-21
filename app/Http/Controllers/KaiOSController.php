<?php


namespace App\Http\Controllers;


//use App\Http\Controllers\Controller;

use App\Helpers\Helper;
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

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'GET', '/core/v1.0/accounts/me', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=');

        $curl = curl_init();
        $header = array(
            "GET /core/v1.0/accounts/me HTTP/1.1",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts='.$current_timestamp.', nonce="'.$nonce.'", mac="'.$compute_header.'"'
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
            '/financier_be/v1.0/devices/192168718812411/notify_paid', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=',
            $encoded_hash);

        $header = array(
            "POST /financier_be/v1.0/devices/192168718812411/notify_paid HTTP/1.1",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts=' . $current_timestamp . ', nonce="' . $nonce . '", hash="' . $encoded_hash . '", mac="' . $compute_header . '"'
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
            '/financier_be/v1.0/devices/192168718812411', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=');

        $header = array(
            "GET /financier_be/v1.0/devices/192168718812411 HTTP/1.1",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts=' . $current_timestamp . ', nonce="' . $nonce . '",  mac="' . $compute_header . '"'
        );

        $notify = $hawk->sendRequest('/financier_be/v1.0/devices/192168718812411', 'GET', $header);

        print_r($notify); die;
    }


    public function imeiPing() {
        $current_timestamp = Carbon::now('UTC')->timestamp;

        $hawk = new \Hawk();
        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'GET',
            '/financier_be/v1.0/devices/192168718812411/ping', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=');

        $curl = curl_init();
        $header = array(
            "GET /financier_be/v1.0/devices/192168718812411/ping HTTP/1.1",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts='.$current_timestamp.', nonce="'.$nonce.'", mac="'.$compute_header.'"'
        );

        $response = $hawk->sendRequest('/financier_be/v1.0/devices/192168718812411/ping', 'GET', $header);
        print_r($response); die;
    }


    public function massPaymentnotifyTest() {
        $hawk = new \Hawk();
        $current_timestamp = Carbon::now('UTC')->timestamp;

        $params = json_encode(array("192168718812411" => array("next_pay_dl" => 1595158826)), true);

        $encoded_hash = $hawk->normalizePayload($params);
        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'POST',
            '/financier_be/v1.0/devices/notify_paid', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=',
            $encoded_hash);

        $header = array(
            "POST /financier_be/v1.0/devices/notify_paid HTTP/1.1",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts=' . $current_timestamp . ', nonce="' . $nonce . '", hash="' . $encoded_hash . '", mac="' . $compute_header . '"'
        );

        $notify = $hawk->sendRequest('/financier_be/v1.0/devices/notify_paid', 'POST', $header, $params);
        print_r($notify); die;
    }

    public function massPaymentnotify() {
        $hawk = new \Hawk();
        $current_timestamp = Carbon::now('UTC')->timestamp;
      //  $params = json_encode(array('next_pay_dl' => 1591568817), true);
        $params = json_encode(array("192168718812411" => array("next_pay_dl" => 1595158826)),true);
//        dd($params);

        $encoded_hash = $hawk->normalizePayload($params);
        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'POST',
            '/financier_be/v1.0/devices/notify_paid', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=',
            $encoded_hash);

        $header = array(
            "POST /financier_be/v1.0/devices/notify_paid HTTP/1.1",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts=' . $current_timestamp . ', nonce="' . $nonce . '", hash="' . $encoded_hash . '", mac="' . $compute_header . '"'
        );

        $notify = $hawk->sendRequest('/financier_be/v1.0/devices/notify_paid', 'POST', $header, $params);
        print_r($notify); die;
    }

    public function creditCompletion() {
        $hawk = new \Hawk();
        $current_timestamp = Carbon::now('UTC')->timestamp;

        $params = json_encode(array("390101540075318"), true);

        $encoded_hash = $hawk->normalizePayload($params);
        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'POST',
            '/financier_be/v1.0/devices/390101540075318/notify_credit_completed', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=',
            $encoded_hash);

        $header = array(
            "POST /financier_be/v1.0/devices/390101540075318/notify_credit_completed HTTP/1.1",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts=' . $current_timestamp . ', nonce="' . $nonce . '", hash="' .$encoded_hash. '", mac="' . $compute_header . '"'
        );

        $notify = $hawk->sendRequest('/financier_be/v1.0/devices/390101540075318/notify_credit_completed', 'POST', $header, $params);
        print_r($notify); die;
    }


    public function masscreditCompletionNotifyTest() {
        $hawk = new \Hawk();
        $current_timestamp = Carbon::now('UTC')->timestamp;

        $params = json_encode(array("192168718812411","390101540075318","390101540509512"), true);

        $encoded_hash = $hawk->normalizePayload($params);
        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'POST',
            '/financier_be/v1.0/devices/notify_paid', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=',
            $encoded_hash);

        $header = array(
            "POST /financier_be/v1.0/devices/notify_paid HTTP/1.1",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts=' . $current_timestamp . ', nonce="' . $nonce . '", hash="' . $encoded_hash . '", mac="' . $compute_header . '"'
        );

        $notify = $hawk->sendRequest('/financier_be/v1.0/devices/notify_paid', 'POST', $header, $params);
        print_r($notify); die;
    }

    public function masscreditCompletionNotify() {

        $hawk = new \Hawk();
        $current_timestamp = Carbon::now('UTC')->timestamp;

          $params = json_encode(array("390101540012341","390101540075318","390101540509512"), true);
        //  $params = json_encode(array('"390101540012341":' => array('next_pay_dl' => 1591568817)), true);
     //     return($params);

        //   $encoded_hash = $hawk->normalizePayload($params);

        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'POST',
            '/financier_be/v1.0/devices/192168718812411/notify_credit_completed', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=');

        $header = array(
            "POST /financier_be/v1.0/devices/192168718812411/notify_credit_completed HTTP/1.1",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts=' . $current_timestamp . ', nonce="' . $nonce . '",  mac="' . $compute_header . '"'
        );

        $notify = $hawk->sendRequest('/financier_be/v1.0/devices/192168718812411/notify_credit_completed', 'POST', $header);
        print_r($notify); die;
    }

    public function challenges() {

        $current_timestamp = Carbon::now('UTC')->timestamp;

        $hawk = new \Hawk();
        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'POST',
            '/oauth2/v1.0/challenges', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=');

        $curl = curl_init();
        $header = array(
            "POST /oauth2/v1.0/challenges",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts='.$current_timestamp.', nonce="'.$nonce.'", mac="'.$compute_header.'"'
        );
        $response = $hawk->sendRequest('/oauth2/v1.0/challenges', 'POST', $header);
        print_r($response); die;
    }

    public function challengeCompletion() {

        $hawk = new \Hawk();
        $current_timestamp = Carbon::now('UTC')->timestamp;
        $params = json_encode(array("challenge_id"=>"e2NiOgogbh6b25X3p2TQ",
            "service_id" => "e2NiOgogbh6b25X3p2TQ","device_type"=>array("device_type"=>10,
            "brand"=> "AlcatelOneTouch",
            "model"=> "GoFlip2","reference"=>"4044O-2AAQUS0",
            "reference"=> "4044O-2AAQUS0",
            "os"=> "KaiOS",
            "os_version"=> "2.5",
            "device_id" => "453219216871884",
            "icc_mcc" => "04",
            "icc_mnc"=> "321",
            "net_mnc"=> "321",
            )), true);


        $encoded_hash = $hawk->normalizePayload($params);


        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'PUT',
            '/oauth2/v1.0/challenges/e2NiOgogbh6b25X3p2TQ', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=',$encoded_hash);

        $header = array(
            "PUT /oauth2/v1.0/challenges/e2NiOgogbh6b25X3p2TQ",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts=' . $current_timestamp . ', nonce="' . $nonce . '",  mac="' . $compute_header . '"'
        );

        $notify = $hawk->sendRequest('/oauth2/v1.0/challenges/e2NiOgogbh6b25X3p2TQ', 'PUT', $header,$params);
        print_r($notify); die;
    }


    public function secureToken() {

        $hawk = new \Hawk();
        $current_timestamp = Carbon::now('UTC')->timestamp;
        $params = json_encode(array("imei"=>"453219216871884",
            "service_id" => "e2NiOgogbh6b25X3p2TQ","data"=>"iCRbf7xosZoM7uwPjjaw9Xhx0ICU5ybq7JVwzAR4yxfoMYiS7n5hFoRdJ5LM0GIsuAyIcQU2t0x2
1+7jAiFSQt7OK4Jj6rf+j1l83K1StYKSfrTl6TrUyfIzwQYNme2e+yLWp3sRvvzd8Sa90udVHD3DC1X1Oyeiq6RNqAY
CEg0+ZHnuphpm+58aSLBQtqfBfK5wpLR8Ncm7OmRbaV+zJrZJBZeJ6lVBUYOKBNzE9+OeKfXstVxxUjP4GKF7xE
tmmZ3FUFb463QC6ef6+IIip52vnBZCIn8Wh5slPOPMzshbbkUmlItCWPnXEbF08djrGe3JbglZZjOK8+38jVgEJlN
Oeictg1UsEBj9f6DD7I4KQo="), true);



        $encoded_hash = $hawk->normalizePayload($params);


        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'POST',
            '/oauth2/v1.0/secured_tokens', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=',$encoded_hash);

        $header = array(
            "POST /oauth2/v1.0/secured_tokens",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts=' . $current_timestamp . ', nonce="' . $nonce . '",  mac="' . $compute_header . '"'
        );

        $notify = $hawk->sendRequest('/oauth2/v1.0/secured_tokens', 'POST', $header,$params);
        print_r($notify); die;
    }


    public function pushsubs() {

        $hawk = new \Hawk();
        $current_timestamp = Carbon::now('UTC')->timestamp;
        $params = json_encode(array("push_type"=>5000,
            "push_subsc" => "eyJlbmRwb2ludCI6Imh0dHBzOi8vcHVzaC5rYWlvc3RlY2guY29tOjg0NDMvd3B1c2gvdjIvZ0FBQUFBQmM5YX
NETWNOMTM4cFJtLTFDcTY3ZkZWdWRBS2pJcGRucU1CT1AyYlFKakoxZG9Zd2o4OUZVSGZpWUt4NVBLbjNQ
czJSWXFsTHNjLXR1OTdrWnNFdHJYV0QwVmtTWkxsdXRlMEFYalhMRFFQVFdxM0JLTU9HRF9DbnpFcFM2VVJ
6alBNcHI3bW9TaWVJWTNMZ2QxZlVGbXRLcXhfcHBMeGp3RzZROWZ6REVsT2lLM0UwIiwia2V5cyI6eyJhdXR
oIjoiNGRxcWk3QWRGOGw0S25GcTFabzMxUSIsInAyNTZkaCI6IkJCM1M3SVpuUHIwckctT1FJRXo1NzVabHFTR
3ZpQS0yUF9vYnlHUk13Yk5HdDBPY2NFbk13S3lJSy0wSkNFZGVYcndwN2JRb0tuelc3N2lWLVhtYkt2NCJ9fQ==","app_id"=>"e2NiOgogbh6b25X3p2TQ"), true);


        $encoded_hash = $hawk->normalizePayload($params);


        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'POST',
            '/financier_fe/v1.0/pushsubs', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=',$encoded_hash);

        $header = array(
            "POST /oauth2/v1.0/secured_tokens",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts=' . $current_timestamp . ', nonce="' . $nonce . '",  mac="' . $compute_header . '"'
        );

        $notify = $hawk->sendRequest('/financier_fe/v1.0/pushsubs', 'POST', $header,$params);
        print_r($notify); die;
    }



    public function pingResponse() {

        $hawk = new \Hawk();
        $current_timestamp = Carbon::now('UTC')->timestamp;
        $params = json_encode(array("next_reminder"=> 1560187101,
                                    "reminder_executed"=>2,
                                    "next_warning"=> 1565419925,
                                    "warning_executed"=>2,
                                    "next_overdue"=>1569500000,
                                    "overdue_execured"=>1,
                                    "next_lock"=>1569540362,
                                    "lock_executed"=>1
                                    ), true);


        $encoded_hash = $hawk->normalizePayload($params);

        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'PUT',
            '/oauth2/v1.0/challenges/e2NiOgogbh6b25X3p2TQ', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=',$encoded_hash);

        $header = array(
            "PUT /oauth2/v1.0/challenges/e2NiOgogbh6b25X3p2TQ",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts=' . $current_timestamp . ', nonce="' . $nonce . '",  mac="' . $compute_header . '"'
        );

        $notify = $hawk->sendRequest('/oauth2/v1.0/challenges/e2NiOgogbh6b25X3p2TQ', 'PUT', $header,$params);
        print_r($notify); die;
    }


    public function deviceFetchCommands() {
        $current_timestamp = Carbon::now('UTC')->timestamp;

        $hawk = new \Hawk();
        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'GET',
            '/financier_fe/v1.0/cmds', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=');

        $curl = curl_init();
        $header = array(
            "GET /financier_fe/v1.0/cmds",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts='.$current_timestamp.', nonce="'.$nonce.'", mac="'.$compute_header.'"'
        );

        $response = $hawk->sendRequest('/financier_fe/v1.0/cmds', 'GET', $header);
        print_r($response); die;
    }


    public function deviceAckCommandExecution() {
        $current_timestamp = Carbon::now('UTC')->timestamp;

        $hawk = new \Hawk();
        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'DELETE',
            '/financier_fe/v1.0/cmds/{msg id}?ack=true', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=');

        $curl = curl_init();
        $header = array(
            "DELETE /financier_fe/v1.0/cmds/{msg id}?ack=true",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts='.$current_timestamp.', nonce="'.$nonce.'", mac="'.$compute_header.'"'
        );

        $response = $hawk->sendRequest('/financier_fe/v1.0/cmds/{msg id}?ack=true', 'DELETE', $header);
        print_r($response); die;
    }


    public function deviceFinancierRegistrationInitiation() {

        $hawk = new \Hawk();
        $current_timestamp = Carbon::now('UTC')->timestamp;
        $params = json_encode(array("imei" => "453219216871884"),
                                    true);

        $encoded_hash = $hawk->normalizePayload($params);

        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'POST',
            '/financier_fe/v1.0/registrations', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=',$encoded_hash);

        $header = array(
            "POST /financier_fe/v1.0/registrations",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts=' . $current_timestamp . ', nonce="' . $nonce . '",  mac="' . $compute_header . '"'
        );

        $notify = $hawk->sendRequest('/financier_fe/v1.0/registrations', 'POST', $header,$params);
        print_r($notify); die;
    }


    public function deviceFinancierRegistrationCompletion() {

            $current_timestamp = Carbon::now('UTC')->timestamp;

            $hawk = new \Hawk();
            $nonce = $hawk->generateNonce();

            $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'PUT',
                '/financier_fe/v1.0/registrations/{id}', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=');

            $curl = curl_init();
            $header = array(
                "PUT /financier_fe/v1.0/registrations/{id}",
                "Host: api.test.kaiostech.com:443",
                "Content-Type: application/json",
                "Content-Size: 1255",
                'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts='.$current_timestamp.', nonce="'.$nonce.'", mac="'.$compute_header.'"'
            );

            $response = $hawk->sendRequest('/financier_fe/v1.0/registrations/{id}', 'PUT', $header);
            print_r($response); die;
        }

    public function fetchAllDevices() {

        $current_timestamp = Carbon::now('UTC')->timestamp;

        $hawk = new \Hawk();
        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'PUT',
            '/financier_be/v1.0/devices', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=');

        $curl = curl_init();
        $header = array(
            "GET /financier_be/v1.0/devices",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts='.$current_timestamp.', nonce="'.$nonce.'", mac="'.$compute_header.'"'
        );

        $response = $hawk->sendRequest('/financier_be/v1.0/devices', 'GET', $header);
        print_r($response); die;
    }




    public function fetchSpecificDeviceOfanAccount() {

        $current_timestamp = Carbon::now('UTC')->timestamp;

        $hawk = new \Hawk();
        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'PUT',
            '/financier_be/v1.0/devices/{imei}', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=');

        $curl = curl_init();
        $header = array(
            "GET /financier_be/v1.0/devices/{imei}",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts='.$current_timestamp.', nonce="'.$nonce.'", mac="'.$compute_header.'"'
        );

        $response = $hawk->sendRequest('/financier_be/v1.0/devices/{imei}', 'GET', $header);
        print_r($response); die;
    }


    public function fetchRealTimeDeviceStatus() {

        $current_timestamp = Carbon::now('UTC')->timestamp;

        $hawk = new \Hawk();
        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'PUT',
            '/financier_be/v1.0/devices/{imei}/ping', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=');

        $curl = curl_init();
        $header = array(
            "GET /financier_be/v1.0/devices/{imei}/ping",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts='.$current_timestamp.', nonce="'.$nonce.'", mac="'.$compute_header.'"'
        );

        $response = $hawk->sendRequest('/financier_be/v1.0/devices/{imei}/ping', 'GET', $header);
        print_r($response); die;
    }

    public function fetchCmdQueueofSpecificDevice() {

        $current_timestamp = Carbon::now('UTC')->timestamp;

        $hawk = new \Hawk();
        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'PUT',
            '/financier_be/v1.0/devices/{imei}/cmd[?deleted=true]', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=');

        $curl = curl_init();
        $header = array(
            "GET /financier_be/v1.0/devices/{imei}/cmd[?deleted=true]",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts='.$current_timestamp.', nonce="'.$nonce.'", mac="'.$compute_header.'"'
        );

        $response = $hawk->sendRequest('/financier_be/v1.0/devices/{imei}/cmd[?deleted=true]', 'GET', $header);
        print_r($response); die;
    }


    public function notifyDeviceInstallmentPayment() {

        $hawk = new \Hawk();
        $current_timestamp = Carbon::now('UTC')->timestamp;
        $params = json_encode(array(
            "next_pay_dl"=> 1569540362,
            "next_reminder"=> 1560187101,
            "next_warning"=> 1565419925,
            "next_overdue"=> 1569500000,
            "next_lock"=> 1569540362
        ), true);

        $encoded_hash = $hawk->normalizePayload($params);

        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'POST',
            '/financier_be/v1.0/devices/{imei}/notify_paid', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=',$encoded_hash);

        $header = array(
            "POST /financier_be/v1.0/devices/{imei}/notify_paid",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts=' . $current_timestamp . ', nonce="' . $nonce . '",  mac="' . $compute_header . '"'
        );

        $notify = $hawk->sendRequest('/financier_be/v1.0/devices/{imei}/notify_paid', 'POST', $header,$params);
        print_r($notify); die;
    }


    public function massDevicePayment() {

        $hawk = new \Hawk();
        $current_timestamp = Carbon::now('UTC')->timestamp;
        $params = json_encode(array(
            "390101540012341"=> array("next_pay_dl"=>1569540362,"next_reminder"=>1560187101,"next_warning"=>
                                            1565419925, "next_overdue"=>1569500000, "next_lock"=>1569540362),
            "390101540075318"=> array("next_pay_dl"=>1579540362,"next_reminder"=>1560187101,"next_warning"=>
                1565419925, "next_overdue"=>1569500000, "next_lock"=>1569540362),
            "390101540509512"=> array("next_pay_dl"=>1579540362,"next_reminder"=>1560187101,"next_warning"=>
                1565419925, "next_overdue"=>1569500000, "next_lock"=>1569540362)
        ), true);

        $encoded_hash = $hawk->normalizePayload($params);

        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'POST',
            '/financier_be/v1.0/devices/notify_paid', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=',$encoded_hash);

        $header = array(
            "POST /financier_be/v1.0/devices/notify_paid",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts=' . $current_timestamp . ', nonce="' . $nonce . '",  mac="' . $compute_header . '"'
        );

        $notify = $hawk->sendRequest('/financier_be/v1.0/devices/notify_paid', 'POST', $header,$params);
        print_r($notify); die;
    }



    public function notifyDeviceCreditCompletion() {

        $hawk = new \Hawk();
        $current_timestamp = Carbon::now('UTC')->timestamp;
        $params = json_encode(array("msg"=>"Congratulation. Your last payment has been received. Your device has now been definitely unlocked.",)
        , true);


        $encoded_hash = $hawk->normalizePayload($params);

        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'POST',
            '/financier_be/v1.0/devices/{imei}/notify_credit_completed', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=',$encoded_hash);

        $header = array(
            "POST /financier_be/v1.0/devices/{imei}/notify_credit_completed",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts=' . $current_timestamp . ', nonce="' . $nonce . '",  mac="' . $compute_header . '"'
        );

        $notify = $hawk->sendRequest('/financier_be/v1.0/devices/{imei}/notify_credit_completed', 'POST', $header,$params);
        print_r($notify); die;
    }

    public function massDeviceCreditCompletion() {

        $hawk = new \Hawk();
        $current_timestamp = Carbon::now('UTC')->timestamp;
        $params =json_encode(array(
            "390101540012341"=> array("msg"=>"Congratulation. Your last payment has been received. Your device has now been definitely unlocked."),
            "390101540075318"=> array("msg"=>"Congratulation. Your last payment has been received. Your device has now been definitely unlocked."),
            "390101540509512"=> array("msg"=>"Congratulation. Your last payment has been received. Your device has now been definitely unlocked."),
        ), true);


        $encoded_hash = $hawk->normalizePayload($params);

        $nonce = $hawk->generateNonce();

        $compute_header = $hawk->normalizedHeader($current_timestamp, $nonce, 'POST',
            '/financier_be/v1.0/devices/notify_paid', 'Pt7JF+4lzf/tVZitJIcKVbaddUVBPzqCEnbui6ng88c=',$encoded_hash);

        $header = array(
            "POST /financier_be/v1.0/devices/notify_paid",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="MrjBt/9Mkx73PyaTh7AyGh6STnI=", ts=' . $current_timestamp . ', nonce="' . $nonce . '",  mac="' . $compute_header . '"'
        );

        $notify = $hawk->sendRequest('/financier_be/v1.0/devices/notify_paid', 'POST', $header,$params);
        print_r($notify); die;
    }


    /*Array
    (
        [refresh_token] => eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJhb2siOnRydWUsImF0aCI6Imhhd2siLCJhdWQiOiJhdXRoLnRlc3Qua2Fpb3N0ZWNoLmNvbSIsImJyYW5kIjoiRGVsbCIsImN1IjoicmV3a2FmMzQ1ZmEiLCJkaWQiOiJOY0NmOXdEUTlwN01yVW1wdWU4ZVhQZl9EQ1hpTmdDUmRCa2hVa0dYUVlsQjZwa1JVN0hSdFl6OVMySmwiLCJkdHlwZSI6IjAiLCJlb2siOnRydWUsImV4cCI6MTU5MDA1MjY5MCwiaWF0IjoxNTg5OTY2MjkwLCJpY2NfbWNjIjowLCJpY2NfbWNjMiI6MCwiaWNjX21uYyI6MCwiaWNjX21uYzIiOjAsImlzcyI6ImF1dGgudGVzdC5rYWlvc3RlY2guY29tIiwianRpIjoidTVmcWZIbHRZREhyZGpCdmpVMzEiLCJtb2RlbCI6IkxhdHRpdHVkZSA3NTAwIiwibW9rIjpmYWxzZSwibmV0X21jYyI6MCwibmV0X21jYzIiOjAsIm5ldF9tbmMiOjAsIm5ldF9tbmMyIjowLCJvcyI6IldpbmRvd3MiLCJvc3YiOiIxMCIsInBpZCI6IiIsInJ0dGwiOjg2NDAwLCJzY3AiOiJyfGNvcmUjYWNjb3VudDpjZHJzdSBjb3JlI2RldmljZTpjZHJzdSBjb3JlI2xiczpjZHJzdSBjb3JlI3B1c2g6Y2Ryc3UgZmluYW5jaWVyI2ZhZG1pbjpjZHJzdSBvYXV0aDI6Y2Ryc3UgcGF5bWVudCNvcHRpb25zOnMgcGF5bWVudCNwcmljZXM6cyBwYXltZW50I3Byb2R1Y3RzOnJzIHBheW1lbnQjcHVyY2hhc2VzOmNkcnUgcGF5bWVudCN0cmFuc2FjdGlvbnM6Y3Igc2MjYXBwczpycyBzYyNtZXRyaWNzOmMiLCJzaWQiOiJscjlDdHMwUmhiYU5SSjVpX2dLZiIsInR0bCI6ODY0MDAsInR5cCI6InJlZnJlc2hfdG9rZW4iLCJ1aWQiOiJOY0NmOXdEUTlwN01yVW1wdWU4ZVhQZl9EQ1hpTmdDUmRCa2hVa0dYIiwidXRwIjoiYWNjb3VudCJ9.jpdP6bmbmJC-VAnIcMQxO0BtQcoMLWymstkbM8CxqWjw94_H36Np6iR9x034fgg-f6JAJhXysrxBqHAfR_k4UGnyM5vmMzcz2ZQK2ZDxSENc0CB_cjYb1oK3rc6QwepSq8v2LkIzoLxntx9oTZHSd13n4H9OwfgN-iXtiaGd54q4x2URdW4z5m3Bmtdrz_FBRqXOHSaMy6276sPSoMQEkmhOOEUDHm2VWbky4TswwkipvaObOH-mOETHDDL6N0z4YwMKABpK9_WLJWvCBAPSXIsjbVAUkuVJa7UIrKtJePYRehPOKnRWFF8gOLZhSKduF7j-APvgC1EyWoFXfs5e0w [token_type] => hawk [scope] => r|core#account:cdrsu core#device:cdrsu core#lbs:cdrsu core#push:cdrsu financier#fadmin:cdrsu oauth2:cdrsu payment#options:s payment#prices:s payment#products:rs payment#purchases:cdru payment#transactions:cr sc#apps:rs sc#metrics:c [expires_in] => 86400 [kid] => 0X/IdtuBm1HRdmiQX9SVsZuUOoQ= [mac_key] => m5n8EEom2nhkDD2R5K5nq1dhcuAQ8kSXbskaIjQF3Qg= [mac_algorithm] => hmac-sha-256 [email_is_valid] => 1 )
    y*/
}
