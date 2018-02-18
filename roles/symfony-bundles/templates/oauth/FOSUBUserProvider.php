<?php

namespace {{ namespace }}\Security\Core\User;

use Behat\Transliterator\Transliterator;
use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use {{ namespace }}\Entity\User;

/**
 * Class FOSUBUserProvider
 * @package {{ namespace }}\Security\Core\User
 */
class FOSUBUserProvider extends BaseClass
{
    private $container;

    public function __construct(UserManagerInterface $userManager, array $properties, ContainerInterface $container)
    {
        parent::__construct($userManager, $properties);
        $this->container = $container;
    }

    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);

        $username = $response->getUsername();

        // On connect, retrieve the access token and the user id
        $service = $response->getResourceOwner()->getName();

        $setter = 'set' . ucfirst($service);
        $setter_id = $setter . 'Id';
        $setter_token = $setter . 'AccessToken';

        // Disconnect previously connected users
        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
            $previousUser->$setter_id(null);
            $previousUser->$setter_token(null);
            $this->userManager->updateUser($previousUser);
        }

        // Connect using the current user
        $user->$setter_id($username);
        $user->$setter_token($response->getAccessToken());
        $this->userManager->updateUser($user);
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $email = $response->getEmail();
        /** @var User $user */
        $user = $this->userManager->findUserBy(['email' => $email]);

        // If the user is new
        if (null === $user) {
            $service = $response->getResourceOwner()->getName();
            $setter = 'set' . ucfirst($service);
            $setter_id = $setter . 'Id';
            $setter_token = $setter . 'AccessToken';
            $user = $this->userManager->createUser();
            $user->$setter_id($response->getUsername());
            $user->$setter_token($response->getAccessToken());
            $user->setUsername($this->getUserName($response->getNickname()));
            $user->setEmail($email);
            $password = self::generateHash(8);
            $user->setPlainPassword($password);
//            $this->container->get('websoft.notificator')->newLoginWithSocial($email, $password, $service);
            $user->setEnabled(true);
            $user->setFirstName($response->getFirstName());
            $user->setLastName($response->getLastName());
            $user->setAvatar($this->getAvatar($response));
            $this->userManager->updateUser($user);
            return $user;
        }

        $user = $this->userManager->findUserBy(['email' => $email]);
        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';
        $user->$setter($response->getAccessToken());

        return $user;
    }

    private function getAvatar(UserResponseInterface $response)
    {
        $service = $response->getResourceOwner()->getName();
        switch ($service) {
            case 'facebook':
                return sprintf('https://graph.facebook.com/%s/picture?type=large', $response->getUsername());
                break;
            default:
                return $response->getProfilePicture();
                break;
        }
    }

    private function getUserName($nickname)
    {
        $userName = Transliterator::transliterate($nickname, '_');
        $existentUser = $this->userManager->findUserBy(['username' => $userName]);
        if ($existentUser instanceof User) {
            $userName .= '_'.self::generateHash(4);
        }
        return $userName;
    }

    public static function generateHash($length)
    {
        $string = '1234567890abcdefghijklmopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $hash = '';
        for ($i = 0; $i < $length; $i++) {
            $p = rand(0, strlen($string)-1);
            $hash .= $string[$p];
        }
        return $hash;
    }
}
