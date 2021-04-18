<?php
namespace Categoria\Controller;

use Categoria\Model\CategoriaTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Categoria\Form\CategoriaForm;
use Categoria\Model\Categoria;


class CategoriaController extends AbstractActionController
{
 
    private $table;

    public function __construct(CategoriaTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'categorias' => $this->table->fetchAll(),
        ]);
    }

    public function cadastrarAction()
    {
        $form = new CategoriaForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $categoria = new Categoria();
        $form->setInputFilter($categoria->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $categoria->exchangeArray($form->getData());
        $this->table->saveCategoria($categoria);
        return $this->redirect()->toRoute('categoria');
    }

    public function editarAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('categoria', ['action' => 'cadastrar']);
        }

        try {
            $categoria = $this->table->getCategoria($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('categoria', ['action' => 'index']);
        }

        $form = new CategoriaForm();
        $form->bind($categoria);
        $form->get('submit')->setAttribute('value', 'Editar');

        $request = $this->getRequest();
        $viewData = ['id_categoria_planejamento' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($categoria->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveCategoria($categoria);

        return $this->redirect()->toRoute('categoria', ['action' => 'index']);
    }

    public function deletarAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('categoria');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteCategoria($id);
            }

            return $this->redirect()->toRoute('categoria');
        }

        return [
            'id' => $id,
            'categoria' => $this->table->getCategoria($id),
        ];
    }

}