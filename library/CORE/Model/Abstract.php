<?php

abstract class CORE_Model_Abstract
{
    private static $_db = null;
    protected $_dbTable;
    protected $_log;

    public function getDb()
    {
        if( is_null(self::$_db) )
            self::$_db = Zend_Db_Table::getDefaultAdapter();

        return self::$_db;
    }

    public function getDbTable() 
    {
        return $this->_dbTable;
    }

    public function find($id)
    {
        $current = $this->_dbTable->find($id)->current();
        if( !$current )
            throw new Exception('Registro não encontrado.');

        return $current->toArray();
    }

    public function save(array $data)
    {
        if(!is_array($data))
            throw new Exception('o argumento passado não é um array.');
        
        if (isset($data['id'])) {
            return $this->_update($data);
        } else {
            return $this->_insert($data);
        }
    }

    public function delete($id)
    {
        $where = $this->_dbTable->getAdapter()->quoteInto('id = ?', $id);
        return $this->_dbTable->delete($where);
    }

    public function fetchPairs(array $conditions = null, $orders = null )
    {
        $sql = $this->_dbTable->select();
        $sql->from( $this->_dbTable->getName() );

        $this->_trataCondicoes( $sql, $conditions );
        $this->_trataOrdem( $sql, $orders );
        
        return $this->getDb()->fetchPairs($sql);
    }

    public function fetchAll($conditions = null, $limit = null, $orders = null, Zend_Db_Table_Select $sql = null )
    {
        if( is_null($sql) )
        {
            $sql = $this->_dbTable
                        ->getAdapter()            
                        ->select()
                        ->from( $this->_dbTable->getName() );    
        }
        
        $this->_trataCondicoes( $sql, $conditions );
        $this->_trataOrdem( $sql, $orders );

        if( !is_null($limit) || $limit != 0 )
        {
            $sql->limit($limit);
        }
        
        return $sql->query()->fetchAll();
    }

    public function fetch($conditions = null, $orders = null, Zend_Db_Table_Select $sql = null )
    {
        if( is_null($sql) )
        {
            $sql = $this->_dbTable
                        ->getAdapter()            
                        ->select()
                        ->from( $this->_dbTable->getName() );    
        }
        
        $this->_trataCondicoes( $sql, $conditions );
        $this->_trataOrdem( $sql, $orders );
        
        return $sql->query()->fetch();
    }

    public function count(array $conditions = null)
    {
        $sql = $this->_dbTable->getAdapter()            
                        ->select()
                        ->from( $this->_dbTable->getName(), array( 'total' => 'COUNT(id)' ) );
        
        $this->_trataCondicoes( $sql, $conditions );

        $data = $sql->query()->fetch();

        return $data['total'];
    }

    public function search(array $params)
    {
        if(!is_array($data))
            throw new Exception('o argumento passado não é um array.');
        
        $str = isset($params['str']) ? $params['str'] : "";
        $conditions = isset($params['conditions']) ? $params['conditions'] : array();
        $ordem = isset($params['ordem']) ? $params['ordem'] : null;
        $page = isset($params['pagina']) ? (int) $params['pagina'] : 1;
        $perPage = isset($params['perpage']) 
                    ? (int) $params['perpage'] 
                    : Zend_Registry::get('config')->paginator->totalItemPerPage;
        $limit = ( $page - 1 ) * $perPage;
        $where = null;
        $sql = $this->_dbTable
                    ->select();

        if( !is_null($ordem) )
        {
            $this->_trataOrdem( $sql, $ordem );
        }

        $this->_trataCondicoes( $sql, $conditions );

        if ( !is_null($limit) || $limit != 0 )
        {
            $sql->limit($perPage, $limit);
        }

        $paginator = Zend_Paginator::factory($sql);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($perPage);
        
        return $paginator;
    }

    public function getAsArray( $id ) {
        return $this->find($id)->toArray();
    }

    public function _insert(array $data)
    { 
        if(!is_array($data))
            throw new Exception('Argumento passado não é um array.');
        
        return $this->_dbTable->insert($data);
    }

    public function _update(array $data)
    {
        if(!is_array($data))
            throw new Exception('o argumento passado não é um array.');
        
        $id = $data['id'];
        unset($data['id']);
        
        $where = $this->_dbTable->getAdapter()->quoteInto('id = ?', $id);
        return $this->_dbTable->update($data, $where);
    }

    protected function _trataCondicoes( Zend_Db_Select $sql, array $conditions = null )
    {
        if (!is_null($conditions)) {
            foreach ($conditions as $key => $condition) {
                if( !is_array($condition) )
                {
                    if( !is_numeric( $key ) )
                    {
                        $sql->where($key, $condition);
                    }
                    else
                    {
                        $sql->where($condition);
                    }
                }
                else
                {
                    if( $condition[1] == 'OR' )
                    {
                        $sql->orWhere($key, $condition[0]);
                    }
                    else
                    {
                        $sql->where($key, $condition);
                    }
                }
            }
        }
    }

    protected function _trataOrdem( Zend_Db_Select &$sql, $orders = null )
    {
        if( !is_null($orders) )
        {
            if( is_array($orders) )
            {
                foreach ($orders as $key => $order) {
                    $sql->order($order);
                }
            }
            else
            {
                $sql->order($orders);
            }
        }
    }
}