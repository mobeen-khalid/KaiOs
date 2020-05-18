<?php

namespace App\Http\Controllers;

use Carbon\Exceptions\BadUnitException;
use Dflydev\Hawk\Client\ClientBuilder;
use Dflydev\Hawk\Credentials\Credentials;

use Shawm11\Hawk\Client\Client as HawkClient;
use Shawm11\Hawk\Client\ClientException as HawkClientException;

use Carbon\Carbon;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

//{"id":"NcCf9wDQ9p7MrUmpue8eXPf_DCXiNgCRdBkhUkGX","first_name":"Mobeen","last_name":"khalid","account_type":2,"password_date":1588708528,"email":"mobeen.khalid@finja.pk","email_validation_date":1588708752,"email_update_date":1588708528,"country":"us","language":"en","roles":["JeRhOE86OMbyqmrzGL6U"]}

    public function getDevices()
    {
        $current_timestamp = Carbon::now('UTC')->timestamp;
//        dd($current_timestamp);
//        $normalized_payload = array(
//            "hawk.1.payload",
//            "application/json"
//        );

        $normalized_payload = "hawk.1.payload\n";
        $normalized_payload .= "application/json\n";
        $normalized_payload .= json_encode(array('next_pay_dl' => 1591568817), true)."\n";
        $params = json_encode(array('next_pay_dl' => 1591568817), true);

        $payload_str = str_replace('\n', '', $normalized_payload);
        $compute_hash = hash("sha256", $payload_str, true);
        $encoded_hash = base64_encode($compute_hash);

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $nonce = $randomString;

//        $normalized_header = array(
//            "hawk.1.header",
//            $current_timestamp,
//            $nonce,
//            "GET",
//            "/core/v1.0/accounts/me",
//            "api.test.kaiostech.com",
//            443,
//            "",
//            ""
//        );

        $normalized_header = "hawk.1.header\n";
        $normalized_header .= $current_timestamp . "\n";
        $normalized_header .= $nonce . "\n";
        $normalized_header .= "POST\n";
        $normalized_header .= "/financier_be/v1.0/devices/192168718812411/notify_paid\n";
        $normalized_header .= "api.test.kaiostech.com\n";
        $normalized_header .= "443\n";
        $normalized_header .= $encoded_hash."\n";
        $normalized_header .= "\n";
//        dd($normalized_header);die;

//        $normalized_header_json = json_encode($normalized_header, true);
//        dd($normalized_header_json);
        $str = str_replace('\n', '', $normalized_header);
        $mac_key = base64_decode("orSF1PZzmwL/FiMoJNPjawPilUaFQaE1tL3Fbn+2rW4=", true);

        $normalized_header_hmac = hash_hmac("sha256", $str, $mac_key, True);
        $compute_header = base64_encode($normalized_header_hmac);
//        dd($compute_header);

        $curl = curl_init();
        $header = array(
            "POST /financier_be/v1.0/devices/192168718812411/notify_paid HTTP/1.1",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="+2H3Ft1s+Uk7zQSAeKsaYVa8S5A=", ts=' . $current_timestamp . ', nonce="' . $nonce . '", hash="' . $encoded_hash . '", mac="' . $compute_header . '"'
        );
//        dd($header);

        curl_setopt($curl, CURLOPT_URL, 'https://api.test.kaiostech.com/financier_be/v1.0/devices/192168718812411/notify_paid');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);

