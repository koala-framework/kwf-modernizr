<?php
class Kwf_Modernizr_DependencyProvider extends Kwf_Assets_Provider_Abstract
{
    public function getDependency($dependencyName)
    {
        if ($dependencyName == 'Modernizr') {
            return new Kwf_Modernizr_Dependency();
        } else if (substr($dependencyName, 0, 9) == 'Modernizr') {
            $feature = substr($dependencyName, 9);
            $m = $this->_providerList->findDependency('Modernizr');
            $m->addFeature($feature);
            return $m;
        }
    }
}
