<?php
require_once '../IRCBot/src/Application.php';

require_once 'Spamfilter.php';

class NpoBot_Main
{

    private $_spamfilter;

    public function  __construct()
    {
        //Registers events callbacks
        addEventCallback('onConnect', array($this, 'onConnect'));
        
        //Connect the bot to the server and registrer it in the framework
        $bot = new IRCBot_Types_Bot();
        $bot->nickname = 'NPO-bot';
        $bot->connect('localhost'); 
        IRCBot_Application::getInstance()->getBotHandler()->addBot($bot);
        
        //Add this module to the framework
        $ircBot = IRCBot_Application::getInstance();
        $ircBot->getModuleHandler()->addModuleByObject($this);
        
        //Initialize all the other modules
        $this->initializeModules();
        
        //Start the event loop
        $ircBot->getLoop()->startLoop();
    }
    
    /**
     * This function initialzes all the other modules
     * 
     * @todo The functions inhere need to in the modules itself
     * @return void
     */
    public function initializeModules()
    {
        $ircBot = IRCBot_Application::getInstance();
        $this->_spamfilter = new NpoBot_Spamfilter();
        $ircBot->getModuleHandler()->addModuleByObject($this->_spamfilter);
        $ircBot->getEventHandler()->addEventCallback(
            'loopIterate',
            array($this->_spamfilter, 'checkList')
        );
    }
    
    /**
     * This method gets called by the event handler if a bot connected
     * 
     * @return void
     */
    public function onConnect()
    {
        joinChan('#tw.nl-npo');
    }

}

new NpoBot_Main();