//        curl_setopt($curl, CURLOPT_URL, "https://api.test.kaiostech.com/financier_be/v1.0/devices/192168718812411/notify_paid");
//        curl_setopt($curl, CURLOPT_POST, 1);
//        curl_setopt($curl, CURLOPT_POSTFIELDS,$vars);  //Post Fields
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        $server_output = curl_exec($curl);

        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = substr($server_output, 0, $header_size);
        $body = substr($server_output, $header_size);
        dd($server_output);
    }

    public function getDevicesFinal() {
        $current_timestamp = Carbon::now('UTC')->timestamp;
//        dd($current_timestamp);
//        $normalized_payload = array(
//            "hawk.1.payload",
//            "application/json"
//        );

        $normalized_payload = "hawk.1.payload\n";
        $normalized_payload .= "application/json\n";
        $normalized_payload .= json_encode(array('next_pay_dl' => $current_timestamp), true);

//        $normalized_payload_json = json_encode($normalized_payload, true);
//        $compute_hash = hash("sha256", $normalized_payload_json);
        $compute_hash = hash("sha256", $normalized_payload);
        $encoded_hash = base64_encode($compute_hash);

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $nonce = $randomString;

//        $normalized_header = array(
//            "hawk.1.header",
//            $current_timestamp,
//            $nonce,
//            "GET",
//            "/core/v1.0/accounts/me",
//            "api.test.kaiostech.com",
//            443,
//            "",
//            ""
//        );

        $normalized_header = "hawk.1.header\n";
        $normalized_header .= $current_timestamp."\n";
        $normalized_header .= $nonce."\n";
        $normalized_header .= "GET\n";
        $normalized_header .= "/core/v1.0/accounts/me\n";
        $normalized_header .= "api.test.kaiostech.com\n";
        $normalized_header .= "443\n";
        $normalized_header .= "\n";
        $normalized_header .= "\n";
//        dd($normalized_header);die;

//        $normalized_header_json = json_encode($normalized_header, true);
//        dd($normalized_header_json);
        $str = str_replace('\n', '', $normalized_header);
        $mac_key = base64_decode("orSF1PZzmwL/FiMoJNPjawPilUaFQaE1tL3Fbn+2rW4=", true);

        $normalized_header_hmac = hash_hmac("sha256", $str, $mac_key, True);
        $compute_header = base64_encode($normalized_header_hmac);
//        dd($compute_header);

        $curl = curl_init();
        $header = array(
            "GET /core/v1.0/accounts/me HTTP/1.1",
            "Host: api.test.kaiostech.com:443",
            "Content-Type: application/json",
            "Content-Size: 1255",
            'Authorization: Hawk id="+2H3Ft1s+Uk7zQSAeKsaYVa8S5A=", ts='.$current_timestamp.', nonce="'.$nonce.'", mac="'.$compute_header.'"'
        );
//        dd($header);

        curl_setopt($curl, CURLOPT_URL,"https://api.test.kaiostech.com/core/v1.0/accounts/me");
//        curl_setopt($curl, CURLOPT_POST, 1);
//        curl_setopt($curl, CURLOPT_POSTFIELDS,$vars);  //Post Fields
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        $server_output = curl_exec ($curl);

        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = substr($server_output, 0, $header_size);
        $body = substr($server_output, $header_size);
        dd($server_output);


        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.test.kaiostech.com/core/v1.0/accounts/me",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $header,
        ));
        $response = curl_exec($curl);

        curl_close($curl);

        dd($response);
    }

    public function getDevicesDump() {

        $curl = curl_init();

        $credentials = new Credentials(
            'gEtszrFfKV4Pgssv4aWXM09hX2c=',  // shared key
            'sha256',    // default: sha256
            'zcrSlHy4YAtQNGwi1bb934EFVH2EJap2Re2Jg8jrZ8A='      // identifier, default: null
        );

// Create a Hawk client
        $client = ClientBuilder::create()
            ->build();

// Create a Hawk request based on making a POST request to a specific URL
// using a specific user's credentials. Also, we're expecting that we'll
// be sending a payload of 'hello world!' with a content-type of 'text/plain'.
        $request = $client->createRequest(
            $credentials,
            'https://api.test.kaiostech.com/core/v1.0/accounts/me',
            'GET'
//            array(
//                'payload' => 'hello world!',
//                'content_type' => 'text/plain',
//            )
        );

// Ask a really useful fictional user agent to make a request; note that the
// request we are making here matches the details that we told the Hawk client
// about our request.
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.test.kaiostech.com/core/v1.0/accounts/me",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: ".$request->header()->fieldValue()
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
//        $response = Fictional\UserAgent::makeRequest(
//            'POST',
//            'http://example.com/foo/bar?whatever',
//            array(
//                'content_type' => 'text/plain',
//                $request->header()->fieldName() => $request->header()->fieldValue(),
//            ),
//            'hello world!'
//        );
        dd($response);
// This part is optional but recommended! At this point if we have a successful
// response we could just look at the content and be done with it. However, we
// are given the tools to authenticate the response to ensure that the response
// we were given came from the server we were expecting to be talking to.
        $isAuthenticatedResponse = $client->authenticate(
            $credentials,
            $request,
            $response->headers->get('Server-Authorization'),
            array(
                'payload' => $response->getContent(),
                'content_type' => $response->headers->get('content-type'),
            )
        );

        if (!$isAuthenticatedResponse) {
            die("The server did a very bad thing...");
        }



        $hawkClient = new HawkClient();

        $result = [];
        $uri = 'https://api.test.kaiostech.com/core/v1.0/accounts/me';
        $options = [
            // This is required
            'credentials' => [
                'id' => 'gEtszrFfKV4Pgssv4aWXM09hX2c=',
                'key' => 'zcrSlHy4YAtQNGwi1bb934EFVH2EJap2Re2Jg8jrZ8A=',
                'algorithm' => 'sha256'
            ]
        ];

        try {
            $result = $hawkClient->header($uri, 'GET', $options);
        } catch (HawkClientException $e) {
            echo 'ERROR: ' . $e->getMessage();
            return;
        }

        $header = $result['header']; // a string
        $artifacts = $result['artifacts']; // an array

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.test.kaiostech.com/core/v1.0/accounts/me",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: ".$header
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
//        echo $response;
//        $testing = $this->responseCallback($hawkClient, $options['credentials'], $artifacts);

        dd($response);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.test.kaiostech.com/financier_be/v1.0/devices/123456789",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Hawk id='OvOML/gI2syDuq12y6/+xej+cAw=', ts='1588762903', nonce='ne4MKd', mac='OLw7W8fBKjeE7pC5/E2jqQevi9yx3bWODpmPmZgD6kk='"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;die;

        $credentials = new Credentials(
            'js0kj3J2pJm0Isn4ty2k9Pb7QOmNUwSX6hbZJMBQATQ=',
            'sha256',
            'QEpWVtNXTwKUbqYh3RpDSBfgitk='
        );

        $client = ClientBuilder::create()->build();

        $payload = array();

        $request = $client->createRequest(
            $credentials,
            'https://api.kaiostech.com/financier_be/v1.0/devices',
            'GET'
//            array(
//                'content_type' => 'application/json',
//            )
        );

//        $hawk = \Hawk::generateHeader('zain.bhatti@finja.pk', 'h04tadp8', 'POST');
        $mac_value = $request->header()->fieldValue();
        dd($mac_value);

    }

    function responseCallback($hawkClient, $credentials, $artifacts) {
        // Somehow get the headers used in the response
        $responseHeaders = [
            // Only need these 3 headers
            'Server-Authorization' => 'some stuff',
            'WWW-Authentication' => 'some more stuff',
            'Content-Type' => 'application/json' // A different content type can be used
        ];

        // Validate the server's response
        try {
            // If the server's response is valid, the parsed response headers are
            // returned as an array
            $parsedHeaders = $hawkClient->authenticate($responseHeaders, $credentials, $artifacts);
        } catch (HawkClientException $e) {
            // If the server's response is invalid, an error is thrown
            echo 'ERROR: ' . $e->getMessage();
            return;
        }

        // Now do some other stuff with the response
    }

    public function test() {


//        curl  -H 'Content-Type: application/json' -d '{"grant_type": "password","user_name": "mobeen.khalid@finja.pk","password": "r3It7sc4GK1dU28eQnaQ7yLVExeNt9OgDfkVlI1Aafs=","scope":
//        "core","device": {"device_type": 10,"brand": "Dell","model": "Lattitude 7500","reference": "rewkaf345fa","os": "Windows","os_version":
//        "10","device_id": "0axeWR245ERFewrsaf"},"application":{"id": "lr9Cts0RhbaNRJ5i_gKf"},"partner": {"id": "ddsMreKpOJixSvYF5cvz"}}' -X POST https://api.test.kaiostech.com/oauth2/v1.0/tokens


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

        $params = json_encode($post_parameters);

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://api.test.kaiostech.com/oauth2/v1.0/tokens');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Content-Type: text/plain"
        ));

