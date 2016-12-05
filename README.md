#Exemplo-de-Checkout-Transparente-da-pag-seguro
exemplo de como utilizar api do pag seguro para pagamento usando cartão boleto e pagamento online 

# credenciais 
Dentro da pasta App você ira encontra PagSeguroData.class.php nesta pagina existe as credentials do  production e sandbox   https://sandbox.pagseguro.uol.com.br/comprador-de-testes.html	o link permite que você acesse a biente de teste do pag seguro e teste a aplicação sem se preocupar o exemplo ja esta apontando para o abiente de teste e para obter as credentials você tem acessar a no menu lateral a opção vendedor la você encontrara o seu email e um token para usar nos seus testes para testar a aplicação os dados de comprador que você deve usar estão em vendedor de teste no campo do email de comprado usem o email de teste fonecido pelo pag seguro no abiente de comprador de teste la você encontra tambem os dados de um cartão de credito para testes.
private $sandboxData = Array(
			
			'credentials' => array(
				"email" => "seu email",
				"token" => "seu token"
			),
			'sessionURL' => "https://ws.sandbox.pagseguro.uol.com.br/v2/sessions",
			'transactionsURL' => "https://ws.sandbox.pagseguro.uol.com.br/v2/transactions",
			'javascriptURL' => "https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"
		);
		
		private $productionData = Array(
			
			'credentials' => array(
				"email" => "seu email",
				"token" => "seu token"
			),
			
			'sessionURL' => "https://ws.pagseguro.uol.com.br/v2/sessions",
			'transactionsURL' => "https://ws.pagseguro.uol.com.br/v2/transactions",
			'javascriptURL' => "https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"
			
		);
#Referencia 
exemplo de base criado pela pag seguro
http://download.uol.com.br/pagseguro/docs/example.zip
