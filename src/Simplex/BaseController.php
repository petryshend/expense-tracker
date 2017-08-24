<?php

namespace Simplex;

use Symfony\Component\HttpFoundation\Response;

class BaseController
{
    protected function get(string $service)
    {
        return ServiceContainerProvider::getServiceContainer()->get($service);
    }

    protected function getParameter(string $parameter)
    {
        return ServiceContainerProvider::getServiceContainer()->getParameter($parameter);
    }

    protected function render(string $template, array $arguments): Response
    {
        /** @var \Twig_Environment $twig */
        $twig = $this->get('twig');
        if (substr($template, -10) !== '.html.twig') {
            $template .= '.html.twig';
        }
        return new Response($twig->render($template, $arguments));
    }
}