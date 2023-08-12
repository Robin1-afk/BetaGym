<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use DB;

class ClientController extends Controller
{

    /* Consult the all to clients register in the Gym*/
    public function indexClient(){
        try {

            $clients = Client::all();
            
            if ($clients->isEmpty()) {
                return response()->json([], 204);
            }
        
            return response()->json(['message' => 'Query successful', 'data' => $clients], 200);
        }catch (QueryException $e) {
            return response()->json(['message' => 'Error in Query: ' . $e->getMessage()], 500);
        }
    }

    /* Query the client by id */
    public function showClient($id)
    {
        try {

            $clients = DB::table('clients')->where('id', "=" , $id)->get();            
            if ($clients->isEmpty()) {
                return response()->json([], 204);
            }
        
            return response()->json(['message' => 'Query successful', 'data' => $clients], 200);
        }catch (QueryException $e) {
            return response()->json(['message' => 'Error in Query: ' . $e->getMessage()], 500);
        }

    }

    /* Insert BD for new clients*/
    public function storeClient(Request $valores)
    {
        $client = new Client();

        try {

            $data = $valores->all();

            if (empty($data)) {
                return response()->json([], 204);
            }

            $client->name = $valores->name;
            $client->year = $valores->year;
            $client->time_subscription = $valores->time_subscription;
            $client->type_subscription = $valores->type_subscription;
            $client->save();
            return response()->json(['message' => 'Successful registration', 'data' => $client], 200);

        } catch (QueryException $e) {
            return response()->json(['message' => 'Error in Querys: ' . $e->getMessage()], 500);
        }
    }

    /* Update date client*/
    public function updateClient(Request $valores, $id)
    {
        try {

            $client = Client::find($id);

            if (!$client) {
                return response()->json(['message' => 'Client not found'], 404);
            }

            $client->name = $valores->name;
            $client->year = $valores->year;
            $client->time_subscription = $valores->time_subscription;
            $client->type_subscription = $valores->type_subscription;
            $client->save();

            return response()->json(['message' => 'Successful client update'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error updating client: ' . $e->getMessage()], 500);
        }
    }

    /* Delet client*/
    public function deleteClient($id)
    {
        try {
            $client = Client::find($id);

            if (!$client) {
                return response()->json(['message' => 'Client not found'], 404);
            }

            $client->delete();

            return response()->json(['message' => 'Client deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error deleting client: ' . $e->getMessage()], 500);
        }
    }
  
}
