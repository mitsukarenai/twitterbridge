twitterbridge
===========================

Yet another Twitter API 1.1 compliant timeline RSS/JSON feed builder, meant to resume the [Autoblog Project](https://github.com/mitsukarenai/Projet-Autoblog)'s Twitter support.

Uses Abraham Williams's Twitter OAuth class; Uses stormuk's StormTwitter class

## NOTICE:

[Sebsauvage](https://github.com/sebsauvage/) and other devs including me have started a project to provide "feed bridges" for various websites with poor or no RSS/ATOM feed: [rss-bridge](https://github.com/sebsauvage/rss-bridge). The Twitter module is based on twitterbridge-noapi, and includes new stuff. Check it out ! :smile: 

**twitterbridge is therefor DEPRECATED unless you need API-friendly code to build on or learn all the shit you must do when working on Twitter.**

===================
===================


Version 0.2 alpha
============================

- new: username whitelist in JSON array. Only allowed usernames are processed. Try to keep it under 20 usernames.
- new: raw JSON output
- new: separate config file
- new: configuration checks
- changed: cache file structure
- changed: cache expiration (5 minutes is enough right ?)

Usage
============================

- Twitterbridge status:

./index.php?status

- RSS output:

./index.php?u=support

- JSON output (raw Twitter proxy mode):

./index.php?u=support&format=json

(where "support" is the screen name)

Autoblog Project integration
============================

Just set in your `config.php` :
```php
define( 'API_TWITTER', 'http://twitterbridge.domain.tld?u=' );
```


Tips
============================

- Dont forget to put a `/` after your cache folder name in `config.php`.
