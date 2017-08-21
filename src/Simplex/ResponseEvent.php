<?php

namespace Simplex;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ResponseEvent extends Event
{
    /** @var Response */
    private $response;
    /** @var Request */
    private $request;

    function __construct(Response $response, Request $request)
    {
        $this->response = $response;
        $this->request = $request;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

}