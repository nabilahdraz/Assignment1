<?php
//get all pets
function getAllPets($db)
{
$sql = 'Select p.Name, p.Type, p.Breed, p.DOB from pets p ';
$stmt = $db->prepare ($sql);
$stmt ->execute();
return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//get pets by name
function getPets($db, $petsName)
{
$sql = 'Select p.Name, p.Type, p.Breed, p.DOB from pets p ';
$sql .= 'Where p.Name = :Name';
$stmt = $db->prepare ($sql);
$name = (string) $petsName;
$stmt->bindParam(':Name', $name, PDO::PARAM_STR);
$stmt->execute();
return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//add new pets
function createPets($db, $form_data) {
    $sql = 'INSERT into pets (Name, Type, Breed, DOB) ';
    $sql .= 'values (:Name, :Type, :Breed, :DOB)';
    $stmt = $db->prepare ($sql);
    $stmt->bindParam(':Name', $form_data['Name']);
    $stmt->bindParam(':Type', $form_data['Type']);
    $stmt->bindParam(':Breed', ($form_data['Breed']));
    $stmt->bindParam(':DOB', ($form_data['DOB']));
    $stmt->execute();
    return $db->lastInsertID();//insert last number.. continue
    }

//delete pets by id
    function deletePets($db,$petsId) {
    $sql = ' DELETE FROM pets where Id = :Id';
    $stmt = $db->prepare($sql);
    $id = (int)$petsId;
    $stmt->bindParam(':Id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

//update pets by id
    function updatePets($db,$form_dat,$petsId) {
    $sql = 'UPDATE pets SET Name = :Name , Type = :Type ,
    Breed = :Breed , DOB = :DOB';
    $sql .=' WHERE Id = :Id';
    $stmt = $db->prepare ($sql);
    $id = (int)$petsId;
    $stmt->bindParam(':Id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':Name', $form_dat['Name']);
    $stmt->bindParam(':Type', $form_dat['Type']);
    $stmt->bindParam(':Breed', $form_dat['Breed']);
    $stmt->bindParam(':DOB', $form_dat['DOB']);
    $stmt->execute();
}