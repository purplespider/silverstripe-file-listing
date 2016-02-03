# File Listing Module
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/purplespider/silverstripe-file-listing/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/purplespider/silverstripe-file-listing/?branch=master)

## Introduction

Provides basic "multiple file download" page to a SilverStripe site. 

Designed to provide a simple, fool-proof way for users to add mutliple file downloads to a page on their website.

This module has been designed to have just the minimum required features, to avoid bloat, but can be easily extended to add new fields if required.

## Maintainer Contact ##
 * James Cocker (ssmodulesgithub@pswd.biz)
 
## Requirements
 * Silverstripe 3.0+
 
## Installation Instructions

1. Place the contents of this repository in a directory named *file-listing* at the root of your SilverStripe install.
2. Visit yoursite.com/dev/build to rebuild the database.
3. Log in the CMS, and create a new *File Download Page* page.

## Features

* Choose an assets sub folder from a dropdown in the CMS
* The page shall then list all the files within that folder, along with download links and image previews
* Button on CMS page, takes users sraight to that assets folder to manage files
* Supports subfolders
* Lightbox support