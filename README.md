# Cornerstone responsive starter theme for WordPress

Forked by error500
(Im trying to integer scss support and a bower install.)


Cornerstone is a WordPress starter theme based on the Zurb Foundation Responsive Framework. Cornerstone aims to provide a lightweight starter theme that is responsive and SEO friendly that web designers can build great looking websites on.

This version of Cornerstone is based on [ZURB Foundation 5](http://foundation.zurb.com/). Foundation 4 removed support for IE8. A CSS file to provide support for the IE8 grid is included as part of Cornerstone, but no other support for IE8 can be guaranteed. For a version of Cornerstone based on Foundation 3 go to https://github.com/thewirelessguy/cornerstone-foundation3

Cornerstone is not meant to be used as is. This theme is designed to be used as a parent theme to create a Child Theme from. If you’re unsure how to do this follow the guide at (http://codex.wordpress.org/Child_Themes). You can download an example Child Theme at (https://github.com/thewirelessguy/cornerstone-child-theme)


## Download

Clone the git repo `git clone https://github.com/error500/cornerstone.git` or [download the archive](https://github.com/thewirelessguy/cornerstone/archive/master.zip).

## Authors

**ZURB**

Foundation was made by [ZURB](http://foundation.zurb.com/), a product design company in Campbell, California. Their Github repository can be found at https://github.com/zurb/foundation

**Stephen Mullen**

Stephen is a web designer and Android app developer based in Preston, UK
+ [Twitter @wirelessguyuk](http://twitter.com/wirelessguyuk)
+ [Website](http://thewirelessguy.co.uk)

#Added in this fork#
##Changes##
Moved some folders : all dependencies in /libs
sass compliant : develop your scss in the child theme and compile into parent 

##Installation##

First: clone parent and child themes 


Then in parent type
`bower install`

In child type
`compass watch`

In child, develop your css rules in /scss/apps.scss

