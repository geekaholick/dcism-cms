<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class StudentSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = User::all();
         return $user;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function get($id)
    {
        
        
        $user = User::select('first_name',
        'user_id',
        'role_id',
        'user_email',
        'last_name',
        'user_image',
        'verified')
        ->where('user_id',$id)->get();
        return $user[0];
    }

    public function create()
    {
        //
    }

    public function storegeneral(Request $request){
        
        $myuser=User::select('user_email')->where('user_id',1)->get();   
        $this->validate($request, array(
             'first_name' => 'required|min:2',
             'last_name' =>'required|min:2',
             'email' => 'required|email'
          ));
        User::where('user_id',1)->update([
            'first_name'=>$request['first_name'],
            'last_name' =>$request['last_name'],            
        ]); 
         if($myuser[0]->user_email!==$request->email){
           if (!User::where('user_email', $request->email)->exists()) {
                 //does not exists
                User::where('user_id',1)->update([
                    'user_email'=>$request['email']                      
                 ]); 
                return [$myuser[0]->user_email];
            }
            else{
                echo '<script>alert("email already exists")</script>';
            }
            
         }
         else{
            return; 
         }
    }

    public function upload(Request $request){
            
         $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:2048'
         ]);

        $file = $request->file('file');

        // Generate a file name with extension
        $fileName = 'studpic'.time().'.'.$file->getClientOriginalExtension();

        // Save the file
        $destinationPath = public_path().'/images';
        $path=$file->move($destinationPath,$fileName);
        

             User::where('user_id',1)->update([
                 'user_image'=>'images/'.$fileName                  
              ]);

    }

    public function updatepass(Request $request){
        $user=User::select()->where('user_id',$request->id)->get();
        $origpass=$user[0]->user_password;
        $error=1;
        if($origpass!=$request->oldpass){
            $error=1;           
        }
        else{
            if($request->newpass==$origpass){
                $error=2;
            }
            else{
                User::where('user_id',$request->id)->update([
                    'user_password'=>$request->newpass            
                 ]);
                 $error=10;
            }
        }
        return $error;
    }

   
    public function destroy($id)
    {
        //
    }
}
