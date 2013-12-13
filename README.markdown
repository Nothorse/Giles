# Giles - Personal librarian #

A small webapp designed for local use, providing a complete eBook library.

## SETUP: ##

Currently there's a bit of manual work to get Giles going. Also some paths and methods are OS X specific, so you might want to read through the code and edit, if you're on a different system.

* Install the source anywhere you webserver can access it.
* Create a directory for your books. I use "Books" at the root of my userdir.
* Copy config.php.template to config.php and edit config.php

* Add the following entries to your apache config.
  (If you use a different webserver, prepare to virtual hosts along these lines)

---



    Listen 8080
    <VirtualHost *:8080>
        ServerName [HOSTNAME]
        ServerAlias [OPTIONAL_ALIASES]
        DocumentRoot [PATH_TO_SOURCE]
        DirectoryIndex index.php
        <Directory [PATH_TO_SOURCE]>
            Options +ExecCGI
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>


    Listen 9999
    <VirtualHost *:9999>
        ServerName [HOSTNAME]
        ServerAlias [OPTIONAL_ALIASES]
        DocumentRoot [PATH_TO_SOURCE]
        DirectoryIndex index.php
        <Directory [PATH_TO_SOURCE]>
            Options +ExecCGI
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>

---

If you want Stanza to pick up your Library automagically, prepare a way to add 
the following record to your zeroconf service:

    mDNS -R "Local Giles" _opds._tcp local 9999

I use a Launch Agent in ~/Library/LaunchAgents/org.nothorse.RegisterGiles

    <?xml version="1.0" encoding="UTF-8"?>
    <!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
    <plist version="1.0">
    <dict>
      <key>KeepAlive</key>
      <true/>
      <key>Label</key>
      <string>at.grendel.GilesRegisterService</string>
      <key>ProgramArguments</key>
      <array>
        <string>mDNS</string>
        <string>-R</string>
        <string>Local Giles</string>
        <string>_opds._tcp</string>
        <string>local</string>
        <string>9999</string>
      </array>
      <key>QueueDirectories</key>
      <array/>
      <key>RunAtLoad</key>
      <true/>
      <key>WatchPaths</key>
      <array/>
    </dict>
    </plist>
    
---

To add a book to the catalog call addbook.php
  
    > ~/your/path/to/source/addbook.php -f agoodbook.epub