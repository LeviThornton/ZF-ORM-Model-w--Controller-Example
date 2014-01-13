<?php
/**
 * User model
 *   describe the user entity
 */
class Model_User extends Model_BaseModel {

    /**
     * Model's data members
     */

    protected $_id;
    protected $_facebook_id;
    protected $_name;
    protected $_firstName;
    protected $_lastName;
    protected $_username;
    protected $_gender;
    protected $_email;
    protected $_timezone;
    protected $_locale;
    protected $_updatedTime;
    protected $_deleted;

    /**
     * Model's methods
     */

    public function setEmail($email)
    {
        $this->_email = $email;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function setFirstName($firstName)
    {
        $this->_firstName = $firstName;
    }

    public function getFirstName()
    {
        return $this->_firstName;
    }

    public function setGender($gender)
    {
        $this->_gender = $gender;
    }

    public function getGender()
    {
        return $this->_gender;
    }

    public function getFacebookId()
    {
    	return $this->_facebook_id;
    }
    public function setFacebookId($fbid)
    {
    	$this->_facebook_id = $fbid;
    }

    public function setId($id)
    {
    	$this->_id = $id;
    }
    public function getId()
    {
        return $this->_id;
    }

    public function setLastName($lastName)
    {
        $this->_lastName = $lastName;
    }

    public function getLastName()
    {
        return $this->_lastName;
    }

    public function setLocale($locale)
    {
        $this->_locale = $locale;
    }

    public function getLocale()
    {
        return $this->_locale;
    }

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setTimezone($timezone)
    {
        $this->_timezone = $timezone;
    }

    public function getTimezone()
    {
        return $this->_timezone;
    }

    public function setUpdatedTime($updatedTime)
    {
        $this->_updatedTime = $updatedTime;
    }

    public function getUpdatedTime()
    {
        return $this->_updatedTime;
    }

    public function setUsername($username)
    {
        $this->_username = $username;
    }

    public function getUsername()
    {
        return $this->_username;
    }

    public function setVerified($verified)
    {
        $this->_verified = $verified;
    }

    public function getVerified()
    {
        return $this->_verified;
    }

    public function setDeleted($deleted)
    {
        $this->_deleted = $deleted;
    }

    public function getDeleted()
    {
        return $this->_deleted;
    }
}