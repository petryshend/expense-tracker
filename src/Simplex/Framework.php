<?php

namespace Simplex;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;

class Framework
{
    /** @var EventDispatcher */
    private $eventDispatcher;
    /** @var UrlMatcher */
    private $matcher;
    /** @var ControllerResolver */
    private $controllerResolver;
    /** @var ArgumentResolver */
    private $argumentResolver;

    public function __construct(
        EventDispatcher $eventDispatcher,
        UrlMatcher $matcher,
        ControllerResolver $controllerResolver,
        ArgumentResolver $argumentResolver
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->matcher = $matcher;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
    }

    public function handle(Request $request): Response
    {
        $this->matcher->getContext()->fromRequest($request);

        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));

            $controller = $this->controllerResolver->getController($request);
            $arguments = $this->argumentResolver->getArguments($request, $controller);

            $response =  call_user_func_array($controller, $arguments);
        } catch (ResourceNotFoundException $exception) {
            return new Response('Not found', Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            return new Response('An error occurred', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $this->eventDispatcher->dispatch('response', new ResponseEvent($response, $request));

        return $response;
    }
}