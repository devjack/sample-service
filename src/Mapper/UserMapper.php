<?php

namespace SampleService\Mapper;

use SampleService\Mapper\AbstractMapper;

use SampleService\Entity\User;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Paginator;

class UserMapper extends AbstractMapper
{

    public function __construct(TableGateway $tableGateway)
    {
        parent::__construct($tableGateway);
    }

    protected $validFilterKeys = array(
        'id',
        'name',
    );

    protected $validOptionKeys = array(
        'order',
        'direction',
    );

    public function getValidFilterFields()
    {
        return $this->validFilterKeys;
    }

    /**
     * @param $id
     * @return User
     */
    public function get($id)
    {
        $rows = $this->tableGateway->select(
            array('id' => $id)
        );
        if (count($rows) == 0) {
            return null;
        }

        return $rows->current();
    }

    /**
     * @param  User $user
     * @return int
     */
    public function insert(User $user)
    {
        $data = array(
            'id' => $user->getId(),
            //todo: Complete mapping
        );
        $this->tableGateway->insert($data);

        return $this->tableGateway->getLastInsertValue();
    }

    /**
     * @param User $user
     */
    public function update(User $job)
    {
        $data = array(
            'id' => $user->getId(),
            // todo:  Complete more mappings
        );
        $this->tableGateway->update($data, array('id' => $user->getId()));
    }

    /**
     * @param  array     $conditions
     * @param  array     $options
     * @return Paginator
     */
    public function paginateUsersByFilter(array $conditions, array $options = array())
    {
        /*
         * Create a SELECT query with the relevant joins.
         * Note the columns returned is an array of '*' or field names.
         */
        $select = $this->tableGateway->getSql()->select()->columns(array(
            "id",
            "firstname" => "firstname",
            "lastname" => "lastname",
            "email",
            "registered",
            "active"
        ));
        // DO MORE COMPLEX JOINS HERE!

        /*
         * Loop through the conditions supplied (assumes valid conditions)
         * For each condition, generate a WHERE clause and add it to the select. This is done through a closure.
         */
        foreach ($conditions as $field => $value) {
            switch ($field) {
                case 'id':
                    // Simple ID match
                    $select->where(function (Where $where) use ($value) {
                        $where->equalTo('User.id', $value);
                    });
                    break;
            }
        }

        if (array_key_exists('order', $options)) {
            // Set default direction and validate the requested direction. Default (and if invalid) to 'ASC'.
            if(!array_key_exists('direction', $options)
                || ! in_array($options['direction'], array('ASC', 'DESC')) ) {
                $direction = 'DESC';
            } else {
                $direction = $options['direction'];
            }
            $select = $this->orderSqlbyOptions($select, $options['order'], $direction);
        }

        $select->group('User.id');

        /** @var Paginator $paginator */
        $paginator = $this->selectMany($select, $options);

        return $paginator;
    }

    /**
     * @return array
     */
    public function getValidOptionKeys()
    {
        return array_merge(
            $this->validOptionKeys,
            parent::getValidOptionKeys()
        );
    }

    protected function orderSqlbyOptions(Select $select, $field, $direction)
    {
        switch ($field) {
            case 'id':
                $select->order('id '.$direction);
                break;
            case 'name':
                $alias = new Expression("CONCAT(User.FirstName, ' ', User.LastName) ".$direction);
                $select->order($alias);
                break;
        }

        return $select;
    }
}
