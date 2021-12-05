<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserPrivileges;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class StudentUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(array $headers = [])
    {
        return User::orderBy('created_at', 'DESC')->get();
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
    public function store(Request $request, array $headers = [])
    {   
        $validator = Validator::make($request->all(), [
            'user_image' => 'mimes:jpeg,bmp,png'
        ]);
        if($validator->fails()){
            return "image";
        }else{
            $rules = array('user_email' => 'unique:users,user_email');
            $validator = Validator::make($request->all(), [
                'user_email' => $rules
            ]);
            if($validator->fails()){
                return "email";
            }
        $imageFileName =  $request->user_image->getClientOriginalname();
        $path = $request->file('user_image')->storeAs('public', $imageFileName);

        $newUser = new User;
        $newUser->first_name = $request->first_name;
        $newUser->last_name = $request->last_name;
        $newUser->role_id = $request->role_id;
        $newUser->user_email = $request->user_email;
        $newUser->user_password = $request->user_password;
        $newUser->user_image = "/"."storage"."/".$imageFileName;
        $newUser->save();

        //Default Privileges
        $user = DB::table('users')
        ->where('user_email', '=', $newUser->user_email)
        ->orderBy('user_id','asc')
        ->first();

        $data = [
            ['user_id' => $user->user_id, 'privilege_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => $user->user_id, 'privilege_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => $user->user_id, 'privilege_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ];
        DB::table('user_privileges')->insert($data);
    }
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
    public function update(Request $request, $id, array $headers = [])
    {   
        //if User doesn't upload and keeps old image path scenario
        //and if user uploads and has new image uploaded
        if(is_string($request->user_image)){
            $imageFileName = $request->user_image;
        }else{
        $validator = Validator::make($request->all(), [
            'user_image' => 'mimes:jpeg,bmp,png'
        ]);
        if($validator->fails()){
            return "image";
        }else{
            $imageFileName =  "/"."storage"."/".($request->user_image->getClientOriginalname());
        }
        }
            $rules = array('user_email' => 'unique:users,user_email,'.$id.',user_id');
            $validator = Validator::make($request->all(), [
                'user_email' => $rules
            ]);
            if($validator->fails()){
                return "email";
            }else{
        $existingUser = new User;
        $existingUser = DB::table('users')
                            ->Where('user_id','=',$id)
                            ->update(array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'role_id' => $request->role_id,
            'user_password' => $request->user_password,
            'user_email' => $request->user_email,
            'user_image' => $imageFileName,
            'updated_at' => Carbon::now()
        ));
        //API TESTING
        /*if( $existingUser ){
            $existingUser = DB::Select("Select * FROM users where user_id = $id");
            return $existingUser;
        }*/
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existingUser = new User;
        $existingPriv = new UserPrivileges;
        $existingPriv = UserPrivileges::Where('user_id', $id)->delete();
        $existingUser = User::Where('user_id', $id)->delete();
        if($existingUser){
            return "Deletion successfull";
        }else{
            return "deletion unsuccessfull";
        }
    }
}
