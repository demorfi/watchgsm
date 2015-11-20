# WatchGSM
----------
WatchGSM is a watchdog for service SMS Server Tools 3 (SMSTools3)

Required
========
* SMS Server Tools 3
* Access to config (SMSTools 3) `smsd.conf`

Pre-Requirements
========
* Git
* Composer

Features
========
* Allows you to view and send SMS messages
* Create message templates
* Performs scheduled tasks
* Performs events

Install
=====
* Change into web directory: `cd /usr/local/www`
* Clone repository: `git clone https://github.com/demorfi/watchgsm.git watchgsm && cd watchgsm`
* Install composer dependencies: `composer install`
* Change path in config/general.php to your smsd.conf (SMSTools 3) config
* [Add script sync in cron for auto updating messages]: `* * * * * /usr/local/www/watchgsm/bin/sync >> /dev/null 2>&1`

Screenshots
===========
Compose new sms
![compose](https://cloud.githubusercontent.com/assets/7579267/9378428/e22e11b6-473a-11e5-9a5d-115296477797.png)

Adding message to schedule
![schedule](https://cloud.githubusercontent.com/assets/7579267/9378426/e22c49f8-473a-11e5-8f04-68351374ccb8.png)

Adding new event
![event](https://cloud.githubusercontent.com/assets/7579267/9378427/e22d9718-473a-11e5-8e4c-d17153054749.png)

Change Log
==========
v0.6.0 - Nov 20, 2015
--------------------
 * Added use default time zone
 * Added cleaning logs
 * Added page for failed messages
 * Added message counters
 * Added support sending voice messages
 * Added event management
 * Added truncate long text of sms
 * Added trigger for events
 * Added script for auto update all messages
 * Changed sync method
 * Minor design changes
 * Minor bug fix
 
v0.3.1 - Aug 08, 2015
--------------------
 * Added sync messages
 * Added send message and save message in template
 * Added send messages on schedule
 * Minor design changes
 * Bug fix

v0.1.2-dev - July 03, 2015
--------------------
 * Added basic page
 * Added support for reading messages
 * Fixed design

v0.0.1-dev - Apr 26, 2015
--------------------
 * Initialize repository

License
=======
WatchGSM is licensed under the [MIT License](http://www.opensource.org/licenses/mit-license.php).
