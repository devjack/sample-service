<?php

namespace SampleService\Service\Feature;

use SampleService\Service\UserService;
use Zend\Stdlib\Exception\LogicException;

trait UserServiceAwareTrait {

    /**
     * @var UserService
     */
    protected $userService;

    public function setUserService($userService)
    {
        $this->userService = $userService;
    }

    public function getUserService()
    {
        if(null === $this->userService) {
            throw new LogicException("User service must be defined");
        }

        return $this->userService;
    }

} 