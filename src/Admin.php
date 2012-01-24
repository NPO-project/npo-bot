<?php

class NpoBot_Admin
{
    
    public function __construct()
    {
        $ircBot = IRCBot_Application::getInstance();
        $ircBot->getModuleHandler()->addModuleByObject($this);
        $ircBot->getUserCommandHandler()
            ->setDefaultMsgType(TYPE_CHANMSG)
            ->setDefaultScanType(IRCBOT_USERCMD_SCANTYPE_REGEX)
            ->addCommand(array($this, 'onExec'), '/^EXEC /i');
    }
    
    public function onExec(IRCBot_Commands_PrivMsg $msg)
    {
        if ($this->isAdmin($msg->mask)) {
            msg(chan(), 'Return: ' . eval(token('1-')));
        }
    }
    
    public function isAdmin(IRCBot_Types_Mask $mask)
    {
        if ($mask->host == 'localhost') {
            return true;
        }
    }
    
}
