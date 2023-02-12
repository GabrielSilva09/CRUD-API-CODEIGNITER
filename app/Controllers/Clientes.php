<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use PhpParser\Node\Stmt\TryCatch;
use Exception;

class Clientes extends ResourceController
{
    private $clienteModel;

    //token
    private $token = 'a1b2c3d4e5f6g7';

    public function __construct(){
        $this->clienteModel = new \App\Models\ClientesModel();
    }

    //Validar token

    private function _validaToken(){
        return $this->request->getHeaderLine('token') == $this->token;
    }
    //serviço para retornar clientes (GET)
    public function listar(){
        $data = $this->clienteModel->findAll();

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

    //serviço para criar clientes (POST)
    public function criar(){
        $response = [];

        $data = $this->clienteModel->findAll();

        if($this->_validaToken() == true){
            $parametrosjson = $this->request->getJSON();
            $parametros = $parametrosjson->parametros;

            foreach($parametros as $parametro){
                $newCliente['nome_razaosocial'] = $parametro->nome_razaosocial;
                $newCliente['cpf_cnpj'] = $parametro->cpf_cnpj;
            try{
                if($this->clienteModel->insert($newCliente)){
                    $response = [
                        'cabeçalho' => [
                            'status' => '200',
                            'mensagem' => 'Cliente salvo com sucesso'
                        ],
                        'retorno' => [
                            $data
                        ]
                    ];
                }else{
                    $response = [
                        'cabeçalho' => [
                            'status' => '400 - Bad Request',
                            'mensagem' => 'Erro ao salvar o cliente'
                        ],
                        'retorno' => [
                            'mensagem' => $this->clienteModel->errors()
                        ]
                    ];
                }
            }
            catch(Exception $e){
                $response = [
                    'cabeçalho' => [
                        'status' => '400 - Bad Request',
                        'mensagem' => 'Erro ao salvar o cliente'
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

    //serviço para atualizar clientes (PUT)
    public function atualizar($id = null)
    {
		
        if($this->_validaToken() == true){
            $parametrosjson = $this->request->getJSON();
            $nome = $parametrosjson->nome_razaosocial;
            $cpf = $parametrosjson->cpf_cnpj;

            $data = array(
                'id' => $id,
			    'nome_razaosocial' => $nome,
			    'cpf_cnpj' => $cpf
            );
                if($this->clienteModel->update($id, $data)) {
                    
                    $response = [
                        'cabeçalho' => [
                            'status' => '200',
                            'mensagem' => 'Cliente atualizado com sucesso'
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
                            'mensagem' => $this->clienteModel->errors()
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

    //Serviço para filtragem de clientes usando ID (GET)
    public function filtrar($id = null){
        $data = $this->clienteModel->where('id', $id)->first();

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
                    'mensagem' => $this->clienteModel->errors()
                ]
            ];
        }

        return $this->response->setJSON($response);
    }

    //Serviço para excluir clientes (DELETE)
    public function excluir($id = NULL){
        $data = $this->clienteModel->find($id);
		
        if($this->_validaToken() == true){

            if($data) {
                $this->clienteModel->delete($id);
                
                $response = [
                    'cabeçalho' => [
                        'status' => '200',
                        'mensagem' => 'Cliente excluído com sucesso'
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
                        'mensagem' => $this->clienteModel->errors()
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