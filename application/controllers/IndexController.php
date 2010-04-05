<?php

class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
    }
    
    public function jsAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        
        $path = APPLICATION_PATH . '/js/_common';
        $files = $this->_rglob("*.js", 0, $path);

        $output = "";

        foreach ($files as $file) {
            $output .= file_get_contents($file) . ' ';
        }
        
        $module = $this->_getParam('module', false);
        
        if ($module) {
            $path = APPLICATION_PATH . "/js/$module";
            $files = $this->_rglob("*.js", 0, $path);
            foreach ($files as $file) {
                $output .= file_get_contents($file) . ' ';
            }
        }
        
        echo $output;
    }
    
    public function moduleAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        
        $output = "";

        $module = $this->_getParam('load', false);
        
        if ($module) {
            $path = APPLICATION_PATH . "/js/$module";
            $files = $this->_rglob("*.js", 0, $path);
            foreach ($files as $file) {
                $output .= file_get_contents($file) . ' ';
            }
        }
        
        echo $output;
    }
    
    
    
    protected function _rglob($pattern, $flags = 0, $path = '') {
        if (!$path && ($dir = dirname($pattern)) != '.') {
            if ($dir == '\\' || $dir == '/') $dir = '';
            return $this->_rglob(basename($pattern), $flags, $dir . '/');
        }
        $paths = glob($path . '*', GLOB_ONLYDIR | GLOB_NOSORT);
        $files = glob($path . $pattern, $flags);
        foreach ($paths as $p) $files = array_merge($files, $this->_rglob($pattern, $flags, $p . '/'));
        return $files;
    }
}

