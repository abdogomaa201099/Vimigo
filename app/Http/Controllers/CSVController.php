<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CSVFileRequest;

class CSVController extends Controller
{   
    // The expected format of the inserted csv is like (name_column | email_column | password_column) 
    public function InsertUpdateFromCsv(CSVFileRequest $request){
        $validated = $request->validated();
            $file=$request->file('file')->store('csv');// store the file in the storage directory 
            $path='C:\\xampp\\htdocs\\REST_API\\storage\\app\\'.$file;
            $csvrows = array_map('str_getcsv', file($path));
            $csvheader = array_shift($csvrows);
            $csv = array();
            $count=0;
            foreach ($csvrows as $row) { // Iterate through each row in csv.
            $csv[] = array_combine($csvheader, $row);
            if(User::where('email', '=', $csv[$count]['email'])->count() > 0){
                //Update Data
                DB::table('users')->where("email", $csv[$count]['email'])->update($csv[$count]);
             }else {
                 // Insert New Records
                User::create([
                    'name'=>$csv[$count]['name'], 
                    'email'=>$csv[$count]['email'], 
                    'password'=>$csv[$count]['password']
                ]);
             }
            $count++;
            }
            return response(['message' =>'Inserting/Update Done Successfully'], 200);
            
    }


     // The expected format of the inserted csv is like ( email_column ) 
    public function DeleteBycsvfile(CSVFileRequest $request){
        $validated = $request->validated();
        $file=$request->file('file')->store('csv');
        $path='C:\\xampp\\htdocs\\REST_API\\storage\\app\\'.$file;
        $csvrows = array_map('str_getcsv', file($path));
        $csvheader = array_shift($csvrows);
        $csv = array();
        $count=0;
        foreach ($csvrows as $row) {
        $csv[] = array_combine($csvheader, $row);
            //Delete records using matched email
            if(User::where('email', '=', $csv['email'])->count() > 0){
                
                User::where("email",'=' ,$csv['email'])->delete();

            }else{
                return response(['message' =>'An email does not exist.'], 400);
            }
            $count++;
        }
        return response(['message' =>'Deletion Done Successfully'], 200);
    }
        

}