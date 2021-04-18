<?php 
namespace Produto\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class ProdutoTable
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

    public function getProduto($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id_produto' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveProduto(Produto $produto)
    {
        $data = [
            'id_categoria_produto' => $produto->id_categoria_produto,
            'nome_produto' => $produto->nome_produto,
            'valor_produto' => $produto->valor_produto,
        ];

        $id = (int) $produto->id_produto;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getProduto($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update produto with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id_produto' => $id]);
    }

    public function deleteProduto($id)
    {
        $this->tableGateway->delete(['id_produto' => (int) $id]);
    }
}