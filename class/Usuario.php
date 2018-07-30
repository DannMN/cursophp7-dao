<?php 
class Usuario{
    /*
    Esta class esta diretamente ligada a tabela usuarios do banco dbphp7
    nos atributos usamos os mesmos nomes da tabela tb_usuario, para uma melhor compreenção
    */
    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;
    
    //aqui temos as funcoes getters e setters da classe para manter o encapsulamento da mesma
    
    //lembrando que tudo que é get pega o atributo da class e devemos retornar o valor utilizando o $this.
    public function getIdusuario(){
        return $this->idusuario;    
    }
    //Lembrando que tudo que é set atribui valor para o atributo, logo recebe um valor como entrada e usamos o $this para setar este valor.
    public function setIdusuario($value){
        $this->idusuario = $value;        
    }
    public function getLogin(){
        return $this->deslogin;
    }
    public function setLogin($value){
        $this->deslogin = $value;
    }
    public function getSenha(){
        return $this->dessenha;
    }
    public function setSenha($value){
        $this->dessenha = $value;
    }
    public function getDataCadastro(){
        return $this->dtcadastro;
    }
    public function setDataCadastro($value){
        $this->dtcadastro = $value;
    }
    //Fim dos getters e setters 
    
    /*
    A funcao loadById() serve para fazer um select na tabela tb_usuario, ela recebe um array como parametro para que a funcao setParam da class Sql possa fazer a associacao de chave e valor e assim poder returnar o usuario com base no seu id
    */
    public function loadById($id){
        $sql = new Sql();
        //o returno do select sera um array.
        
        $results = $sql->select("SELECT * FROM tb_usuario WHERE idusuario = :ID", array(
        ":ID"=>$id
        ));
        //Aqui fazemos uma verificação para ver se a consulta do banco returnou algum resultado
        if(count($results)> 0){            

            /*
            se retornar fazemos a atribuicao com os metodos setters
            na instancia da classe Usuarios utilizada
            */
            $this->setData($results[0]);
           
        }else{
            /*
            Caso a consulta nao retorne nada enviamos uma mensagem para o usuario.
            */
            echo "A tabela Usuarios nao contem Usuario com este id: ".$id;
        }
        
    }
    /*
     Funcao publica que retorna uma lista com todos os usuarios
    */
    public static function getList(){
        $sql = new Sql();
        //
        return $sql->select("SELECT * FROM tb_usuario ORDER BY deslogin;");
    }
    //Funcao para buscar um usuario com base nos caracteres passados como parametros
    public static function search($login){        
        $sql = new Sql();
        
        return $sql->select("SELECT * FROM tb_usuario WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
            ':SEARCH'=>"%".$login."%"
        ));
    }
    
    public function login($login, $senha){
        $sql = new Sql();
        //o returno do select sera um array.
        
        $results = $sql->select("SELECT * FROM tb_usuario WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(
            ":LOGIN"=>$login,
            ":PASSWORD"=>$senha
        ));
        //Aqui fazemos uma verificação para ver se a consulta do banco returnou algum resultado
        if(count($results)> 0){            

            /*
            se retornar fazemos a atribuicao com os metodos setters
            na instancia da classe Usuarios utilizada
            */
            
            $this->setData($results[0]);
        }else{
            /*
            Caso a consulta nao retorne nada enviamos uma mensagem para o usuario.
            */
            throw new exception("Login e/ou senha Inválidos!");
        }
    }
    //Esta funcao atribui os valores recebidos aos atributos da classe
    public function setData($data){            
            $this->setIdusuario($data["idusuario"]);
            $this->setLogin($data["deslogin"]);
            $this->setSenha($data["dessenha"]);
            $this->setDataCadastro(new DateTime($data['dtcadastro']));        
    }
    //Esta funcao inseri um usuario na tabela atraves de uma procedure chamada sp_usuarios_insert
    public function insert(){
        
        $sql = new Sql();
        
        $results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
            ':LOGIN'=>$this->getLogin(),
            ':PASSWORD'=>$this->getSenha()
        ));
        if(count($results) > 0){
            $this->setData($results[0]);
        }
    }
    public function update($login, $senha){
        $this->setLogin($login);
        $this->setSenha($senha);
        
        $sql = new Sql();
        
        $sql->query("UPDATE tb_usuario SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
            ':LOGIN'=>$this->getLogin(),
            ':PASSWORD'=>$this->getSenha(),
            ':ID'=>$this->getIdusuario()
        ));
    }
    /*
        Este é o metodo construtor que recebe doi parametros o novo login e a nova senha, sendo que eles nao sao obrigatorios visto que caso nao seja passado sera vazio
    */
    public function __construct($login = "", $senha = ""){        
        $this->setLogin($login);
        $this->setSenha($senha);
    }
    /*
    Esta funcao é uma funcao que chamamos de metodo magico, ela transformara os atributos da instancia 
    em string e retornada em formato json pois estamos utilizando o metodo json_encode() nativo do PHP
    */
    public function __toString(){        
        return json_encode(array(
            "Id Usuario"=>$this->getIdusuario(),
            "Login"=>$this->getLogin(),
            "Senha"=>$this->getSenha(),
            "Data do Cadastro"=>$this->getDataCadastro()->format("d/m/Y H:i:s")
        ));
    }
    
}
?>