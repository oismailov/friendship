<?php

namespace Acme\FriendshipBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ExceptionController
{
    public function showExceptionAction(Request $request)
    {
        return new JsonResponse(
            array(
                'error' => array(
                    'message' => 'route not foud: ' . $request->getPathInfo()
                )
            )
        );
    }
}
