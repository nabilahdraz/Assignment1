<?php
use Slim\Http\Request; //namespace
use Slim\Http\Response; //namespace

//include petProc.php file
include __DIR__ . '/function/petProc.php';

//read table pets
$app->get('/pets', function (Request $request, Response $response, array
$arg){
return $this->response->withJson(array('data' => 'success'), 200);
});

// read all data from table pets
$app->get('/allpets',function (Request $request, Response $response,array $arg)
{
$data = getAllPets($this->db);
if (is_null($data)) {
return $this->response->withHeader('Access-Control-Allow-Origin', '*')->withJson(array('error' => 'no data'), 404);
}
return $this->response->withJson(array('data' => $data), 200);
});

//request table pets by condition name
$app->get('/pets/[{Name}]', function ($request, $response, $args){
$petsName = $args['Name'];
if (!is_string($petsName)) {
return $this->response->withJson(array('error' => 'alphabetic paremeter required'), 500);
}
$data = getPets($this->db,$petsName);
if (empty($data)) {
return $this->response->withJson(array('error' => 'no data'), 500);
}
return $this->response->withJson(array('data' => $data), 200);
});

//post method
$app->post('/pets/add', function ($request, $response, $args) { 
    $form_data = $request->getParsedBody(); 
    $data = createPets($this->db, $form_data); 
    if (is_null($data)) {
        return $this->response->withJson(array('error' => 'add data fail'), 500);
    }
    return $this->response->withJson(array('add data' => 'success'), 200); 
    } 
   );

//put table pets
$app->put('/pets/put/[{Id}]', function ($request, $response, $args){
    $petsId = $args['Id'];
    if (!is_numeric($petsId)) {
    return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
    }
    $form_dat=$request->getParsedBody();
    $data=updatePets($this->db,$form_dat,$petsId);
    if ($data <=0)
    return $this->response->withJson(array('data' => 'successfully updated'), 200);
    });

//delete row
 $app->delete('/pets/del/[{Id}]', function ($request, $response, $args){
    $petsId = $args['Id'];
    if (!is_numeric($petsId)) {
    return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
    }
    $data = deletePets($this->db,$petsId);
    if (empty($data)) {
    return $this->response->withJson(array($petsId=> 'is successfully deleted'), 202);};
    });
    