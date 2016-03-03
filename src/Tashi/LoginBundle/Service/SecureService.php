<?php
namespace Tashi\LoginBundle\Service;
use Symfony\Component\HttpFoundation\Session\Session;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Secure
 *
 * @author Cobigent
 */
class SecureService{
    //put your code here
        protected $lenght = 8;
	private  $intention;
        private  $session;
        private $SaltStr;
        
        public function __construct(Session $session) {
            $this->session = $session;
        }
        /*
	 *Creates random string with letters,numbers and with optional lenght and special characters. 
	 *Letters will randomly upper and lowercase
	 */
	
        private function getRandomString()
	{
                
		$abc = array();
                $randomText="";
		foreach(range('a','z') as $a)
		{//Array with all letters in it
			$abc[] = $a; 
		}
		
		foreach(range(0,9) as $a)
		{//All numbers in array too
			$abc[] = $a; 
		}
		
		for($i=0;$i<$this->lenght;$i++)
		{
			shuffle($abc);//Shuffle the array in every loop, so its more random
			$j = rand(0,count($abc)-1);//Random array element form shuffled array. Randomnesssssss ;)
			$randomText .= (rand(0,10)%2 == 0) ? strtoupper($abc[$j]) : $abc[$j]; //If its not an odd number then it will be upper case
		}
		return $randomText;
	}
       function createSalt()
       {
           $this->SaltStr = md5($this->getRandomString(20,true).$this->getRandomString(20,true));     
    	   $this->session->set('Salt', $this->SaltStr);	       
           return $this->SaltStr;
       }
        
       function getIntention()
       {
           $this->intention=($this->getRandomString(20,true).$this->getRandomString(20,true));
           $this->session->set('intention', $this->intention);
           return $this->intention;
       }
}
