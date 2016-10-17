var localEventsAPI = "/backend/events_server_provider.php";
var requests = []
var map;

function initMap() {
    /*global google*/
    map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 33.797, lng: -84.484},
    zoom: 10
    });
    
    displayEvents();
    displayStatistics();
}


function writeTweets(lat, lng, writeToContent) {
    var xmlHttp = new XMLHttpRequest();
    requests[requests.length] = xmlHttp;
    xmlHttp.onreadystatechange = function() { 
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            writeToContent(xmlHttp.responseText);
        }
    }
    xmlHttp.open("GET", localEventsAPI + "?action=getcell&lat=" + lat + "&lng=" + lng, true);
    xmlHttp.send(null);
}

function loadTwitterWidgets(id) {
    twttr.widgets.load(
      document.getElementById(id)
    );
}

function displayEvents() {
    var infowindow = new google.maps.InfoWindow();
    
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() { 
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            var data = JSON.parse(xmlHttp.responseText);
            console.log("first response" + JSON.stringify(data))
            data.cells.forEach(function(currentValue, index, arr) {
                
                writeTweets(currentValue.lat, currentValue.lng, function(tweetsData) {
                    var tweetsData = JSON.parse(tweetsData);
                    if (tweetsData.tweets.length > 0) {
                        var tweetsHTML = '<p>#' + tweetsData.hashtag
                                    + '</p> <div style="overflow-y:scroll; height:200px; display:inline-block;" id="tweetsInfoWindow">';
                        var tweetsHTMLModal = '<button id="' + index + '_' + tweetsData.hashtag + 'ModalButton" class="modal-button" onclick="displayModal('
                                                + "'" + index + '_' + tweetsData.hashtag + "Modal'" + ')">#'
                                                + tweetsData.hashtag
                                                + '</button><div id="' + index + '_' + tweetsData.hashtag + 'Modal" class="modal">'
                                                + '<div class="modal-content">'
                                                + '<span id="' + index + '_' + tweetsData.hashtag + 'ModalClose" class="close">×</span>'
                                                + '<div style="overflow-y:scroll; height:200px; color:black" id="'
                                                    + index + '_' + tweetsData.hashtag + 'ModalData">';
                        
                        tweetsData.tweets.forEach(function(currentValue, index, arr) {
                            tweetsHTML += currentValue.embed_code;
                            tweetsHTMLModal += currentValue.embed_code;
                        });
                        
                        var modalDiv = document.createElement('div');
                        modalDiv.innerHTML = tweetsHTMLModal + "</div></div></div><br>";
                        
                        document.getElementById("top_events").appendChild(modalDiv);
                        
                        // set marker
                        var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(currentValue.lat, currentValue.lng)
                        });
                        
                        marker.setMap(map);
                        
                        marker.addListener('click', function() {
                            infowindow.setContent(tweetsHTML + "</div>");
                            infowindow.open(map, marker);
                            loadTwitterWidgets("tweetsInfoWindow");
                        });
                    }
                });
            });
        }
    }
    xmlHttp.open("GET", localEventsAPI + "?action=cells", true);
    xmlHttp.send(null);
}

function displayStatistics() {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() { 
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            var data = JSON.parse(xmlHttp.responseText);
            
            document.getElementById("num_tweets").innerHTML = data.num_tweets;
            document.getElementById("num_events").innerHTML = data.num_events;
        }
    }
    xmlHttp.open("GET", localEventsAPI + "?action=statistics", true);
    xmlHttp.send(null);
}