<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglLegacyApplication\Options;

class LegacyControllerOptions extends \Zend\Stdlib\AbstractOptions
{

    private $docRoot = array('public');

    private $indexFiles = array();

    private $globals = array(
        'get' => true,
        'request' => true,
    );

    public function getDocRoot()
    {
        return reset($this->docRoot);
    }

    public function getDocRoots()
    {
        return $this->docRoot;
    }

    public function getGlobals()
    {
        return $this->globals;
    }

    public function setDocRoot($docRoot)
    {
        if(!is_array($docRoot)) {
            $docRoot = array($docRoot);
        }
        $this->docRoot = $docRoot;
    }

    public function setGlobals($globals)
    {
        $this->globals = $globals;
    }

    /**
     * @return array
     */
    public function getIndexFiles()
    {
        return $this->indexFiles;
    }

    /**
     * @param array $indexFiles
     */
    public function setIndexFiles($indexFiles)
    {
        $this->indexFiles = $indexFiles;
    }
}
