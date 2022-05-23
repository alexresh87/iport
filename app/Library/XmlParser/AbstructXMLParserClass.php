<?php

namespace App\Library\XmlParser;

abstract class AbstructXMLParserClass
{
    protected $reader;

    protected $_break;
    protected $_events = [];

    public function __construct($path)
    {
        $this->reader = new \XMLReader();
        if (is_file($path))
            $this->reader->open($path);
        else {
            throw new \Exception('File {' . $path . '} not exists!');
        }
        $this->_break = false;
    }


    public function on($event, $callback)
    {
        if (!isset($this->_events[$event]))
            $this->_events[$event] = [];
        $this->_events[$event][] = $callback;
        return $this;
    }

    public function fireEvent($event, $params = null, $once = false)
    {
        if ($params == null)
            $params = array();
        if (!isset($this->_events[$event]))
            return false;
        foreach ($this->_events[$event] as $i => $eventFunc) {
            if (is_callable($eventFunc)) {
                call_user_func_array($eventFunc, $params);
            }
            if ($once == true) {
                unset($this->_events[$event][$i]);
            }
        }
    }

    public function parse()
    {
        $this->reader->read();
        while ($this->reader->read()) {
            if ($this->_break) {
                break;
            }
            if ($this->reader->nodeType == \XMLREADER::ELEMENT) {
                $fnName = 'parse' . ucfirst(mb_strtolower($this->reader->localName));
                if (method_exists($this, $fnName)) {
                    $lcn = $this->reader->name;
                    if ($this->reader->name == $lcn && $this->reader->nodeType != \XMLREADER::END_ELEMENT) {
                        $data = $this->{$fnName}();
                        $this->fireEvent($fnName, ['data' => $data]);
                    }
                }
            }
        }
    }

    public function breakParse()
    {
        $this->_break = true;
    }
}
