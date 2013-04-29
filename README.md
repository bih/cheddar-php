### <div align="center">*Notice: This library is no longer being maintained. Use at your own peril.*</div>
------

![Cheddar Logo](http://i.imgur.com/Beqwh.png "Cheddar Logo")

### Cheddar-PHP [v1.1] is a PHP5 library that works out of the box with [Cheddar](https://cheddarapp.com).

Introduction
------
[Cheddar](http://cheddarapp.com) is an minimalist-and-cool task management tool that is always in sync. With the release of their API, I decided that it was time I should release more code on GitHub and I thought Cheddar would be a great start.

Requirements
------
Cheddar PHP requires at least PHP 5.3 and cURL.

Installation
------
Upload **Cheddar.php** to your folder. That's it!

Instructions
------
See ```Example.php``` and ```Simple_Example.php``` for a executable demo.

Steps:
* Ensure the file has been included through ```require 'Cheddar.php';```
* Obtain your Cheddar Application ID/Secret [by clicking here](http://cheddarapp.com/developer/apps).
* Ensure your Return URL is the page where ```$cheddar->get_access_token();``` is being called!
* Place your Application ID/Secret through ```$cheddar = new Cheddar\API('app_id=APP ID HERE&app_secret=APP_SECRET_HERE'); ```.
* See ```Example.php``` and make request you wish.
* The data is returned as an Object. Use ```var_dump()``` or ```print_r()``` to see the values necessary, or look at the examples.

**Have fun!**

Author
========
Hi. I'm Bilawal Hameed. You can visit my website to learn more about me [here](http://bilaw.al).
