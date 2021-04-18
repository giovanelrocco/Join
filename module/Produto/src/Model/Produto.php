<?php

namespace Produto\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\Filter\ToFloat;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class Produto
{
    public $id_produto;
    public $id_categoria_produto;
    public $nome_produto;
    public $valor_produto;

    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id_produto = !empty($data['id_produto']) ? $data['id_produto'] : null;
        $this->id_categoria_produto = !empty($data['id_categoria_produto']) ? $data['id_categoria_produto'] : null;
        $this->nome_produto = !empty($data['nome_produto']) ? $data['nome_produto'] : null;
        $this->valor_produto = !empty($data['valor_produto']) ? $data['valor_produto'] : null;
        $this->data_cadastro = !empty($data['data_cadastro']) ? $data['data_cadastro'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'id_produto' => $this->id_produto,
            'id_categoria_produto' => $this->id_categoria_produto,
            'nome_produto' => $this->nome_produto,
            'valor_produto' => $this->valor_produto,
            'data_cadastro' => $this->data_cadastro,
        ];
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id_produto',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'id_categoria_produto',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'nome_produto',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'valor_produto',
            'required' => true,
            'filters' => [
                ['name' => ToFloat::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'data_cadastro',
            'required' => false,
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}