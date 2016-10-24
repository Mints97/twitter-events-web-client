<?php
require_once(dirname(__FILE__) . "/events_server_request.php");

// uncomment following for visual testing
 require_once(dirname(__FILE__) . "/../test/test_backend_classes.php");

/*
Web Client Local API
This is an abstraction over the Events Server API, delivering only the data the Web Client needs.

/backend/events_server_provider.php?action=cells
returns all cells with events in them, in JSON format. Example: { "cells": [{"lat":0.0,"lng":0.0}, {"lat":0.0,"lng":0.0}] }

/backend/events_server_provider.php?action=getcell&lat=x&lng=y
return a list of tweets for the top event for this cell, in JSON format. Example: { "tweets": [ {"embed_code":""}, {"embed_code":""}] }

/backend/events_server_provider.php?action=statistics
return the statistics in JSON format. Example: { "num_tweets":1, "num_events":1, "num_users":1 }
*/

if (isset($_GET['action'])) {
    $request = new EventsServerRequest();
// uncomment following for visual testing
//    $request = new MockEventsServerRequest();
    
    if ($_GET['action'] === "cells") {
        echo $request->getCells();
        exit();
    }
    
    if ($_GET['action'] === "getcell" && isset($_GET['lat'])
                                      && is_numeric($_GET['lat'])
                                      && isset($_GET['lng'])
                                      && is_numeric($_GET['lng'])) {
        echo $request->getEvent($_GET['lat'], $_GET['lng']);
        exit();
    }
    
    if ($_GET['action'] === "statistics") {
        echo $request->getStatistics();
        exit();
    }
}
?>