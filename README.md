# CS 3300 Twitter Events Web Client 2

A web admin interface for the Twitter Events application, displaying useful usage statistics.

A working demo can be found here: [twitter-events-web-client-mints97.c9users.io](https://twitter-events-web-client-mints97.c9users.io/). Login as **admin** with password **password**.

## Features

After logging in, an admin can:
 - Create a new admin user
 - View the top current events on a map
 - View tweets for every event on the map
 - View the statistics for the total number of tweets and events
 - View the top current events as a list of hashtags
 - View tweets for every event in the list
 - Log out

## Setup

This app requires PHP with the minimum version 5.6.* and MySQL (recommended minimum version 5.5.50).
The unit tests in test/ also require PHPUnit ([phpunit.de](https://phpunit.de/)) to be installed.
A regular LAMP (Linux, Apache, MySQL, PHP) setup is highly recommended.

### Setting up the database

Start by setting your MySQL database info (server, db name, db user credentials) in **backend/db_config.php**.
After you're done with that, edit **mysql_database_setup.php** and follow the instructions in the comments to set a login and password for the default admin user of the web application.
Now you should run **mysql_database_setup.php**. It will output **"success"** once the database has been successfully set up.

Don't forget to delete **mysql_database_setup.php** after setup is complete!

### Verifying setup was successful

You can open the login page hosted on your server in a web browser. To log in, input the login credentials you specified in **mysql_database_setup.php**.
After that, you can access all the functionality of the application, and create new admin users through the Create New Admin User menu.