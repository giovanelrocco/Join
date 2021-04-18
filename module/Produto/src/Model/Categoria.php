<?php

namespace Produto\Model;

class Categoria
{
    public $id_categoria;
    public $nome_categoria;


    public function exchangeArray(array $data)
    {
        $this->id_categoria_planejamento = !empty($data['id_categoria_planejamento']) ? $data['id_categoria_planejamento'] : null;
        $this->nome_categoria = !empty($data['nome_categoria']) ? $data['nome_categoria'] : null;
    }

}