<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use PhpParser\Node\Stmt\TryCatch;
use Exception;

class Produtos extends ResourceController
{
    private $produtoModel;

    //token
    private $token = 'a1b2c3d4e5f6g7';

    public function __construct(){
        $this->produtoModel = new \App\Models\ProdutosModel();
    }

    //Validar token

    private function _validaToken(){
        return $this->request->getHeaderLine('token') == $this->token;
    }
    //serviço para retornar produtos (GET)
    public function listar(){
        $data = $this->produtoModel->findAll();

        $datafinal = [
            'cabeçalho' => [
                'status' => '200',
                'mensagem' => 'Dados retornados com sucesso'
            ],
            'retorno' => [
                $data
            ]
        ];

        return $this->response->setJSON($datafinal);
    }

    //serviço para criar produtos (POST)
    public function criar(){
        $response = [];

        $data = $this->produtoModel->findAll();

        if($this->_validaToken() == true){
            $parametrosjson = $this->request->getJSON();
            $parametros = $parametrosjson->parametros;

            foreach($parametros as $parametro){
                $newProduto['nomeproduto'] = $parametro->nomeproduto;
                $newProduto['valor'] = $parametro->valor;
                $newProduto['categoria'] = $parametro->categoria;
                $newProduto['custo'] = $parametro->custo;
            try{
                if($this->produtoModel->insert($newProduto)){
                    $response = [
                        'cabeçalho' => [
                            'status' => '200',
                            'mensagem' => 'Produto salvo com sucesso'
                        ],
                        'retorno' => [
                            $data
                        ]
                    ];
                }else{
                    $response = [
                        'cabeçalho' => [
                            'status' => '400 - Bad Request',
                            'mensagem' => 'Erro ao salvar o produto'
                        ],
                        'retorno' => [
                            'mensagem' => $this->produtoModel->errors()
                        ]
                    ];
                }
            }
            catch(Exception $e){
                $response = [
                    'cabeçalho' => [
                        'status' => '400 - Bad Request',
                        'mensagem' => 'Erro ao salvar o produto'
                    ],
                    'retorno' => [
                        'exception' => $e->getMessage()
                    ]
                ];
            }
            }
        }
        else{
            $response = [
                'cabeçalho' => [
                    'status' => '401 - Unauthorized',
                    'mensagem' => 'Token Inválido'
                ],
                'retorno' => [
                    'Error' => '401'
                ]
            ];
        }

        return $this->response->setJSON($response);
    }


    //Serviço para atualizar produtos (PUT)
    public function atualizar($id = null)
    {
		
        if($this->_validaToken() == true){
            $parametrosjson = $this->request->getJSON();
            $nomeproduto = $parametrosjson->nomeproduto;
            $valor = $parametrosjson->valor;
            $categoria = $parametrosjson->categoria;
            $custo = $parametrosjson->custo;

            $data = array(
                'id' => $id,
			    'nomeproduto' => $nomeproduto,
			    'valor' => $valor,
                'categoria' => $categoria,
			    'custo' => $custo
            );
                if($this->produtoModel->update($id, $data)) {
                    
                    $response = [
                        'cabeçalho' => [
                            'status' => '200',
                            'mensagem' => 'Produto atualizado com sucesso'
                        ],
                        'retorno' => [
                            $data
                        ]
                    ];
                } else {
                    $response = [
                        'cabeçalho' => [
                            'status' => '400 - Bad Request',
                            'mensagem' => 'Erro ao atualizar dados'
                        ],
                        'retorno' => [
                            'mensagem' => $this->produtoModel->errors()
                        ]
                    ];
                }
        }else{
            $response = [
                'cabeçalho' => [
                    'status' => '401 - Unauthorized',
                    'mensagem' => 'Token Inválido'
                ],
                'retorno' => [
                    'Error' => '401'
                ]
            ];
        }

        return $this->response->setJSON($response);
    }


    //Serviço para filtrar produtos por ID (GET)
    public function filtrar($id = null){
        $data = $this->produtoModel->where('id', $id)->first();

        if($data){
            $response = [
                'cabeçalho' => [
                    'status' => '200',
                    'mensagem' => 'Dados retornados com sucesso'
                ],
                'retorno' => [
                    $data
                ]
            ];
        }else{
            $response = [
                'cabeçalho' => [
                    'status' => '400 - Bad Request',
                    'mensagem' => 'Erro ao retornar dados'
                ],
                'retorno' => [
                    'mensagem' => $this->produtoModel->errors()
                ]
            ];
        }

        return $this->response->setJSON($response);
    }


    //Serviço para excluir produtos (DELETE)
    public function excluir($id = NULL){
        $data = $this->produtoModel->find($id);
		
        if($this->_validaToken() == true){
            if($data) {
                $this->produtoModel->delete($id);
                
                $response = [
                    'cabeçalho' => [
                        'status' => '200',
                        'mensagem' => 'Produto excluído com sucesso'
                    ],
                    'retorno' => [
                        $data
                    ]
                ];
            } else {
                $response = [
                    'cabeçalho' => [
                        'status' => '400 - Bad Request',
                        'mensagem' => 'Erro ao excluir dados'
                    ],
                    'retorno' => [
                        'mensagem' => $this->produtoModel->errors()
                    ]
                ];
            }
        }else{
            $response = [
                'cabeçalho' => [
                    'status' => '401 - Unauthorized',
                    'mensagem' => 'Token Inválido'
                ],
                'retorno' => [
                    'Error' => '401'
                ]
            ];
        }
        return $this->response->setJSON($response);
    }
}
