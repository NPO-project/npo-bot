<?php
/**
 * The run file
 * 
 * PHP version 5
 * 
 * @category NPO-project
 * @package  NPO-bot
 * @author   Marlin Cremers <marlinc@mms-projects.net>
 * @license  http://creativecommons.org/licenses/by-nc/3.0/ Creative Commons Attribution-NonCommercial 3.0 Unported License
 * @link     https://github.com/NPO-project/NPO-bot
 */

require_once 'IRCBot/src/Application.php';
require_once 'IRCBot/src/shortFunctions.php';

\Ircbot\Application::getInstance();

require_once 'Spamfilter.php';
require_once 'Admin.php';
require_once 'Commands/Cert.php';

/**
 * The main bot module that loads all of the other modules
 * 
 * @category NPO-project
 * @package  NPO-bot
 * @author   Marlin Cremers <marlinc@mms-projects.net>
 * @license  http://creativecommons.org/licenses/by-nc/3.0/ Creative Commons Attribution-NonCommercial 3.0 Unported License
 * @link     https://github.com/NPO-project/NPO-bot
 */
class NpoBot_Main extends \Ircbot\Module\AModule
{

    private $_spamfilter;
    public $events = array(
        'onConnect',
    );

    /**
     * The main constructer that starts everything
     * 
     * @param array $config The configuration data
     */
    public function  __construct($config)
    {
        //Connect the bot to the server and registrer it in the framework
        $bot = new \Ircbot\Type\Bot();
        $bot->nickname = $config['bot']['nick'];
        $bot->connect($config['server']['host'], $config['server']['port']); 
        \Ircbot\Application::getInstance()->getBotHandler()->addBot($bot);
        
        //Add this module to the framework
        $ircBot = \Ircbot\Application::getInstance();
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
        new NpoBot_Commands_Cert($this->_spamfilter);
    }
    
    /**
     * This method gets called by the event handler if a bot connected
     * 
     * @return void
     */
    public function onConnect()
    {
        \Ircbot\joinChan('#tw.nl-npo');
    }

}
