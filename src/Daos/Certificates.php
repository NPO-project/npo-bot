<?php
require_once 'Types/Certificate.php';

class Npobot_Daos_Certificates
{

    public function getCertificate($playerName)
    {
        $cert = new Npobot_Types_Certificate();
        $cert->setId(12);
        $cert->setPlayerId(strlen($playerName));
        return $cert;
    }

}
