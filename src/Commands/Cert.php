<?php
require_once 'src/Daos/Certificates.php';

class NpoBot_Commands_Cert
{

    private $_spamfilter;
    
    public function __construct(NpoBot_Spamfilter $spamfilter)
    {
        $this->_spamfilter = $spamfilter;
        $ircBot = \Ircbot\Application::getInstance();
        $ircBot->getModuleHandler()->addModuleByObject($this);
        $ircBot->getUserCommandHandler()
            ->setDefaultMsgType(TYPE_CHANMSG)
            ->setDefaultScanType(IRCBOT_USERCMD_SCANTYPE_REGEX)
            ->addCommand(array($this, 'onCert'), '/^[!@.]cert (.+)$/i');
    }
    
    public function onCert(IRCBot_Commands_PrivMsg $msg)
    {
        if (!$this->_spamfilter->checkCommand($msg)) {
            return false;
        }
        $dao = new Npobot_Daos_Certificates();
        $cert = $dao->getCertificate('Some nick');
        \Ircbot\msg(chan(), 'Id: ' . $cert->getId());
    }
    
}
