<?php
class Kwf_Modernizr_Dependency extends Kwf_Assets_Dependency_Abstract
{
    private $_features = array();
    private $_fileNameCache;

    public function addFeature($feature)
    {
        $this->_features[] = $feature;
        unset($this->_fileNameCache);
    }

    public function getFeatures()
    {
        return $this->_features;
    }

    public function getMimeType()
    {
        return 'text/javascript';
    }

    public function getContents($language)
    {
        if (isset($this->_fileNameCache)) return $this->_fileNameCache;

        if (!$this->_features) return null;

        $outputFile = tempnam('/tmp', 'modernizr');

        $extensibility = array(
            "addtest"      => false,
            "prefixed"     => false,
            "teststyles"   => false,
            "testprops"    => false,
            "testallprops" => false,
            "hasevents"    => false,
            "prefixes"     => false,
            "domprefixes"  => false
        );

        $tests = array();
        foreach ($this->_features as $f) {
            $f = strtolower($f);
            if (isset($extensibility[$f])) {
                $extensibility[$f] = true;
            } else {
                $tests[] = strtolower($f);
            }
        }

        $config = array(
            'modernizr' => array(
                'dist' => array(
                    'devFile' => false,
                    'outputFile' => $outputFile,
                    'extra' => array(
                        "shiv"       => false,
                        "printshiv"  => false,
                        "load"       => false,
                        "mq"         => false,
                        "cssclasses" => true
                    ),
                    'extensibility' => $extensibility,
                    'uglify' => true,
                    'tests' => $tests,
                    'parseFiles' => false,
                    'matchCommunityTests' => false,
                    'customTests' => array()
                )
            )
        );

        $gruntfile  = "    module.exports = function(grunt) {\n";
        $gruntfile .= "    grunt.initConfig(";
        $gruntfile .= json_encode($config);
        $gruntfile .= ");\n";
        $gruntfile .= "    grunt.loadNpmTasks(\"grunt-modernizr\");\n";
        $gruntfile .= "    grunt.registerTask('default', ['modernizr']);\n";
        $gruntfile .= "};\n";

        $cwd = getcwd();
        chdir(dirname(dirname(dirname(__FILE__))));
        file_put_contents('Gruntfile.js', $gruntfile);
        $cmd = "./node_modules/.bin/grunt 2>&1";
        exec($cmd, $out, $retVar);
        unlink('Gruntfile.js');
        if (file_exists($outputFile)) $ret = file_get_contents($outputFile);
        unlink($outputFile);
        chdir($cwd);
        if ($retVar) {
            throw new Kwf_Exception("Grunt failed: ".implode("\n", $out));
        }
        return $ret;
    }

    public function getMTime()
    {
//         return filemtime($this->getAbsoluteFileName());
        return time();
    }

    public function __toString()
    {
        return 'Modernizr('.implode(',', $this->_features).')';
    }
}
