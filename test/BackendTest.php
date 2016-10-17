<?php
// Unit tests for the backend classes. Requires PHPUnit.

require_once(dirname(__FILE__) . "/../common/event.php");

use PHPUnit\Framework\TestCase;

class BackendTest extends TestCase {
    
    public function testTweet() {
        $expected = '{"embed_code":"' . "<blockquote class='twitter-tweet' data-lang='en'><p lang='en' dir='ltr'>twe\\\\et\\n text</p>&mdash;  @user <a href='https://twitter.com/user/status/1234'>October 16, 2016</a></blockquote>" . '"}';
        
        $tweet = new Tweet(json_decode('{"idStr":"1234", "text":"twe\\\\et' . "\\r\\n" . ' text", "userScreenName":"user", "timestamp":1476611811}'));
        
        $this->assertEquals($expected, (string) $tweet);
    }
    
    public function testCell_getLat() {
        $lat = 10;
        
        $cell = new Cell(json_decode('{"lat":' . $lat . ', "lng":0}'));
        $this->assertEquals($lat, $cell->getLat());
    }
    
    public function testCell_getLng() {
        $lng = 10;
        
        $cell = new Cell(json_decode('{"lng":' . $lng . ', "lat":0}'));
        $this->assertEquals($lng, $cell->getLng());
    }
    
    public function testCell() {
        $str = '{"lat":1,"lng":1}';
        
        $cell = new Cell(json_decode($str));
        $this->assertEquals($str, (string) $cell);
    }
    
    public function testCellCollectionNoCells() {
        $str = '{"cells":[]}';
        
        $cellCollection = new CellCollection(json_decode($str));
        $this->assertEquals($str, (string) $cellCollection);
    }
    
    public function testCellCollectionOneCell() {
        $str = '{"cells":[{"lat":0,"lng":0}]}';
        
        $cellCollection = new CellCollection(json_decode($str));
        $this->assertEquals($str, (string) $cellCollection);
    }
    
    public function testCellCollectionMultipleCells() {
        $str = '{"cells":[{"lat":0,"lng":0}, {"lat":1,"lng":1}]}';
        
        $cellCollection = new CellCollection(json_decode($str));
        $this->assertEquals($str, (string) $cellCollection);
    }
    
    public function testEventOneTweet() {
        $str = '{"tweets":[{"idStr":"1234", "text":"tweet text", "userScreenName":"user", "timestamp":1476611811, "lat":0, "lng":0}], "hashtag":"tag", "lat":0, "lng":0}';
        $expected = '{"tweets":[' . '{"embed_code":"' . "<blockquote class='twitter-tweet' data-lang='en'><p lang='en' dir='ltr'>tweet text</p>&mdash;  @user <a href='https://twitter.com/user/status/1234'>October 16, 2016</a></blockquote>" . '"}' . '], "hashtag":"tag"}';
        
        $event = new Event(json_decode($str));
        $this->assertEquals($expected, (string) $event);
    }
    
    public function testEventNoTweets() {
        $str = '{"tweets":[], "hashtag":"tag", "lat":0, "lng":0}';
        $expected = '{"tweets":[], "hashtag":"tag"}';
        
        $event = new Event(json_decode($str));
        $this->assertEquals($expected, (string) $event);
    }
    
    public function testEventMultipleTweets() {
        $str = '{"tweets":[{"idStr":"1234", "text":"tweet text", "userScreenName":"user", "timestamp":1476611811, "lat":0, "lng":0}, {"idStr":"12345", "text":"tweet2 text", "userScreenName":"user2", "timestamp":1476611811}], "hashtag":"tag", "lat":0, "lng":0}';
        $expected = '{"tweets":[' . '{"embed_code":"' . "<blockquote class='twitter-tweet' data-lang='en'><p lang='en' dir='ltr'>tweet text</p>&mdash;  @user <a href='https://twitter.com/user/status/1234'>October 16, 2016</a></blockquote>" . '"}' . ', ' . '{"embed_code":"' . "<blockquote class='twitter-tweet' data-lang='en'><p lang='en' dir='ltr'>tweet2 text</p>&mdash;  @user2 <a href='https://twitter.com/user2/status/12345'>October 16, 2016</a></blockquote>" . '"}' . '], "hashtag":"tag"}';
        
        $event = new Event(json_decode($str));
        $this->assertEquals($expected, (string) $event);
    }
}

?>