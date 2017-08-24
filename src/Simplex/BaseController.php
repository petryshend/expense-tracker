<?php

namespace Simplex;

class BaseController
{
    protected function get(string $service)
    {
        return ServiceContainerProvider::getServiceContainer()->get($service);
    }
}