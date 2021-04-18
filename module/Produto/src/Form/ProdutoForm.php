<?php
namespace Produto\Form;

use Zend\Form\Form;

class ProdutoForm extends Form
{
    public function __construct($name = null, $categorias)
    {
        parent::__construct('produto');
                    
        $this->add([
            'name' => 'id_produto',
            'type' => 'hidden',
        ]);
        
        $this->add([
            'name' => 'nome_produto',
            'type' => 'text',
            'options' => [
                'label' => 'Nome do Produto',
            ],
        ]);
        
        $this->add([
            'name' => 'id_categoria_produto',
            'type' => 'select',
            'options' => [
                'label' => 'Categoria do Produto',
                'value_options' => $categorias,
            ],
        ]);
        $this->add([
            'name' => 'valor_produto',
            'type' => 'number',
            'options' => [
                'label' => 'Valor do Produto',
            ],
            'attributes' => [
                'min' => '0',
                'step' => '0.01',
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