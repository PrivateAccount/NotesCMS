# NotesCMS

## Full featured CMS containing private notes module.
## Based on my own MVC architecture.

### Application features:
* users authentication (ACL)
* admin panel (settings, templates, styles, scripts, navigation, articles, gallery)
* activity reports (messages, comments, visits)
* statistics on charts (period customization, ip frequency)
* comments system
* private notes system (the newest feature)

### General:
* Language: PHP / OOP / JavaScript
* Database: MySQL
* DB interface: PDO
* User Interface: Bootstrap 4
* On-line: http://my-notes.pl

### Installation:
* create new empty database on hosting account
* unpack ZIP and upload to hosting server to public_html folder
* change folders attributes: chmod 777 -R gallery/ css/ js/ application/templates/ install/
* write database connection parameters in config / config.php
* open web page in the browser - URL: http://{your-domain}/
* fill settings form and submit
* that's all!

### Reset application:
* upload /install folder to hosting server to public_html folder
* open web page in the browser - URL: http://{your-domain}/
* fill settings form and submit
* that's all!

### License:
NotesCMS is open-sourced software licensed under the MIT license.
