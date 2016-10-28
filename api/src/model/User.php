<?php

/**
 * Created by PhpStorm.
 * User: timothy
 * Date: 11/10/16
 * Time: 21:45
 */
 
namespace model;

class User
{
    private $id;
    private $name;
    private $surname;
    private $username;
    private $username_canonical;
    private $email;
    private $email_canonical;
    private $enabled;
    private $salt;
    private $password;
    private $last_login;
    private $locked;
    private $expired;
    private $expires_at;
    private $confirmation_token;
    private $password_requested_at;
	private $roles;
    private $credentials_expired;
    private $credentials_expire_at;

    /**
     * User constructor.
     * @param $id
     * @param $name
     */
    public function __construct()
    {
        $this->enabled = false;
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $this->locked = false;
        $this->expired = false;
		$this->roles = array();
        $this->credentials_expired = false;
    }

    /**
     * @return mixed
     * @description access for JSON
     */
    public function expose() {
        return get_object_vars($this);
    }

    /**
    * @return json_data
    */
    public function json() {
        return json_encode($this);
    }

    /**
    * @param json data
    */
    public function unserializeJson($json_data) {
        if ($json_data->id) {
            $this->setId($json_data->id);
        }

        if ($json_data->name) {
            $this->setName($json_data->name);
        }

        if ($json_data->surname) {
            $this->setSurname($json_data->surname);
        }

        if ($json_data->username) {
            $this->setUsername($json_data->username);
        }

        if ($json_data->username_canonical) {
            $this->setUsernameCanonical($json_data->username_canonical);
        }

        if ($json_data->email) {
            $this->setEmail($json_data->email);
        }

        if ($json_data->email_canonical) {
            $this->setEmailCanonical($json_data->email_canonical);
        }

        if ($json_data->enabled) {
            $this->setEnabled($json_data->enabled);
        }

        if ($json_data->salt) {
            $this->setSalt($json_data->salt);
        }

        if ($json_data->password) {
            $this->setPassword($json_data->password);
        }

        if ($json_data->last_login) {
            $this->setLastLogin($json_data->last_login);
        }

        if ($json_data->locked) {
            $this->setLocked($json_data->locked);
        }

        if ($json_data->expired) {
            $this->setExpired($json_data->expired);
        }

        if ($json_data->expires_at) {
            $this->setExpiresAt($json_data->expires_at);
        }

        if ($json_data->confirmation_token) {
            $this->setConfirmationToken($json_data->confirmation_token);
        }

        if ($json_data->password_requested_at) {
            $this->setPasswordRequestedAt($json_data->password_requested_at);
        }

        if ($json_data->roles) {
            $this->setRoles($json_data->roles);
        }

        if ($json_data->credentials_expired) {
            $this->setCredentialsExpired($json_data->credentials_expired);
        }

        if ($json_data->credentials_expire_at) {
            $this->setCredentialsExpireAt($json_data->credentials_expire_at);
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }


    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsernameCanonical()
    {
        return $this->usernameCanonical;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmailCanonical()
    {
        return $this->emailCanonical;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Gets the last login time.
     *
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * {@inheritdoc}
     */
    public function getExpireDate()
    {
        return $this->expires_at;
    }

    /**
     * {@inheritdoc}
     */
    public function getPasswordRequestDate()
    {
        return $this->password_requested_at;
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentialsExpireDate()
    {
        return $this->credentials_expire_at;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        if (is_string($roles)) {
            print_r($roles."\r\n");
            $newRoles = array();
            $newRoles[] = "ROLE_USER";

            $matches = array();
            preg_match('/i:[0-9]+;s:[0-9]+:"[A-Z_]+"/', $roles, $matches);

            var_dump($matches);

            foreach ($matches as $match) {
                print_r("\t".$match."\r\n");
                $role = array();
                preg_match('/"[A-Z_]+"/', $match, $role);
                $role = substr($role[0], 1, strlen($role[0]) - 2);
                $newRoles[] = $role;
            }

            $this->roles = $newRoles;
        }
        else {
            $this->roles = $roles;
        }
    }

    /**
     * @param mixed $role
     */
    public function addRole($role)
    {
        $role = strtoupper($role);
        if ($role === static::ROLE_DEFAULT) {
            return $this;
        }

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonExpired()
    {
        if (true === $this->expired) {
            return false;
        }

        if (null !== $this->expiresAt && $this->expiresAt->getTimestamp() < time()) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonLocked()
    {
        return !$this->locked;
    }

    /**
     * {@inheritdoc}
     */
    public function isCredentialsNonExpired()
    {
        if (true === $this->credentialsExpired) {
            return false;
        }

        if (null !== $this->credentialsExpireAt && $this->credentialsExpireAt->getTimestamp() < time()) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isCredentialsExpired()
    {
        return !$this->isCredentialsNonExpired();
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return bool
     */
    public function isExpired()
    {
        return !$this->isAccountNonExpired();
    }

    /**
     * @return bool
     */
    public function isLocked()
    {
        return !$this->isAccountNonLocked();
    }

    /**
     * {@inheritdoc}
     */
    public function removeRole($role)
    {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }

        return $this;
    }



    /**
     * {@inheritdoc}
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setUsernameCanonical($usernameCanonical)
    {
        $this->usernameCanonical = $usernameCanonical;

        return $this;
    }

    /**
     * @param \DateTime $date
     *
     * @return User
     */
    public function setCredentialsExpireAt(\DateTime $date = null)
    {
        $this->credentialsExpireAt = $date;

        return $this;
    }

    /**
     * @param bool $boolean
     *
     * @return User
     */
    public function setCredentialsExpired($boolean)
    {
        $this->credentialsExpired = $boolean;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmailCanonical($emailCanonical)
    {
        $this->emailCanonical = $emailCanonical;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setEnabled($boolean)
    {
        $this->enabled = (bool) $boolean;

        return $this;
    }

    /**
     * Sets this user to expired.
     *
     * @param bool $boolean
     *
     * @return User
     */
    public function setExpired($boolean)
    {
        $this->expired = (bool) $boolean;

        return $this;
    }

    /**
     * @param \DateTime $date
     *
     * @return User
     */
    public function setExpiresAt(\DateTime $date = null)
    {
        $this->expiresAt = $date;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastLogin(\DateTime $time = null)
    {
        $this->lastLogin = $time;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setLocked($boolean)
    {
        $this->locked = $boolean;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPasswordRequestedAt(\DateTime $date = null)
    {
        $this->passwordRequestedAt = $date;

        return $this;
    }

    /**
     * Gets the timestamp that the user requested a password reset.
     *
     * @return null|\DateTime
     */
    public function getPasswordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function isPasswordRequestNonExpired($ttl)
    {
        return $this->getPasswordRequestedAt() instanceof \DateTime &&
               $this->getPasswordRequestedAt()->getTimestamp() + $ttl > time();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getUsername();
    }
}