<?php
define('CONFIG_FILE', '../build/config.php');

require_once '../IRCBot/src/Application.php';

require_once 'Spamfilter.php';
require_once 'Admin.php';

class NpoBot_Main
{

    private $_spamfilter;

    public function  __construct($config)
    {
        //Registers events callbacks
        addEventCallback('onConnect', array($this, 'onConnect'));
        
        //Connect the bot to the server and registrer it in the framework
        $bot = new IRCBot_Types_Bot();
        $bot->nickname = $config['bot']['nick'];
        $bot->connect($config['server']['host'], $config['server']['port']); 
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
     * @return void
     */
    public function initializeModules()
    {
        $this->_spamfilter = new NpoBot_Spamfilter();
        new NpoBot_Admin();
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
if (!file_exists(CONFIG_FILE)) {
    throw new Exception('No config file present! Run make');
} else {
    include CONFIG_FILE;
    new NpoBot_Main($config);
}
