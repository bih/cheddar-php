![Cheddar Logo](http://i.imgur.com/6G0Jv.png "Cheddar Logo")

Hi. I've decided to build an awesome [Cheddar](https://cheddarapp.com) PHP library that allows you to send API calls to [Cheddar](https://cheddarapp.com) with one or two lines of code.

Introduction
========
The framework is still in early stages, so we would not say it's ready for production just yet.

I'm actively working on the library, and would encourage other developers to play about it. I've thought about the convention over configuration philosophy to make Cheddar a breeze to work with, and I will focus on developing Cheddar PHP to continue this philosophy whilst it grows.

There's still a lot of unused code in the library, because the Cheddar API is still actively being developed. We will update Cheddar PHP as and when Cheddarapp.com updates their API.

Requirements
========
Cheddar PHP requires PHP 5, cURL, and safe_mode off.

The library has only been tested for PHP 5. We would therefore advise you to only use PHP 5 until we've tested it on other installations.

Installation
========
It's quite simple really. Just upload Cheddar.php to your server and include it in your files where it will be used.

Instructions
========
See example.php for a executable demo.

1. To use Cheddar PHP, you must first include the file.
2. Then you must use the code below to initiate Cheddar PHP. Update it with the relevant data.

``` $cheddar = new Cheddar_PHP( $app_id, $app_secret, $access_token = '' ); ```
3. Then use the call() function to make a request. See [Cheddar API documentation](http://cheddarapp.com/developer) for more information.
4. The data is returned in JSON. Use var_dump() and print_r() to obtain data and extract as necessary.
5. Have fun!

Author
========
Hi. I'm Bilawal Hameed. You can visit my website to learn more about me [here](http://bilaw.al).