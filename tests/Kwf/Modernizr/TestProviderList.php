<?php
class Kwf_Modernizr_TestProviderList extends Kwf_Assets_ProviderList_Abstract
{
    public function __construct()
    {
        parent::__construct(array(
            new Kwf_Modernizr_DependencyProvider(),
            new Kwf_Assets_Provider_Ini(dirname(__FILE__).'/ProviderTestDependencies.ini'),
            new Kwf_Assets_Provider_IniNoFiles(),
        ));
    }
}
