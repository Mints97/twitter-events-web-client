<?php
require_once(dirname(__FILE__) . "/../common/event.php");

interface IEventsServerRequest { // interface for events server communication
    public function getCells(); // returns array of all cells with events
    public function getEvent($lat, $lng); // returns array of tweets for event in a day
    public function getStatistics();
}

class EventsServerRequest implements IEventsServerRequest { // uses events server API as pers specifications provided
    private $hostName = "http://127.0.0.1:8082";
    // start with: cd events_server/Events-Server-Master; java -jar build/libs/events-server-0.0.1-SNAPSHOT.jar
    
    private $maxTweets = "10";
    
    private $context;
    
    public function __construct() {
        $this->context = stream_context_create(
            array(
                'http' => array(
                    'timeout' => 1  // 1 second timeout
                )
            )
        );
    }
    
    public function getCells() {
        $json = @file_get_contents($this->hostName . "/v2/data/cells", false, $this->context);
        return new CellCollection(json_decode($json));
    }
    
    public function getEvent($lat, $lng) {
        $json = @file_get_contents($this->hostName . "/v2/data/events?latlng=" . $lat . "%2C" . $lng . "&count=1",
                                        false, $this->context);
        $decoded = json_decode($json);
        
        if (!isset($decoded->events) || count($decoded->events) != 1) {
            return new Event(NULL); // error!
        }

        $json = @file_get_contents("$this->hostName/v2/data/event/" . $decoded->events[0] . "?count=$this->maxTweets",
                                        false, $this->context);
        return new Event(json_decode($json));
    }
    
    public function getStatistics(){
        $json = @file_get_contents($this->hostName . "/v2/stats/data", false, $this->context);
        return '{"num_tweets":' . json_decode($json)->global_tweets . ',"num_events":' . json_decode($json)->global_events . "}";
    }
}

?>