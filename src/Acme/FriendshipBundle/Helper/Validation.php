<?php

namespace Acme\FriendshipBundle\Helper;

/** Validate class
 *
 */
class Validation
{

    public static function validateInteger($integer)
    {
        return filter_var($integer, FILTER_VALIDATE_INT) !== false;
    }
}
