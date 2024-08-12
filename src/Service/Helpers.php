<?php 



namespace App\Service;

use App\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Security;

class Helpers {

    public function __construct(
        private LoggerInterface $logger,  // Assuming LoggerInterface is from PSR-3
        private Security $security
        ){
        
    }
    
    public function genererMotDePasse($longueur = 8) {
        $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $symboles = '!@#$%^&*()_+-=[]{}|;:,.<>?';
        $motDePasse = '';
        $maxIndex = strlen($caracteres) - 1;
    
        for ($i = 0; $i < $longueur; $i++) {
            $indexAleatoire = random_int(0, $maxIndex);
           if ($i == $longueur -2 )$motDePasse .= $symboles[random_int(0,(strlen($symboles)-1))];
            $motDePasse .= $caracteres[$indexAleatoire];
        }
    
        return $motDePasse;
    }

}


?>