<?php


namespace App\Http\Controllers;


//use App\Http\Controllers\Controller;

use Carbon\Carbon;
use http\Env\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        //
    }
    public function getDashboard() {
        return view('dashboard.index');
    }




    /*Array
    (
        [refresh_token] => eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJhb2siOnRydWUsImF0aCI6Imhhd2siLCJhdWQiOiJhdXRoLnRlc3Qua2Fpb3N0ZWNoLmNvbSIsImJyYW5kIjoiRGVsbCIsImN1IjoicmV3a2FmMzQ1ZmEiLCJkaWQiOiJOY0NmOXdEUTlwN01yVW1wdWU4ZVhQZl9EQ1hpTmdDUmRCa2hVa0dYUVlsQjZwa1JVN0hSdFl6OVMySmwiLCJkdHlwZSI6IjAiLCJlb2siOnRydWUsImV4cCI6MTU5MDA1MjY5MCwiaWF0IjoxNTg5OTY2MjkwLCJpY2NfbWNjIjowLCJpY2NfbWNjMiI6MCwiaWNjX21uYyI6MCwiaWNjX21uYzIiOjAsImlzcyI6ImF1dGgudGVzdC5rYWlvc3RlY2guY29tIiwianRpIjoidTVmcWZIbHRZREhyZGpCdmpVMzEiLCJtb2RlbCI6IkxhdHRpdHVkZSA3NTAwIiwibW9rIjpmYWxzZSwibmV0X21jYyI6MCwibmV0X21jYzIiOjAsIm5ldF9tbmMiOjAsIm5ldF9tbmMyIjowLCJvcyI6IldpbmRvd3MiLCJvc3YiOiIxMCIsInBpZCI6IiIsInJ0dGwiOjg2NDAwLCJzY3AiOiJyfGNvcmUjYWNjb3VudDpjZHJzdSBjb3JlI2RldmljZTpjZHJzdSBjb3JlI2xiczpjZHJzdSBjb3JlI3B1c2g6Y2Ryc3UgZmluYW5jaWVyI2ZhZG1pbjpjZHJzdSBvYXV0aDI6Y2Ryc3UgcGF5bWVudCNvcHRpb25zOnMgcGF5bWVudCNwcmljZXM6cyBwYXltZW50I3Byb2R1Y3RzOnJzIHBheW1lbnQjcHVyY2hhc2VzOmNkcnUgcGF5bWVudCN0cmFuc2FjdGlvbnM6Y3Igc2MjYXBwczpycyBzYyNtZXRyaWNzOmMiLCJzaWQiOiJscjlDdHMwUmhiYU5SSjVpX2dLZiIsInR0bCI6ODY0MDAsInR5cCI6InJlZnJlc2hfdG9rZW4iLCJ1aWQiOiJOY0NmOXdEUTlwN01yVW1wdWU4ZVhQZl9EQ1hpTmdDUmRCa2hVa0dYIiwidXRwIjoiYWNjb3VudCJ9.jpdP6bmbmJC-VAnIcMQxO0BtQcoMLWymstkbM8CxqWjw94_H36Np6iR9x034fgg-f6JAJhXysrxBqHAfR_k4UGnyM5vmMzcz2ZQK2ZDxSENc0CB_cjYb1oK3rc6QwepSq8v2LkIzoLxntx9oTZHSd13n4H9OwfgN-iXtiaGd54q4x2URdW4z5m3Bmtdrz_FBRqXOHSaMy6276sPSoMQEkmhOOEUDHm2VWbky4TswwkipvaObOH-mOETHDDL6N0z4YwMKABpK9_WLJWvCBAPSXIsjbVAUkuVJa7UIrKtJePYRehPOKnRWFF8gOLZhSKduF7j-APvgC1EyWoFXfs5e0w [token_type] => hawk [scope] => r|core#account:cdrsu core#device:cdrsu core#lbs:cdrsu core#push:cdrsu financier#fadmin:cdrsu oauth2:cdrsu payment#options:s payment#prices:s payment#products:rs payment#purchases:cdru payment#transactions:cr sc#apps:rs sc#metrics:c [expires_in] => 86400 [kid] => 0X/IdtuBm1HRdmiQX9SVsZuUOoQ= [mac_key] => m5n8EEom2nhkDD2R5K5nq1dhcuAQ8kSXbskaIjQF3Qg= [mac_algorithm] => hmac-sha-256 [email_is_valid] => 1 )
    y*/
}
