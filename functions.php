<?php

require_once 'User.php';

function userAuth($userData)
{
    
    if(isset($userData))
    {
        
        $userClass=new User();
        $isActive=$userClass->checkAuth($userData);
        return $isActive;
    }else
    {
        return true;
    }
    
}

function destroySession()
{
    // Remove access token from session
unset($_SESSION['facebook_access_token']);

// Remove user data from session
unset($_SESSION['userData']);

}


?>

