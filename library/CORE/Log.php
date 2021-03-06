<?php

/**
 * Classe para criação de log
 */
class CORE_Log extends Zend_Log
{
	/**
	 * Guarda o caminho da pasta dos logs
	 * @var string
	 */
	private $_path = null;

	/**
	 * Guarda o destino padrão, para onde vão todas as mensagens
	 * que estão sendo logadas.
	 * @var string
	 */
	private $_destinoPadrao = null;

	/**
	 * Guarda a lista dos principais arquivos que devem ser criados
	 * @var array
	 */
	private $_arquivosPrincipais = array(
        'application.log',
        'atividades.log',
        'erros.log',
    );

	public function __construct( $path, Zend_Log_Writer_Abstract $writer = null)
	{
		$this->setPath( $path );
		$this->setDestinoPadrao( $this->getPath() . 'application.log' );

		$this->iniciaConfig();

		if( is_null($writer) )
		{
			$writer = new Zend_Log_Writer_Stream( $this->_destinoPadrao );
		}

		parent::__construct($writer);
	}

	public function getPath()
	{
	    return $this->_path;
	}
	
	public function setPath($path)
	{
	    return $this->_path = $path;
	}

	public function getDestinoPadrao()
	{
	    return $this->_destinoPadrao;
	}
	
	public function setDestinoPadrao($destinoPadrao)
	{
	    return $this->_destinoPadrao = $destinoPadrao;
	}

	public function getArquivosPrincipais()
	{
	    return $this->_arquivosPrincipais;
	}
	
	public function setArquivosPrincipais($arquivosPrincipais)
	{
	    return $this->_arquivosPrincipais = array_merge( $this->getArquivosPrincipais(), $arquivosPrincipais );
	}

	/**
	 * Faz o log da mensagem
	 * @param  string $mensagem   
	 * @param  int|constant $prioridade Zend_Log::NOTICE
	 * @param  string $destino    null
	 * @param  mixed    $extras    Extra information to log in event
	 * @return Zend_Log
	 */
    public function log( $mensagem, $prioridade = Zend_Log::NOTICE, $destino = null, $extras = null )
    {
        if( is_null( $destino ) )
       	{
       		$destino = $this->getDestinoPadrao();
       	}
       	else
       	{
       		$destino = realpath( DATA_PATH . '/logs/' . $destino );
       	}
        
        parent::log( $mensagem , $prioridade, $extras );

        return $this;
    }

    public function logErro( $mensagem )
    {
        return $this->log( 
        	$mensagem, 
        	Zend_Log::ERR, 
        	'erros.log' 
        );
    }

    public function iniciaConfig( array $arquivosExtras = null )
    {
    	if( !is_null($arquivosExtras) && count($arquivosExtras) > 0 )
    	{
    		$this->setArquivosPrincipais($arquivosExtras);
    	}

        foreach( $this->_arquivosPrincipais as $arquivo )
        {
            $this->_criaArquivo( $this->getPath() . $arquivo);
        }

        return $this;
    }

    private function _criaArquivo($arquivo)
    {
        if( !file_exists($arquivo) )
        {
            $fileInfo = pathinfo($arquivo);

            if( !is_dir($fileInfo['dirname']) )
            {
                mkdir($fileInfo['dirname'], 0755);
            }

            if( !is_writable($fileInfo['dirname']) )
            {
                chmod($fileInfo['dirname'], 0755);
            }

            file_put_contents($arquivo, '');

            chmod($arquivo, 0755);
        }
        else
        {
            if( !is_writable($arquivo) )
            {
                chmod($arquivo, 0755);
            }
        }

        return $this;
    }
}