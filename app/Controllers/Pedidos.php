<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use PhpParser\Node\Stmt\TryCatch;
use Exception;

class Pedidos extends ResourceController
{
    private $pedidoModel;

    //token
    private $token = 'a1b2c3d4e5f6g7';

    public function __construct(){
        $this->pedidoModel = new \App\Models\PedidosModel();
    }

    //Validar token

    private function _validaToken(){
        return $this->request->getHeaderLine('token') == $this->token;
    }
    //serviço para retornar Pedidos (GET)
    public function listar(){
        $data = $this->pedidoModel->findAll();

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

    //serviço para criar Pedidos (POST)
    public function criar(){
        $response = [];

        $data = $this->pedidoModel->findAll();

        if($this->_validaToken() == true){
            $parametrosjson = $this->request->getJSON();
            $parametros = $parametrosjson->parametros;

            foreach($parametros as $parametro){
                $newPedido['cliente_id'] = $parametro->cliente_id;
                $newPedido['produto_id'] = $parametro->produto_id;
                $newPedido['valorpedido'] = $parametro->valorpedido;
                $newPedido['formapagamento'] = $parametro->formapagamento;
                $newPedido['status'] = $parametro->status;
            try{
                if($this->pedidoModel->insert($newPedido)){
                    $response = [
                        'cabeçalho' => [
                            'status' => '200',
                            'mensagem' => 'Pedido salvo com sucesso'
                        ],
                        'retorno' => [
                            $data
                        ]
                    ];
                }else{
                    $response = [
                        'cabeçalho' => [
                            'status' => '400 - Bad Request',
                            'mensagem' => 'Erro ao salvar o pedido'
                        ],
                        'retorno' => [
                            'mensagem' => $this->pedidoModel->errors()
                        ]
                    ];
                }
            }
            catch(Exception $e){
                $response = [
                    'cabeçalho' => [
                        'status' => '400 - Bad Request',
                        'mensagem' => 'Erro ao salvar o pedido'
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


    //Serviço para atualizar pedidos (PUT)
    public function atualizar($id = null)
    {
		
        if($this->_validaToken() == true){
            $parametrosjson = $this->request->getJSON();
            $clienteid = $parametrosjson->cliente_id;
            $produtoid = $parametrosjson->produto_id;
            $valorpedido = $parametrosjson->valorpedido;
            $pagamento = $parametrosjson->formapagamento;
            $status = $parametrosjson->status;

            $data = array(
                'id' => $id,
			    'cliente_id' => $clienteid,
			    'produto_id' => $produtoid,
			    'valorpedido' => $valorpedido,
			    'formapagamento' => $pagamento,
			    'status' => $status
            );
                if($this->pedidoModel->update($id, $data)) {
                    
                    $response = [
                        'cabeçalho' => [
                            'status' => '200',
                            'mensagem' => 'Pedido atualizado com sucesso'
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
                            'mensagem' => $this->pedidoModel->errors()
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

    //Serviço para filtar pedidos por ID (GET)

    public function filtrar($id = null){
        $data = $this->pedidoModel->where('id', $id)->first();

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
                    'mensagem' => $this->pedidoModel->errors()
                ]
            ];
        }

        return $this->response->setJSON($response);
    }


    //Serviço para excluir pedidos (DELETE)
    public function excluir($id = NULL){
        $data = $this->pedidoModel->find($id);
		
        if($this->_validaToken() == true){
            if($data) {
                $this->pedidoModel->delete($id);
                
                $response = [
                    'cabeçalho' => [
                        'status' => '200',
                        'mensagem' => 'Pedido excluído com sucesso'
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
                        'mensagem' => $this->pedidoModel->errors()
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
