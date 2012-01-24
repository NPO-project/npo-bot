<?php
require_once '../IRCBot/src/Application.php';

class NpoBot_Main
{
    public function  __construct() {
        //Registreer events
        addEventCallback('onConnect', array($this, 'onConnect'));
        
        //Verbind een bot met de IRC server
        $bot = new IRCBot_Types_Bot();
        $bot->nickname = 'NPO-bot';
        $bot->connect('localhost'); 
        IRCBot_Application::getInstance()->getBotHandler()->addBot($bot);
        
        //Laad de module in het framework en start de loop
        $ircBot = IRCBot_Application::getInstance();
        $ircBot->getModuleHandler()->addModuleByObject($this);
        $ircBot->getLoop()->startLoop();
    }
    
    public function onConnect()
    {
        joinChan('#tw.nl-npo');
    }

}

new NpoBot_Main();
