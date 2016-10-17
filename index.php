<?php
require_once(dirname(__FILE__) . "/common/login_functions.php");

if(!is_logged_in()) {
    header('Location: login.php');
    exit();
}

?>
<html>
  <head>
    <title>Twitter Events Admin Panel</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
    </style>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/modal.css">
    <script type="text/javascript" src="js/modal.js"></script>
  </head>
  <body>
    <div id="menu" style="width: 100%; height 50px; background-color: #6d9ce8; text-align: center;">
      <div style="font-size: 25pt; margin-bottom: 1vh;">Twitter Events Admin Panel</div>
        <div style="display: inline-block;"> 
            <form method="post" action="logout_provider.php">
              <input class = "button" type="submit" value="Log Out" />
            </form>
            <form method="post" action="create_user.php">
              <input class="button" type="submit" value = "Create new admin user" />
            </form>
        </div>
    </div>
    <div style="height:700px;width:1100px; margin: 25px;">
      <div id="map" style="height:500px;width:600px;float:left;border-radius: 5px;box-shadow: 10px 10px 50px #777777;">
      
      <script type="text/javascript" async src="https://platform.twitter.com/widgets.js"></script>
      <script type="text/javascript" src="js/map.js"></script>
      </div>
      <div id="tweets" class = "tweetsPane" > <!-- Styling is in ../css/style.css-->
        <table style="width:100%;">
          <tr>
            <td  style="height:60px;"><p style="float:left; color:white;">Number of tweets this day:</p></td>
            <td  style="height:60px;"><div style="float:right; color:white;" id="num_tweets"></td>
          </tr>
          <tr>
            <td  style="height:60px;"><div style="width: 100px; color:white;">Number of events this day:</div></td>
            <td  style="height:60px;"><div style="float:right; color:white;" id="num_events"></td>
          </tr>
          <tr>
            <td style="height:360px; width: 25px;"><p style="float:left; color:white;">Tweets for top events this day:</p></td>
            <td style="height:360px;">
              <div style="overflow-y: scroll; height:360px; float:right; color:white;" id="top_events">
            </td>
          </tr>
        </table>
      </div>
    </div>
    
    <script src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>
    
    <style>
      /* Fix tweet width problems */
      .twitter-tweet.twitter-tweet-rendered {
          max-width: 520px !important;
          width: 100% !important;
      }
    </style>
  </body>
</html>