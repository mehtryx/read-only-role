=== wp-post-importer ===
Contributors: Keith Benedict <kbenedict@postmedia.com>
Tested up to: 3.5.1
Stable tag: 1.1.3

Pull posts from wordpress public API

== Description ==

wp-post-importer uses wp-cron to run scheduled imports from our wordpress instances, pulling stories and photos if the author exists, option for default author available.

== Installation ==

Activate the plugin/include in functions.php, go to the settings page and configure the settings, enable the schedules import from the settings page.  Review content as it is imported, plugin settings page displays the last execution time and the last error if any.

== Configuration ==

By default the plugin is disabled, it will not enable unless you have specified a blog address that is valid. The following are the configuration options available:

 * Author Action - Specify the action to take when the stories author does not exist, discard the story, add the author, assign to random author.
 * Create Missing Categories - when enabled, categories not present will be created.
 * Since Publish Date/time - indicates the Date/time to pull posts after, must be valid ISO 8601 format (i.e. 2013-01-18T09:00:00-05:00), this auto updates as imports complete.
 * Frequency - Plugin includes additional cron intervals down to 1 minute. Recommended 15 min for normal development use.
 * Number to Import - The maximum number of stories to import per run. Default is 10, stories under 100 characters are ignored.
 * Blog - The WordPress blog domain name i.e. blogs.windsorstar.com

Author Action
---------------
The plugin by default will discard posts with an author not in the local authors table, set to create to include new authors.

I put this feature in to support a couple of use cases, including localized development where authors don't matter to the test data, in which case the random author acts as the old auto importer plugin with one exception, if the author is present, it uses that author, otherwise its random.

If you have a strict set of authors you wish to have posts from, using the discard option will prevent other stories from being imported.  In our production test environment where we simply want as many stories as possible, the best choice is the 'create' option which adds missing authors, all new authors are given a random email that follows the syntax of author_namexxxx@post.importer  where xxxx = random number.  

Categories
-----------
The plugin by default will not create missing categories, if you have no categories set then this should be turned on for a short time only, once a good base set of categories exist you will need to organize the hierarchy.

Since
--------
If not specified the plugin will start at the oldest available data, it is recommended to fill in the plugin using a proper ISO 8601 date string, this includes:

2013
2013-02
2013-02-15
2013-02-15T00:00:00
2013-02-15T00:00:00-05:00

There are many more, you can google for ISO 8601 format to see the options, the plugin validates and only accepts an ISO 8601 formatted date, as the plugin works with content it will update this field to the next time increment to retrieve.

Frequency
----------
This plugin depends on cron, however in a php application like this the cron scheduler is not fired unless there is activity, so the frequency here is the minimum time between import operations, but the maximum time is variable based on the next request past the minimum time.

Number to Import
-----------------
Easy to explain, the number of post items to retrieve, by default the plugin will request 10, the maximum supported by the wordpress API is 100, since this plugin pulls all media with the story, it is recommended to balance number of posts with the frequency.

Blog
-----

Examples of blogs you might use:

WindsorStar - blogs.windsorstar.com
Canada - o.canada.com
National Post - news.nationalpost.com



== Changelog ==

= 1.0 =

* First version


= 1.1 = 

* Added functionality to support multiple import sources
* Changed scheduled events to minimize/prevent chances of events firing twice
* Added category filters, this is a comma separated list of categories added to the parameters for each blog request.

= 1.1.1 =

* Added dedupe function to analyze past titles for stories published multiple times in succession or simply pulled by error.

= 1.1.2 =

* Additional parsing of body for images which were not attached to post, but copy/pasted into content.
* Use wp_check_)_filetype_ function to determine attachment mime type instead of depending on source data
* Moved last_since update to occur even if duplicates found, advances pointer to next story regardless.
* Updated last_since calculation

= 1.1.3 =

* Removed remote connection to validate blog address, still validates and sanitizes blog url option

