<?php
require_once '../IRCBot/src/Application.php';

class NpoBot_Main
{

    public function  __construct()
    {
        //Registers events callbacks
        addEventCallback('onConnect', array($this, 'onConnect'));
        
        //Connect the bot to the server and registrer it in the framework
        $bot = new IRCBot_Types_Bot();
        $bot->nickname = 'NPO-bot';
        $bot->connect('localhost'); 
        IRCBot_Application::getInstance()->getBotHandler()->addBot($bot);
        
        //Add this module to the framework and start the event loop
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
