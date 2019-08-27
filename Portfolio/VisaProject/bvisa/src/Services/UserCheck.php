<?php

namespace Drupal\bvisa\Services;
use Drupal\user\Entity\User;

/**
 * Class UserCheck
 */
class UserCheck {

    /**
    * Constructs a new UserCheck object.
    */
    public function __construct() {

    }

    public function getUserCheck() {

        $userCurrent = \Drupal::currentUser();
        $user = User::load($userCurrent->id());

        $roles = $user->getRoles();

        if (in_array("bvisa_subscriber", $roles))
        {
            $user_check = TRUE;
        }
        elseif(in_array("staff_only", $roles))
        {
            $user_check = TRUE;
        }
        elseif (in_array("administrator", $roles))
        {
            $user_check = TRUE;
        }
        else
        {
            $user_check = FALSE;
        }


        return $user_check;


    }



}
