monolog-experiments
===

Examples of using some of the specialized handlers, processors, and formatters provided by
[monolog](https://github.com/Seldaek/monolog).

author: Will Vaughn  
github: [nackjicholson](https://github.com/nackjicholson)  
twitter: [@nackjicholsonn](https://twitter.com/nackjicholsonn)  

For the email ones you'll need `mail()` for php to work from your mac. Which is downright impossible. I recommend just
deploying this code to a box with mail setup correctly, frankly deploying is easier than wrangling with Mac OSX. I
uploaded this to a fairly default Amazon Linux instance on EC2 and it works okay.

To run these:

```
git clone git@github.com:PHPDX/monolog-experiments.git
cd monolog-experiments
curl -sS https://getcomposer.org/installer | php
php composer.phar install
php multipleStreams.php
```
