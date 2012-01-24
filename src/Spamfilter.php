<?php

class NpoBot_Spamfilter
{
    private $_userFilter;
    private $_userIgnore = array();
    private $_prevTime;
    
    public function __construct()
    {
        $this->_prevTime = time();
    }
    public function checkList()
    {
        $debugger = IRCBot_Application::getInstance()->getDebugger();
        if ((time() - $this->_prevTime) >= 3) {
            if (!empty($this->_userFilter)) {
                $debugger->log(
                    'Spamfilter',
                    'User',
                    'Shifting command from spamfilter list.'
                );
                foreach ($this->_userFilter as $host => $data) {
                    array_shift($this->_userFilter[$host]);
                    $debugger->log(
                        'Spamfilter',
                        'User',
                        'Shifted command by host ' . $host, IRCBOT_DEBUG_EXTRA
                    );
                    if (empty($this->_userFilter[$host])) {
                        unset($this->_userFilter[$host],
                        $this->_notifications['users'][$host]);
                    }
                }
            }
            $this->_prevTime = time();
        } 
    }
    public function ignoreUser($host)
    {
        $this->_userIgnore[strtolower($host)] = true;
    }
    public function unignoreUser($host)
    {
        unset($this->_userIgnore[strtolower($host)]);
    }
    public function clearFilters()
    {
        $this->_userFilter = array();
    }
    public function checkCommand(IRCBot_Types_MessageCommand $msg)
    {
        $debugger = IRCBot_Application::getInstance()->getDebugger();
        if (isset($this->_userIgnore[strtolower($msg->mask->host)])) {
            $debugger->log(
                'Spamfilter',
                'Blocked',
                'Ignored user ' . $msg->mask, IRCBOT_DEBUG_EXTRA
            );
            return false;
        }
        $this->_userFilter[strtolower($msg->mask->host)][] = time();
        if (count($this->_userFilter[strtolower($msg->mask->host)]) > 2) {
            $debugger->log(
                'Spamfilter',
                'Blocked',
                'Blocked command from user ' . $msg->mask, IRCBOT_DEBUG_EXTRA
            );
            return false;
        }
        return true;
    }
}
