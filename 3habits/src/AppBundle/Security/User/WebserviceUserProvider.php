<?php
// src/AppBundle/Security/User/WebserviceUserProvider.php
namespace AppBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use AppBundle\Utils\RestClient;

class WebserviceUserProvider implements UserProviderInterface
{
    public function loadUserByUsername($username)
    {		
		//$myfile = fopen("log.txt", "w") or die("Unable to open file!");
		//fwrite($myfile, "username = ".$username."\r\n");
		
		$client = new RestClient();
		
		//fwrite($myfile, "client created\r\n");
		
        // make a call to your webservice here
        $userData = json_decode($client->get('/users/'.$username));
        // pretend it returns an array on success, false if there is no user

		//fwrite($myfile, "users queried\r\n");
		
        if ($userData) {
            $password = '';
			$salt = '';
			$roles = explode(';', $userData['roles']);
			
            return new WebserviceUser($username, $password, $salt, $roles);
        }

        throw new UsernameNotFoundException(
            sprintf('Username "%s" does not exist.', $username)
        );
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof WebserviceUser) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'AppBundle\Security\User\WebserviceUser';
    }
}

?>