//        curl_setopt_array($curl, array(
//            CURLOPT_URL => "https://api.test.kaiostech.com/oauth2/v1.0/tokens",
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => "",
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 0,
//            CURLOPT_FOLLOWLOCATION => true,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => "POST",
//            CURLOPT_POSTFIELDS => $params,
//            CURLOPT_HTTPHEADER => array(
//                "Content-Type: application/json",
//                "Content-Type: text/plain"
//            ),
//        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
        die;


        $guzzle_client = new \GuzzleHttp\Client();



        $curl = curl_init();

        curl_setopt($curl, CURLOPT_POST, 1);
        $query = http_build_query($post_parameters);
        $params = \GuzzleHttp\json_encode($post_parameters);
//        dd($params);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
//        $url = sprintf("%s?%s", 'https://api.test.kaiostech.com/oauth2/v1.0/tokens', http_build_query($post_parameters));

        // Optional Authentication:
//        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, 'https://api.test.kaiostech.com/oauth2/v1.0/tokens');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        dd($result);


        $body['value'] = json_encode($post_parameters);

        try {
            $result = $guzzle_client->post('https://api.test.kaiostech.com/oauth2/v1.0/tokens', [
//            'debug' => TRUE,
                'form_params' => $body,
                'headers' => [
                    'Content-Type' => 'application/json'
//                    'Authorization' => $mac_value
                ]
            ]);

            $body = $result->getBody();
            $response = $result->getContents();
        } catch (\Exception $e) {
            //            dd($e->getMessage());
            $response = \GuzzleHttp\json_encode(array('code' => '400', 'msg' => $e->getMessage()));
        }
        return \GuzzleHttp\json_decode($response, TRUE);
        die;

        $header = array(
            "Authorization" => "Hawk id=\"zain.bhatti@finja.pk\", ts=\"1586761714\", nonce=\"ls09NGWrxIL3SJZ6D7fsC1lsNf6kVmmE\", hash=\"kvoVgB7WdpQRqWyy60aTY9m1uBbLyQArPHdg6qhqXf0=\", mac=\"jeGvHBQivYFmSiT22Vt5uNZuya7knJGy7vKj1h0NR/U=\""
        );


        $client = new \GuzzleHttp\Client();

        $response = \GuzzleHttp\json_encode(array('code' => '400', 'msg' => 'Something went wrong. Please try again later.'));

        $credentials = new Credentials(
            'h04tadp8',
            'sha256',
            'zain.bhatti@finja.pk'
        );

        $client = ClientBuilder::create()->build();

        $json = json_encode($post_parameters, true);

        $request = $client->createRequest(
            $credentials,
            'https://api.test.kaiostech.com/financier_be/v1.0/devices',
            'POST',
            array(
                'payload' => $json,
                'content_type' => 'application/json',
            )
        );

//        $hawk = \Hawk::generateHeader('zain.bhatti@finja.pk', 'h04tadp8', 'POST');
        $mac_value = $request->header()->fieldValue();
        $body['value'] = json_encode($post_parameters);

        try {
            $result = $guzzle_client->post('https://api.test.kaiostech.com/oauth2/v1.0/tokens', [
//            'debug' => TRUE,
                'form_params' => $body,
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => $mac_value
                ]
            ]);

            $body = $result->getBody();
            $response = $result->getContents();
        } catch (\Exception $e) {
            //            dd($e->getMessage());
            $response = \GuzzleHttp\json_encode(array('code' => '400', 'msg' => $e->getMessage()));
        }
        return \GuzzleHttp\json_decode($response, TRUE);
        die;

    }



    //
}
