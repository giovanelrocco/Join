<?php
namespace Produto\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class CategoriaTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

}