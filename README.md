![Cheddar Logo](http://i.imgur.com/Beqwh.png "Cheddar Logo")

### Cheddar-PHP [v1.1] is a PHP5 library that works out of the box with [Cheddar](https://cheddarapp.com). It is free, minimalistic, actively maintained, and is fully documented with examples. ###

Introduction
------
[Cheddar](http://cheddarapp.com) is an minimalist-and-cool task management tool that is always in sync. With the release of their API, I decided that it was time I should release more code on GitHub and I thought Cheddar would be a great start.

I build software to favour convention over configuration, and to "just work" similar to Cheddar. I've also designed my own implementation of oAuth that is incredibly simple and lightweight, so it requires no other additional libraries.

The framework is being maintained, and I would say it's almost stable.

Requirements
------
Cheddar PHP requires at least PHP 5.3 and cURL.

Installation
------
Upload **Cheddar.php** to your folder. That's it!

Instructions
------
See ```Example.php``` and ```Simple_Example.php``` for a executable demo.

1. Ensure the file has been included through ```require 'Cheddar.php'; ```
2. Obtain your Cheddar Application ID/Secret [by clicking here](http://cheddarapp.com/developer/apps).
3. Ensure your Return URL is the page where ```$cheddar->get_access_token();``` is being called!
4. Place your Application ID/Secret through ```$cheddar = new Cheddar\API('app_id=APP ID HERE&app_secret=APP_SECRET_HERE'); ```.
5. See ```Example.php``` and make request you wish.
6. The data is returned as an Object. Use ```var_dump()``` or ```print_r()``` to see the values necessary, or look at the examples.

**Have fun!**

Author
========
Hi. I'm Bilawal Hameed. You can visit my website to learn more about me [here](http://bilaw.al).