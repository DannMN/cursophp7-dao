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
            $row = $results[0];
            /*
            se retornar fazemos a atribuicao com os metodos setters
            na instancia da classe Usuarios utilizada
            */
            $this->setIdusuario($row["idusuario"]);
            $this->setLogin($row["deslogin"]);
            $this->setSenha($row["dessenha"]);
            $this->setDataCadastro(new DateTime($row['dtcadastro']));
        }else{
            /*
            Caso a consulta nao retorne nada enviamos uma mensagem para o usuario.
            */
            echo "A tabela Usuarios nao contem Usuario com este id: ".$id;
        }
        
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