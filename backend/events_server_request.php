<?php
require_once(dirname(__FILE__) . "/../common/event.php");

interface IEventsServerRequest { // interface for events server communication
    public function getCells(); // returns array of all cells with events
    public function getEvent($lat, $lng); // returns array of tweets for event in a day
    public function getStatistics();
}

class EventsServerRequest implements IEventsServerRequest { // uses events server API as pers specifications provided
    private $hostName = "http://54.191.15.168";
    
    private $maxTweets = "10";
    
    public function getCells() {
        $json = file_get_contents($this->hostName . "/v2/data/cells");
        return new CellCollection(json_decode($json));
    }
    
    public function getEvent($lat, $lng) {
        $json = file_get_contents($this->hostName . "/v2/data/events?latlng=" . $lat . "%2C" . $lng . "&count=1");
        $decoded = json_decode($json);
        
        if (count($decoded->events) != 1) {
            return '{"tweets":[], "hashtag":""}'; // error!
        }

        $json = file_get_contents("$this->hostName/v2/data/event/" . $decoded->events[0] . "?count=$this->maxTweets");
        return new Event(json_decode($json));
    }
    
    public function getStatistics(){
        $json = file_get_contents($this->hostName . "/v2/stats/data");
        return '{"num_tweets":' . json_decode($json)->global_tweets . ',"num_events":' . json_decode($json)->global_events . "}";
    }
}

?>