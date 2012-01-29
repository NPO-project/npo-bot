<?php

class Npobot_Types_Certificate
{

    private $_id;
    private $_playerId;
    private $_date;
    private $_endDate;
    
    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
    
    public function getId()
    {
        return $this->_id;
    }
    
    public function setPlayerId($id)
    {
        $this->_playerId = (int) $id;
        return $this;
    }
    
    public function getPlayerId()
    {
        return $this->_playerId;
    }

}
