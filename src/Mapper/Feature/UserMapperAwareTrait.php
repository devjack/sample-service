<?php
namespace SampleService\Mapper\Feature;

use SampleService\Mapper\UserMapper;

use Zend\Stdlib\Exception\LogicException;

trait UserMapperAwareTrait
{
    /**
     * @var UserMapper
     */
    protected $userMapper;

    /**
     * @return UserMapper
     * @throws \Zend\Stdlib\Exception\LogicException
     */
    public function getUserMapper()
    {
        if (null === $this->jobMapper) {
            throw new LogicException('User mapper must be defined');
        }

        return $this->jobMapper;
    }

    /**
     * @param UserMapper $userMapper
     */
    public function setUserMapper(UserMapper $userMapper)
    {
        $this->jobMapper = $userMapper;
    }
}
