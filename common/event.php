<?php
function is_iterable($var) {
    return (is_array($var) || $var instanceof Traversable);
}

class Tweet {
    private $id = "";
    private $text = "";
    private $url = "";
    private $screenName = "";
    private $datetime;
    
    public function __construct($tweetData) { // takes decoded events server JSON tweet object as parameter
        if (isset($tweetData->idStr) && isset($tweetData->text) && isset($tweetData->userScreenName)) {
            $this->id = $tweetData->idStr;
            $this->text = str_replace('"', '\"',
                                str_replace("\n", "\\n",
                                    str_replace("\r\n", "\\n", 
                                        str_replace("\\", "\\\\", $tweetData->text))));
                                        
            $this->screenName = $tweetData->userScreenName;
            $this->url = "https://twitter.com/$this->screenName/status/$this->id";
        } else {
            $this->text = "An error occured fetching tweet!";
        }
        
        $this->datetime = isset($tweetData->timestamp) ? gmdate('F j, Y', $tweetData->timestamp) : "00:00:00";
    }
    
    // generates an embed code for the tweet
    public function __toString() {
        return '{"embed_code":"' . "<blockquote class='twitter-tweet' data-lang='en'><p lang='en' dir='ltr'>$this->text</p>&mdash;  @$this->screenName <a href='$this->url'>$this->datetime</a></blockquote>" . '"}';
    }
}

class Cell {
    private $lat = 0;
    private $lng = 0;
    
    public function __construct($cell) { // takes decoded events server JSON cell object as parameter
        if (isset($cell->lat) && isset($cell->lng)) {
            $this->lat = $cell->lat;
            $this->lng = $cell->lng;
        }
    }
    
    public function getLat() {
        return $this->lat;
    }
    
    public function getLng() {
        return $this->lng;
    }
    
    public function __toString() {
        return '{"lat":' . $this->lat . ',"lng":' . $this->lng . '}';
    }
}

class CellCollection {
    private $cells = array();
    
    public function __construct($cells) { // takes decoded events server JSON cells collection object as parameter
        if (isset($cells->cells) && is_iterable($cells->cells)) {
            foreach ($cells->cells as $cell) {
                $this->cells[] = new Cell($cell);
            }
        }
    }
    
    public function __toString() {
        $result = '{"cells":[' . (string) $this->cells[0];
        
        for ($i = 1; $i < count($this->cells); $i++) {
            $result .= ', ' . (string) $this->cells[$i];
        }
        
        return $result . ']}';
    }
}

class Event {
    private $hashtag = "";
    
    private $cell;
    
    private $top_tweets = array();
    
    public function __construct($event) { // takes decoded events server JSON event object as parameter
        if (isset($event->hashtag) && isset($event->tweets) && is_iterable($event->tweets)) {
            $this->cell = new Cell($event);
            $this->hashtag = $event->hashtag;
            
            foreach ($event->tweets as $tweet) {
                $this->top_tweets[] = new Tweet($tweet);
            }
        } else {
            $this->top_tweets[] = new Tweet(NULL);
            $this->hashtag = "An error occured fetching event!";
        }
    }
    
    public function __toString() {
        $result = '{"tweets":[' . (string) $this->top_tweets[0];
        
        for ($i = 1; $i < count($this->top_tweets); $i++) {
            $result .= ', ' . (string) $this->top_tweets[$i];
        }
        
        return $result . '], "hashtag":"' . $this->hashtag . '"}';
    }
}
?>