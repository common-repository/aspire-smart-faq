=== Aspire Smart FAQ plugin ===
Contributors: Aspiresolutions
Donate link: http://aspiresolution.com/
Tags: Faq, Custom Faq
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

With Aspire Smart FAQ you can use custom post types and taxonomies to manage FAQs section for your site along with many more features.

== Description ==

The Aspire Smart FAQ plugin uses a combination of custom post types, and taxonomies. The plugin will automatically create single post using your existing permalink structure. FAQ categories and tags can be added to the menu by using the WP Menu Manager.
Shortcodes

Features<br>
1.Custom Post Type for FAQs<br>
2.Custom Taxonomy for tags and categories in FAQs<br>
3.Run time Sorting of FAQs <br>
4.Jquery Accordion for FAQs<br>
5.Display settings for front end<br>
6.Different types of shortcodes for showing FAQs<br>
7.Separate widgets for categories, tags and single FAQ<br>
8.Detailed view of single FAQ<br>


== Installation ==

1.Upload the 'aspire_smart_faq' folder to the /wp-content/plugins/ directory or install via the WP admin panel<br>
2.Activate the plugin through the 'Plugins' menu in WordPress<br>
3.That's it.<br>


== Frequently Asked Questions ==
The Aspire Smart FAQ plugin uses a combination of custom post types, and taxonomies. The plugin will automatically create single post using your existing permalink structure. FAQ categories and tags can be added to the menu by using the WP Menu Manager.
Shortcodes
The plugin provides ability to add short codes. Please follow the below mentioned syntax accordingly in the HTML tab:
For the complete list (including title and content) see below:

Shortcode [multi_faq] will list all FAQs in all categories and all tags.

Shortcode [multi_faq cat_name="general"] will list all the FAQs related to a particular category. User must input category's slug and not the category name.

Shortcode [multi_faq tag_name="support"] will list all the FAQs related to a particular tag slug.

Shortcode [multi_faq limit="5"] will list FAQs for a defined limit. In this case only 5 FAQs will be listed.

Shortcode [multi_faq limit="5" cat_name="general"] will list the FAQs for a defined limit but within a specific category slug.

Shortcode [multi_faq limit="5" tag_name="support"]will list the FAQs for a defined limit but within a specific tag slug.

Shortcode [multi_faq cat_name="general, payment, order"] will list all the FAQs related to multiple categories (comma separated). User must input category's slug and not the category name in each case.

Shortcode [multi_faq tag_name="support, delivery"] will list all the FAQs related to multiple tags (comma separated). User must input tag's slug and not the tag name in each case.

Shortcode [single_faq id="34"] will list the FAQ of id of 34.

Shortcode [list_faq] will list all the FAQs without answers. Clicking on a particular question will open up a new page with same question and related answer.

Shortcode [list_faq] can also be used with limit="" cat_name="" tag_name="" like [list_faq limit="5" cat_name="general"]

Note: tag_name and cat_name, If both are used in any short code, preference will given to tag_name and related results will be shown.

Widgets instructions

With Aspire Smart FAQ plugin we have 3 widgets that will perform multiple functions, below is the list of these widgets and their explanation.
•	Aspire Smart FAQ plugin : Categories
•	Aspire Smart FAQ plugin : Tags
•	Aspire Smart FAQ plugin : Single
Aspire Smart FAQ plugin : Categories
This widget has two input parameters
Categories slug
FAQs Limit
Categories slug can be singular or multiple (e.g. general, payment)
Limit should be a positive number (e.g. 5)
Example (Category: general and Limit: 5) so it will be showing Recent 5 records from General Category

Aspire Smart FAQ plugin : Tags
This widget has two input parameters
Tags slug
FAQs Limit
Tags slug can be singular or multiple (e.g. support, order)
Limit should be a positive number (e.g. 5)
Example (Tag: support and Limit: 5) so it will be showing Recent 5 records from Support tag

Aspire Smart FAQ plugin : Single

FAQ ID
FAQ ID should be ID for your any existing FAQ (e.g. 68)
Example (FAQ ID: 68) so it will be showing FAQ whose ID is 68

== Screenshots ==

1. **Add new Faq**

2. **Backend Menu**

3. **Plugin Settings**

4. **Faq Display on Front Side**

5. **Faq Widget**

5. **Sorting Faq**
== Changelog ==


== Upgrade Notice ==


== Arbitrary section ==