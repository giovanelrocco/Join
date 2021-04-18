<?php
namespace Produto\Controller;

use Produto\Model\ProdutoTable;
use Produto\Model\CategoriaTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Produto\Form\ProdutoForm;
use Produto\Model\Produto;


class ProdutoController extends AbstractActionController
{
 
    private $table;
    private $catTable; 

    public function __construct(ProdutoTable $table, CategoriaTable $catTable)
    {
        $this->table = $table;
        $this->catTable = $catTable;
    }

    public function indexAction()
    {
        $categoriasDb = $this->catTable->fetchAll();
        $categoriasForm = array("" => "Selecione a Categoria");
        foreach($categoriasDb as $itemCategoria){
            $categoriasForm[$itemCategoria->id_categoria_planejamento] = $itemCategoria->nome_categoria;
        }

        return new ViewModel([
            'produtos' => $this->table->fetchAll(),
            'categorias' => $categoriasForm
        ]);
    }

    public function cadastrarAction()
    {
        $categoriasDb = $this->catTable->fetchAll();
        $categoriasForm = array("" => "Selecione a Categoria");
        foreach($categoriasDb as $itemCategoria){
            $categoriasForm[$itemCategoria->id_categoria_planejamento] = $itemCategoria->nome_categoria;
        }
        
        $form = new ProdutoForm('', $categoriasForm);
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $produto = new Produto();
        $form->setInputFilter($produto->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $produto->exchangeArray($form->getData());
        $this->table->saveProduto($produto);
        return $this->redirect()->toRoute('produto');
    }

    public function editarAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('produto', ['action' => 'cadastrar']);
        }

        try {
            $produto = $this->table->getProduto($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('produto', ['action' => 'index']);
        }

        $categoriasDb = $this->catTable->fetchAll();
        $categoriasForm = array("" => "Selecione a Categoria");
        foreach($categoriasDb as $itemCategoria){
            $categoriasForm[$itemCategoria->id_categoria_planejamento] = $itemCategoria->nome_categoria;
        }

        $form = new ProdutoForm('', $categoriasForm);
        $form->bind($produto);
        $form->get('submit')->setAttribute('value', 'Editar');

        $request = $this->getRequest();
        $viewData = ['id_produto' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($produto->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveProduto($produto);

        return $this->redirect()->toRoute('produto', ['action' => 'index']);
    }

    public function deletarAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('produto');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteProduto($id);
            }

            return $this->redirect()->toRoute('produto');
        }

        return [
            'id' => $id,
            'produto' => $this->table->getProduto($id),
        ];
    }

}