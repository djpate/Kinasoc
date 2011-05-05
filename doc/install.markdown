# Kinasoc installation

## Prerequisities

You need git, a web server and a database server.

## Convention

This installation is performed under a terminal. '$' represents a standard user 
and '#' represents the root user.

The following installation is for a basic LAMP (Linux Apache2 MySQL PHP) 
configuration but you can easily adapt to fit your needs.

## Download

Go to your web root directory:

    $ cd /var/www/

Download from Github repository:

    $ git clone git://github.com/djpate/Kinasoc.git

## Basic configuration

Go to Kinasoc root directory:

    $ cd Kinasoc/

Create your configuration file from given example:

    $ cp configuration/configuration.example.php configuration/configuration.php
    $ vim configuration/configuration.php

Edit configuration file to your needs:

    <?php
	    /* pdo */
	    $pdoConf = array(
		    'pdoType'=>'mysql',
		    'pdoHost'=>'localhost',
		    'pdoUser'=>'root',
		    'pdoDb'=>'kinasoc',
		    'pdoPass'=>'somepass');
	
	    $def_route = array( "controller"=>"home",
	                        "action"=>"index",
	                        "matches"=>array()
	                       );
    ?>

## Framework configuration

Go to Kinasoc root directory:

    $ cd Kinasoc/

Set full rights on kinaf framework:

    # chmod 777 ./kinaf

## Database creation

Create the database:

    $ mysql -u root -p
    mysql> create database kinasoc;
    mysql> exit

Go to Kinasoc root directory:

    $ cd Kinasoc/

Load defaults datas:

    $ ./kinaf importDb

**Note**: If you did not set a password to the database user, it will be 
requested so just hit `Enter` key.

## Web server configuration

Create and configure your virtualhost:

    # vim /etc/apache2/sites-available/kinasoc 

Add your virtualhost configuration:

    <VirtualHost *:80>
        ServerName kinasoc.localhost
        DocumentRoot /var/www/Kinasoc/public
    </VirtualHost>

Enable the fresh website:

    # a2ensite kinasoc

Restart your web server:

    # apache2ctl graceful

Add the new host to the known hosts:

    # vim /etc/hosts

Add the following line:

    127.0.0.1       kinasoc.localhost

## Browse

Launch your favorite Web browser and go to the url: `http://kinasoc.localhost`.
