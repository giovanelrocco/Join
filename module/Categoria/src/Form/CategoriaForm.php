<?php
namespace Categoria\Form;

use Zend\Form\Form;

class CategoriaForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('categoria');

        $this->add([
            'name' => 'id_categoria_planejamento',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'nome_categoria',
            'type' => 'text',
            'options' => [
                'label' => 'Nome da Categoria',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Salvar',
                'id'    => 'submitbutton',
            ],
        ]);
        $this->setAttribute('method', 'POST');
    }
}