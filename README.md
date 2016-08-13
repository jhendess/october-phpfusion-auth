# PHP Fusion authentication for OctoberCMS

This is a small plugin which can be used for migrating the users of an existing PHP Fusion 7.x system to
[OctoberCMS](https://octobercms.com). It might also be possible to use this plugin to migrate PHP Fusion 9.x user, but
I have no existing system to try this.

## Installation

1. Copy the content of this repository to `jhendess/fusionauth` in your October plugins folder
2. Run `php artisan plugin:refresh jhendess:fusionAuth` to install the necessary columns

## Userbase migration

When migrating your users, make sure that the following columns of your PHP Fusion user table match the columns in you October user table:
 
 - user_password => password
 - user_algo => fusion_algo
 - user_salt => fusion_salt
 
After the user authenticated for the first time, the password will be rehashed using October's default hashing algorithm.