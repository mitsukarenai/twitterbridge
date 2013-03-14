twitterbridge
===========================

Yet another Twitter API 1.1 compliant timeline RSS/JSON feed builder, meant to continue the Autoblog Project's Twitter support.

Uses Abraham Williams's Twitter OAuth class; Uses stormuk's StormTwitter class


Version 0.2 alpha
============================

- new: username whitelist in JSON array. Only allowed usernames are processed. Try to keep it under 20 usernames.
- new: raw JSON output
- new: separate config file
- new: configuration checks
- changed: cache file structure
- changed: cache expiration (15 minutes is enough right ?)

Usage
============================

- RSS output:

./index.php?u=support

- JSON output (raw Twitter proxy mode):

./index.php?u=support&format=json

(where "support" is the screen name)

Tips
============================

- Dont forget to put a `/` after your cache folder name in `config.php`.
