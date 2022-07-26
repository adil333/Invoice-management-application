
<?php 

class CrudToDb 
{
    protected static $_instance = null;
    private $conn ;
    // connection a la base de donner dés l'instancioation du CrudToDb
    public function __construct()
    {
        try{
            $this->conn = new PDO("mysql:host=localhost; dbname=Datatable", "root", "");
        }catch(PDOException $e){
            die("Erreur Lors de la connection a la base de donne $e->getMessage()");
        }
    }

    public static function getInstancePdo()
    {
        if (is_null(self::$_instance)){
            return new CrudToDb();
        }
        return self::$_instance;
    }

    public function create(string $customer, string $cashier, int $amount, int $received, int $returned, string $state){
        $sql_create = "INSERT INTO factures (customer, cashier, amount, received, returned, state) value(:customer, :cashier, :amount, :received, :returned, :state)";
        $sth = $this->conn->prepare($sql_create);
       return $sth->execute(array(':customer'=>$customer, ':cashier'=>$cashier, ':amount'=>$amount, ':received'=>$received, ':returned'=>$returned, ':state'=>$state));
    }

    public function read(){
        $sql_read = "SELECT * from factures ORDER BY id";
        $sth = $this->conn->query($sql_read);
        
        if($sth->rowCount() > 0){
           return $data = $sth->fetchAll(PDO::FETCH_OBJ);
        }else {
            return "vide";
        }
    }

    public function readOneBill($id){
        $sql_read = "SELECT * from factures where id = $id";
        $sth = $this->conn->query($sql_read);
        
        if($sth->rowCount() == 1){
           return $data = $sth->fetchAll(PDO::FETCH_OBJ);
        }else {
            return "erreur";
        }
    }
    
    public function update(int $id, string $customer, string $cashier, int $amount, int $received, int $returned, string $state){
        $sql_update = "UPDATE  factures set customer = :customer, cashier = :cashier, amount = :amount, received = :received, returned = :returned, state = :state where id = :id";
        $sth = $this->conn->prepare($sql_update);
       return $sth->execute(array(':id'=>$id, ':customer'=>$customer, ':cashier'=>$cashier, ':amount'=>$amount, ':received'=>$received, ':returned'=>$returned, ':state'=>$state));
    }

    public function delete(int $id){
        $sql_delete = "DELETE FROM factures where id = :id";
        $sth = $this->conn->prepare($sql_delete);
       return  $sth->execute([':id'=>$id]);
    }

   
}