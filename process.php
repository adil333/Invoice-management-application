<?php
require "model.php";

if (isset($_POST['action']) && $_POST['action'] === "CREATE") {
    if(isset($_POST['customer'], $_POST['cashier'], $_POST['amount'], $_POST['received'], $_POST['state']) && !empty($_POST['customer'])&& !empty($_POST['cashier'])&& !empty($_POST['amount'])&& !empty($_POST['received'])&& !empty($_POST['state'])){
        $db = CrudToDb::getInstancePdo();
        htmlspecialchars(extract($_POST));
        $returned = (int)$amount - (int)$received;
        $db->create($customer, $cashier, $amount, $received, $returned, $state);
    }else {
        echo "veillier bien remlire le formulaire";
    }
 
}

if (isset($_POST['action']) && $_POST['action'] === "READ") {
    $db = CrudToDb::getInstancePdo();
    $output = '<table class="table table-striped" id="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Client</th>
                        <th scope="col">Caissier</th>
                        <th scope="col">Montant</th>
                        <th scope="col">Percu</th>
                        <th scope="col">Retourne</th>
                        <th scope="col">Etat</th>
                        <th scope="col">action</th>
                    </tr>
                </thead>
                <tbody>';
    $Bills = $db->read();
    if ($Bills === "vide"){
        echo "<h3>Acun Facture pour le moment</h3>";
    }else{
        foreach($Bills as $Bill){
            $output .= "
            <tr>
                <th scope=\"row\">$Bill->id</th>
                <td>$Bill->customer</td>
                <td>$Bill->cashier</td>
                <td>$Bill->amount</td>
                <td>$Bill->received</td>
                <td>$Bill->returned</td>
                <td>$Bill->state</td>
                <td>
                    <a href=\"#\" class=\"text-info me-2 infoBtn\" data-id=\"$Bill->id\" title=\"Voir detaile\"><i class=\"fas fa-info-circle\"></i></a>
                    <a href=\"#\" class=\"text-warning me-2 editBtn\" data-id=\"$Bill->id\" title=\"Modifier\" data-bs-toggle=\"modal\" data-bs-target=\"#updateModal\"><i class=\"fas fa-edit\"></i></a>
                    <a href=\"#\" class=\"text-danger me-2 deleteBtn\" data-id=\"$Bill->id\" title=\"Supprimer\"><i class=\"fas fa-trash-alt\"></i></a>
                </td>
            </tr>";
        }
        $output .= '</tbody> </table>';
       echo $output;
                    
    }


}
if (isset($_POST['deleteId']) && !empty($_POST['deleteId'])) {
    $db = CrudToDb::getInstancePdo();
    $deletedBill = $db->delete($_POST['deleteId']);
    if($deletedBill){
        echo "Bill has been deleted";
    }else{
        echo "une erreur de supprision est survenue";
    }
}

if (isset($_POST['deleteId']) && !empty($_POST['deleteId'])) {
    $db = CrudToDb::getInstancePdo();
    $deletedBill = $db->delete($_POST['deleteId']);
    if($deletedBill){
        echo "Bill has been deleted";
    }else{
        echo "une erreur de supprision est survenue";
    }
}

if (isset($_POST['UpdateId']) && !empty($_POST['UpdateId'])) {
    $db = CrudToDb::getInstancePdo();
    $getupdatedBill = $db->readOneBill(htmlentities($_POST['UpdateId']));
    echo json_encode($getupdatedBill); 

}


if (isset($_POST['action']) && $_POST['action'] == "UPDATE") {
    $db = CrudToDb::getInstancePdo();
    htmlspecialchars(extract($_POST));
    $returned = (int)$amount - (int)$received;
    $updatedBill = $db->update($id, $customer, $cashier, $amount, $received, $returned, $state);
    echo $updatedBill; 

}

// get info of one bill
if (isset($_POST['readId']) && !empty($_POST['readId'])) {
    $db = CrudToDb::getInstancePdo();
    $getInfoBill = $db->readOneBill(htmlentities($_POST['readId']));
    echo json_encode($getInfoBill); 

}