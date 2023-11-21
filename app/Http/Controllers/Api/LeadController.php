<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'fullname'  => 'required',  
            'email'     => 'required',  
            'phone'     => 'required',
            'country'   => 'required',  
            'dep_day'   => 'required',  
            'arr_day'   => 'required',  
        ]);


        $client = new \Google_Client(); 
        $client->setApplicationName('Google Sheets Artiweb backend');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');  
        $client->setAuthConfig(__DIR__ . '/credentials.json');
        $service = new \Google_Service_Sheets($client); 
        $spreadsheetId = "1OVR1jpQr7MqnHifitJCFMIbstdDbwrPkarHBiXA-RUU";   

        $range = "Sheet1!A:E";

        $values = [
            [ $request['fullname'], $request['email'],  $request['phone'], $request['country'], $request['dep_day'], $request['arr_day'] ],
        ];  

        $body = new \Google_Service_Sheets_ValueRange([
            'values'    => $values
        ]);  

        $insert = [
            "insertDataOption"  => "INSERT_ROWS"
        ];  

        $params = [
            'valueInputOption'  => 'RAW'
        ];

        $result = $service->spreadsheets_values->append(
            $spreadsheetId, 
            $range, 
            $body,
            $params,
            $insert
        );  

        if($result->updates->updatedRows != 0){
            echo json_encode([
                'message' => "success",
            ]);
        } else {
            echo json_encode([
                'message' => "error",
            ]);
        }

        Lead::create($request->all()); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
