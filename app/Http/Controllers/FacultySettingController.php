<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FacultySettingController extends Controller
{
    public function index()
    {
        //
        $user = User::all();
        return $user;
    }

    public function get($id)
    {
        
        
        $user = User::select(
        'first_name',
        'user_id',
        'role_id',
        'user_email',
        'last_name',
        'user_image',
        'verified')
        ->where('user_id',$id)->get();
        return $user[0];
    }

    public function storegeneralinfo(Request $request){
        
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

  public function uploadpic(Request $request) {
          
       $request->validate([
          'file' => 'required|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:2048'
       ]);

      $file = $request->file('file');

      // Generate a file name with extension
      $fileName = 'profpic'.time().'.'.$file->getClientOriginalExtension();

      // Save the file
      $destinationPath = public_path().'/images';
      $path=$file->move($destinationPath,$fileName);
      

           User::where('user_id',1)->update([
               'user_image'=>'images/'.$fileName                  
            ]);
  }
  
    public function retrievepassword()
    {
      $myuser=User::select('user_password')->where('user_id',1)->get();

      return $myuser[0];
    }

    public function update(Request $request)
    { 
      $user=user::where('user_id', 1)->get();
      $userPassword = $user[0]->user_password;

      if ($request->oldPassword===$userPassword) {
        if($request->newPassword != $userPassword) {
            $user=user::where('user_id', 1)->update([
              'user_password'=>$request->newPassword,
            ]);
        }
        else {
          return ['message', 'you cannot enter your old password'];
        }
      }
      else {
        return ['message', 'old password is not the same with your original password'];
      }
  }
}