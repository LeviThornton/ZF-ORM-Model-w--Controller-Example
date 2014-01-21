<?php

class UserController extends Zend_Controller_Action
{
    protected $user;

    public function init()
    {
        /* Initialize action controller here */

    	/**
    	 * Check that user is logged using fb api
    	 */
        $facebookApi = new Application_Model_FacebookApi();
        $this->user = $facebookApi->userStatus();
        $action = $this->getRequest()->getActionName();

        // action name not login
        $actionName = array('profile');
        // verified if is a ajax
        $ajax = $this->getParam('ajax');

        if(!$this->user && !in_array($action, $actionName)) {
            if (empty($ajax)){
                $this->forward('noaccess', 'user');
            } else {
                // get the user profile url
                $userId = $this->getParam('userId');

                // create the url to redirect
                $redirectUri = $this->view->serverUrl() . $this->view->baseUrl() . '/profile/' . $userId;

                // get the facebook url
                $facebook = new Application_Model_FacebookApi();
                $url = $facebook->getLoginUrl($redirectUri);

                // set response to ajax
                echo Zend_Json::encode(array('success'=> false, 'noaccess' => true, 'url' => $url));
                exit;
            }
    	}

    }

    public function indexAction()
    {
    	// Nothing here yet
    }

    public function registerAction() {
	$request = $this->getRequest();
	$form    = new Application_Form_Login();
	
	if ($this->getRequest()->isPost()) {
		if ($form->isValid($request->getPost())) {
			/* add code to register user, output some details,
			* email them a confirmation, or redirect */
			return  $this->_helper->redirector('welcome');
		}
	}
	
	$this->view->form = $form;
     }
	
    public function confirmAction() {
	// Nothing here yet
	// One would add code to confirm email and display a welcome message
    }

    public function profileAction(){

        $userLogged = $this->user;
        $userId = $this->getParam('id');

        $user = Model_UserMapper::this()->getById($userId);
        // verified if the user exist
        if (empty($user)){
            $this->forward('error', 'error');
            return;
        }

        // get all items for user
        $userItems = Model_ItemsMapper::this("post_date DESC",10,0)->getItemsById($userId);

        foreach($userItems as $items){
        	$eids[] = $items['id'];
        }

        $rsvps = $likes = $comments = array();

        if ($eids){
        	// get all likes
        	$likes = Model_ItemLikesMapper::this()->getAllLikesByIds($eids);
        	// get the comments
        	$comments = Model_CommentMapper::this()->getAllCommentsByCommentsIds($eids);
        }

        // verified if the user logged follow the user profile
        $followExist = Model_FollowerMapper::this()->getByFollowingIdAndUserId($userId, $userLogged);

        $this->view->user = $user;
        $this->view->userLogged = $userLogged;
        $this->view->userItems = $userItems;
        $this->view->comments = $comments;
        $this->view->likes = $likes;
    }

    // added a new like
    public function ajaxAddLikeAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $itemId = $this->getParam('itemId');
        $userLogged = $this->getParam('userLogged');
        $status = $this->getParam('status');
        $response = array('success'=> false);

        if (!empty($itemId) && !empty($userLogged) && is_numeric($userLogged)){

            // verified if the the like exist
            $like = Model_UserLikeMapper::this()->fetchByUserItemIdAndUserId($itemId, $userLogged);
            if (!$like){
                // created the new row
                $like = array(
                    'useritems_id' => $itemId,
                    'user_id' => $userLogged,
                    'date' => date("Y-m-d H:i:s"),
                );
            } else {
                if ($status == 'true'){
                    $like['deleted'] = 0;
                } else {
                    $like['deleted'] = 1;
                }
            }
            Model_UserLikeMapper::this()->save($like);

            $response['success'] = true;
        }

        echo Zend_Json::encode($response);
    }

    public function ajaxAddCommentAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $comment = $this->getParam('comment');
        $userLogged = $this->getParam('userLogged');
        $itemId = $this->getParam('itemId');

        $response = array('success'=> false);

        if (!empty($comment) && !empty($itemId) && !empty($userLogged) && is_numeric($userLogged)){
            $record = array(
                'useritems_id' => $itemId,
                'user_id' => $userLogged,
                'comment' => $comment,
                'date' => date("Y-m-d H:i:s"),
            );
            // save
            Model_UserCommentMapper::this()->save($record);
            // get the user
            $user = Model_UserMapper::this()->getById($userLogged);
            $response['record'] = array(
                'user' => $userLogged,
                'userName' => $user->getName(),
                'comment' => $comment,
            );
            $response['success'] = true;
        }

        echo Zend_Json::encode($response);

    }
}
?>
