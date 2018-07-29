<?php
//Classe para conexao e consulta do banco de dados 
class Sql extends PDO {
    
    private $conn;
    
    public function __construct(){        
        /*
        Este metodo construtor atribuimos o tipo do banco o localhost,
        nome do banco e usuario e senha para login
        */
        $this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "");        
    }
    
    /*
        Com esta funcao privada podemos percorrer o retorno da funcao query()
        e ja separar parametro recebido um por um e enviar para a funcao setParam()
    */
    private function setParams($statement, $parameters = array()){         
        foreach($parameters as $key => $value){            
            $this->setParam($statement, $key, $value);
        }
        
    }
    /*
    A funcao setParam() serve para fazer a ligacao das chaves com os valores
    */
    private function setParam($statement, $key, $value){
        $statement->bindParam($key, $value);
    }
    /*
    A query(), pode ser usada para fazermos SELECT, INSERT, UPDATE ou ate mesmo DELETE nas tabelas do banco dbphp7.
    Ela recebe o comando sql e parametros em formato array posibilitando passar mais de um parametro
    */
    public function query($rawQuery, $params = array()){
        /*
        ao receber os parametros a funcao query() faz o prepare da class PDO e é guardada na variavel local $stmt que posteriormente sera usada na funcao setParams() junto com a variavel $params
        */
        $stmt = $this->conn->prepare($rawQuery);
        /*
        A funcao setParams recebe a varivel $stmt com ja preparada e tambem os parametros no array $params e vai fazer o bind (ligação) entre o identificado (:+nome) com a variavel correspondente
        */
        $this->setParams($stmt, $params);
        $stmt->execute();        
        return $stmt;
    }
    /*
    Este metodo é publico e serve para fazermos consultas tabelas do banco dbphp7, so precisamos passar os parametros... como exemplo "SELECT * FROM `nome da tabela` " que sera recebido no $rawQuery, e tambem podemos passar parametros que seram recebidos no array $params. 
    */
    public function select($rawQuery, $params = array()):array{        
        /*
        O parametro $rawQuery e $params seram passado como parametro para a funcao privada query() que ira retornar o resultado da busca no banco.
        */
        $stmt = $this->query($rawQuery, $params); 
        /*
        Apos receber o resultado da busca a funcao select() returna um array associativo com os dados.
        */
        return $stmt->fetchAll(PDO::FETCH_ASSOC);        
    } 
    
    
}

?>