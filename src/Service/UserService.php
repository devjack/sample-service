<?php
namespace SampleService\Service;

use SampleService\Mapper\Feature\UserMapperAwareTrait;
use Zend\Paginator\Paginator;
use Zend\Stdlib\Hydrator\ClassMethods;


class UserService {
    use UserMapperAwareTrait;

    /**
     * @param $id
     * @return User
     */
    public function get($id)
{
    $mapper = $this->getUserMapper();
    $user = $mapper->get($id);

    return $user;
}

    /**
     * @param User $user
     */
    public function update(User $user)
{
    $mapper = $this->getUserMapper();
    $mapper->update($user);

    $fresh = $mapper->get($user->getId());

    $hydrator = new ClassMethods();
    $hydrator->hydrate($hydrator->extract($fresh), $user);
}

    /**
     * TODO use object instead of array, hard to read valid options
     *
     * @param  array                     $conditions Set of field and value pairs on which to apply the filter
     * @return array                     Array of User ID's matching the relevant filter.
     * @throws \InvalidArgumentException
     */
    public function search(array $conditions)
    {
        $criteria = array();

        // Check the input filter conditions for basic validity.
        foreach ($conditions as $field=>$value) {
            if (is_null($value) || empty($value)) {
                unset($conditions[$field]);
            }
        }

        // Validate the input conditions.
        if (array_key_exists('id', $conditions)) {
            if (is_numeric($conditions['id'])) {
                $criteria['id'] = (int) $conditions['id'];
            } else {
                throw new \InvalidArgumentException("'id' field must be an integer. ".var_export($conditions['id'], true)." was supplied");
            }
        }


            // todo: More fields!

        // Conditions is valid and can be passed into the mapper to generate the results;
        $options = array();
        if (array_key_exists('options', $conditions)) {
            $options = $conditions['options'];
        }


        /** @var Paginator $paginator */
        $paginator = $this->getUserMapper()->paginateUsersByFilter($criteria, $options);

        return $paginator;
    }


}
