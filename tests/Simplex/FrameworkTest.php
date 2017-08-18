<?php

namespace Simplex;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

class FrameworkTest extends TestCase
{
    public function testNotFoundHandling()
    {
        $framework = $this->getFrameworkForException(new ResourceNotFoundException());
        $response = $framework->handle(new Request());
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testErrorHandling()
    {
        $framework = $this->getFrameworkForException(new \RuntimeException());
        $response = $framework->handle(new Request());
        $this->assertEquals(500, $response->getStatusCode());
    }

    public function testControllerResponse()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|UrlMatcher $matcher */
        $matcher = $this->createMock(UrlMatcher::class);
        $matcher
            ->expects($this->once())
            ->method('match')
            ->will($this->returnValue([
                '_route' => 'foo',
                'name' => 'Fabien',
                '_controller' => function(string $name) {
                    return new Response('Hello ' . $name);
                }
            ]));
        $matcher
            ->expects($this->once())
            ->method('getContext')
            ->will($this->returnValue($this->createMock(RequestContext::class)));

        $controllerResolver = new ControllerResolver();
        $argumentResolver = new ArgumentResolver();

        $framework = new Framework($matcher, $controllerResolver, $argumentResolver);

        $response = $framework->handle(new Request());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Hello Fabien', $response->getContent());
    }

    private function getFrameworkForException(\RuntimeException $exception)
    {
        return new Framework(
            $this->prepareMatcher($exception),
            new ControllerResolver(),
            new ArgumentResolver()
        );
    }

    /**
     * @param \RuntimeException $exception
     * @return \PHPUnit_Framework_MockObject_MockObject|UrlMatcher
     */
    private function prepareMatcher(\RuntimeException $exception)
    {
        $matcher = $this->createMock(UrlMatcher::class);
        $matcher->expects($this->once())
            ->method('match')
            ->will($this->throwException($exception));
        $matcher
            ->expects($this->once())
            ->method('getContext')
            ->will($this->returnValue($this->createMock(RequestContext::class)));
        return $matcher;
    }
}