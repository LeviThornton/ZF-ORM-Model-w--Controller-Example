<?php
/**
 * User mapper
 *   contains methods regarded to User model
 */
class Model_UserMapper extends Ze_Model
{
    private static $_instance = null;
    protected $_name = 'users';
    protected $_primary = 'id';

    /**
     * Returns an instance of Ze_Model.
     * @param null $order
     * @param null $limit
     * @return Model_UserMapper|null
     */
    public static function this($order=NULL, $limit=NULL, $pager=NULL){
        if (!self::$_instance) self::$_instance = new self();
        if ($order !== NULL) self::$_instance->_order = $order;
        if ($limit !== NULL) self::$_instance->_limit = $limit;
        if ($pager !== NULL) self::$_instance->_pager = $pager;
        return self::$_instance;
    }

    /**
     *
     * Convert a row from User table to a Model_User entity.
     * @param array $row
     * @return Model_User
     */
    public function tableRowToModel($row)
    {
        $user = new Model_User($row);
        return $user;
    }

    /**
     * insert a new row or update
     * @param $user
     * @return array|mixed|null
     */
    public function save($user)
    {
        $id = null;
        // get buzz model as array
        $userArray = $user->toArray();

        if (null != $userArray['id']) {
            // verified if the row exist
            $exist = $this->getById($userArray['id']);

            if (empty($exist)){
                $id = parent::insert($userArray);
            } else {
            	//end-stub - Add code to log last login date or something
            }
        }

        return $id;
    }

    /**
     *
     * Return the User with specified id.
     * @param $id
     * @return Model_User | null
     */
    public function getById($id)
    {
        $user = parent::fetchById($id);

        if ($user) {
            return $this->tableRowToModel($user);
        }

        return null;
    }
}