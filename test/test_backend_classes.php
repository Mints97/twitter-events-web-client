<?php
// Setup for visual testing of the frontend

require_once(dirname(__FILE__) . "/../backend/events_server_request.php");

class MockEventsServerRequest implements IEventsServerRequest { // A mock of class EventsServerRequest used for visual testing
    public function getCells() {
        $json = <<<EOD
            {"cells":[{"row":1277,"column":7782,"lat":-36.770832,"lng":144.27083},{"row":1301,"column":2605,"lat":-35.770832,"lng":-71.4375},{"row":1345,"column":7948,"lat":-33.9375,"lng":151.1875},{"row":1355,"column":7938,"lat":-33.520832,"lng":150.77083},{"row":1476,"column":4912,"lat":-28.479166,"lng":24.6875},{"row":1547,"column":3138,"lat":-25.520834,"lng":-49.229168},{"row":1680,"column":3265,"lat":-19.979166,"lng":-43.9375},{"row":1857,"column":2659,"lat":-12.604167,"lng":-69.1875},{"row":1972,"column":6969,"lat":-7.8125,"lng":110.395836},{"row":2195,"column":6809,"lat":1.4791666,"lng":103.729164},{"row":2314,"column":4401,"lat":6.4375,"lng":3.3958333},{"row":2336,"column":2576,"lat":7.3541665,"lng":-72.645836},{"row":2346,"column":2586,"lat":7.7708335,"lng":-72.229164},{"row":2409,"column":7292,"lat":10.395833,"lng":123.854164},{"row":2447,"column":7246,"lat":11.979167,"lng":121.9375},{"row":2471,"column":6182,"lat":12.979167,"lng":77.604164},{"row":2513,"column":7225,"lat":14.729167,"lng":121.0625},{"row":2577,"column":6203,"lat":17.395834,"lng":78.479164},{"row":2581,"column":7209,"lat":17.5625,"lng":120.395836},{"row":2600,"column":2763,"lat":18.354166,"lng":-64.854164},{"row":2610,"column":6695,"lat":18.770834,"lng":98.979164},{"row":2625,"column":1939,"lat":19.395834,"lng":-99.1875},{"row":2633,"column":575,"lat":19.729166,"lng":-156.02083},{"row":2641,"column":6717,"lat":20.0625,"lng":99.895836},{"row":2670,"column":531,"lat":21.270834,"lng":-157.85417},{"row":2671,"column":531,"lat":21.3125,"lng":-157.85417},{"row":2742,"column":5642,"lat":24.270834,"lng":55.104168},{"row":2753,"column":2375,"lat":24.729166,"lng":-81.020836},{"row":2775,"column":1911,"lat":25.645834,"lng":-100.354164},{"row":2779,"column":2396,"lat":25.8125,"lng":-80.145836},{"row":2782,"column":2394,"lat":25.9375,"lng":-80.229164},{"row":2784,"column":2396,"lat":26.020834,"lng":-80.145836},{"row":2792,"column":2398,"lat":26.354166,"lng":-80.0625},{"row":2823,"column":2391,"lat":27.645834,"lng":-80.354164},{"row":2840,"column":2363,"lat":28.354166,"lng":-81.520836},{"row":2842,"column":2362,"lat":28.4375,"lng":-81.5625},{"row":2844,"column":2366,"lat":28.520834,"lng":-81.395836},{"row":2853,"column":2369,"lat":28.895834,"lng":-81.270836},{"row":2866,"column":1956,"lat":29.4375,"lng":-98.479164},{"row":2868,"column":2033,"lat":29.520834,"lng":-95.270836}]}
EOD;
        return new CellCollection(json_decode($json));
    }
    
    public function getEvent($lat, $lng) {
        $json = <<<EOD
        {"id":3820,"tweets":[{"id":787354984702619648,"idStr":"787354984702619648","text":"We're #hiring! Click to apply: Salesperson - https://t.co/yg8NJFGSUR #Job #Automotive #Albany, GA #Jobs #CareerArc","hashtags":["hiring","Jobs","CareerArc","Job","Automotive","Albany"],"lat":31.5763214,"lng":-84.1756637,"timestamp":1476555031358,"userIdStr":"180442164","userScreenName":"tmj_GA_auto"}],"hashtag":"albany","lat":31.5763214,"lng":-84.1756637,"available":1,"returned":1,"nextAvailable":1476555031358}
EOD;
        return new Event(json_decode($json));
    }
    
    public function getStatistics(){
        $json = '{"global_events":5225,"active_cells":784,"global_tweets":3196}';
        return '{"num_tweets":' . json_decode($json)->global_tweets . ',"num_events":' . json_decode($json)->global_events . "}";
    }
}
?>