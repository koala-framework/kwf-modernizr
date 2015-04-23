
# DEPRECATED, moved into koala-framework

## Koala Framework Modernizr Integration [![Build Status](https://travis-ci.org/koala-framework/kwf-modernizr.svg?branch=master)](https://travis-ci.org/koala-framework/kwf-modernizr)

This builds an customized build of modernizr using grunt-modernizr that includes all required modernizr tests.

To add an additional required test use the following dependency:

    ModernizrCssAnimations


eg. in Component getSettings():

    $ret['assets']['dep'][] = 'ModernizrCssAnimations';


http://www.koala-framework.org/

open source framework for web applications and websites
