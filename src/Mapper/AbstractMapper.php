<?php
namespace SampleService\Mapper;

use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;

abstract class AbstractMapper
{
    /** @var TableGateway */
    protected $tableGateway;

    /** @var  @var DbSelect */
    protected $paginator;

    protected $paginateOptionKeys = array(
        'perpage',
        'page',
    );

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @param $select
     * @param  array              $options   Paginator options
     * @param  ResultSetInterface $resultSet
     * @return Paginator
     */
    public function initPaginator($select, array $options, ResultSetInterface $resultSet = null)
    {
        $paginator = new Paginator(new DbSelect($select, $this->tableGateway->getAdapter(), $resultSet));

        if (isset($options['perpage'])) {
            $paginator->setItemCountPerPage($options['perpage']);
        }
        if (isset($options['page'])) {
            $paginator->setCurrentPageNumber($options['page']);
        }

        return $paginator;
    }

    /**
     * @param  Select             $select
     * @param  array              $options   Paginator options
     * @param  ResultSetInterface $resultSet
     * @return array|Paginator
     */

    public function selectMany(Select $select, array $options = array(),  ResultSetInterface $resultSet = null)
    {
        if (!$resultSet) {
            $resultSet = $this->tableGateway->getResultSetPrototype();
        }

        if ($options) {
            return $this->initPaginator($select, $options, $resultSet);
        }

        return $this->tableGateway->selectWith($select, $resultSet);
    }

    /**
     * Paginator valid options
     * @return array
     */
    public function getValidOptionKeys()
    {
        return $this->paginateOptionKeys;
    }
}
