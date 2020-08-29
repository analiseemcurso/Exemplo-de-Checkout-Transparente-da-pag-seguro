<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once "HttpConnection.class.php";
require_once "XmlParser.class.php";
require_once "PagSeguroData.class.php";

class Checkout {

	private $pagSeguroData;


	public function __construct($sandbox = true) {
		$this->pagSeguroData = new PagSeguroData($sandbox);
	}

	public function showTemplate() {
		$isSandbox = $this->pagSeguroData->isSandbox();
		require 'templates/checkout.php';
		exit();
	}


	public function printSessionId() {

			// Criando uma conexão HTTP (abstração CURL) Criando uma conexão HTTP (abstração CURL)
		$httpConnection = new HttpConnection();

			//Pedido para PagSeguro Session API usando Credenciais
		$httpConnection->post($this->pagSeguroData->getSessionURL(), $this->pagSeguroData->getCredentials());

			// Solicitar OK obtendo o resultado
		if ($httpConnection->getStatus() === 200) {

			$data = $httpConnection->getResponse();

			$sessionId = $this->parseSessionIdFromXml($data);

			echo $sessionId;

		} else {

			throw new Exception("API Request Error: ".$httpConnection->getStatus());

		}

	}

	public function getSessionId() {

			// Criando uma conexão http (abstração CURL)
		$httpConnection = new HttpConnection();

			//Pedido para PagSeguro Session API usando Credenciais
		$httpConnection->post($this->pagSeguroData->getSessionURL(), $this->pagSeguroData->getCredentials());

			// Solicitar OK obtendo o resultado
		if ($httpConnection->getStatus() === 200) {

			$data = $httpConnection->getResponse();

			$sessionId = $this->parseSessionIdFromXml($data);

			return $sessionId;

		} else {

			throw new Exception("API Request Error: ".$httpConnection->getStatus());

		}

	}		

	public function doPayment($params) {

			// Adicionando parâmetros

			$params += $this->pagSeguroData->getCredentials(); // adicionar credenciais
			$params['paymentMode'] = 'default'; // paymentMode
			$params['currency'] = 'BRL'; // Moeda (apenas BRL)
			$params['reference'] = rand(0, 9999); // Configurando a Ordem de Aplicação para Referência no PagSeguro
			
			// treat parameters here!
			$httpConnection = new HttpConnection();
			$httpConnection->post($this->pagSeguroData->getTransactionsURL(), $params);
			
			// Obter Xml do corpo de resposta
			$xmlArray = $this->paymentResultXml($httpConnection->getResponse());

			// Configurando o status do http e exibindo o json como resultado
			// http_response_code ($ httpConnection->getStatus());
			header("HTTP/1.1 ".$httpConnection->getStatus());
			
			echo json_encode($xmlArray);
			
		}
		
		private function parseSessionIdFromXml($data) {
			
			// Criando um analisador xml
			$xmlParser = new XmlParser($data);
			
			// Verificando se é um XML
			if ($xml = $xmlParser->getResult("session")) {
				
				// Retrieving the id from "session node"
				return $xml['id'];
				
			} else {
				throw new Exception("[$data] is not an XML");
			}
			
		}
		
		
		private function paymentResultXml($data) {
			
			// Criando um analisador xml
			$xmlParser = new XmlParser($data);
			
			// Verificando se é um XML
			if ($xml = $xmlParser->getResult()) {
				return $xml;
			} else {
				throw new Exception("[$data] is not an XML");
			}
			
		}
		
		
		
	}
	
	?>