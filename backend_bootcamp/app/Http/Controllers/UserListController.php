<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\UserList; //model UselList
use JWTAuth;

class UserListController extends Controller
{
    function getData()
        {
            // Retreiving the Authenticated user from a token kalau ga pake middleware.untuk menentukan token masih valid atau tidak
            // if (! $user = JWTAuth::parseToken()->authenticate()) //tanda seru berarti not
            //     {
            //         return response()->json(['user_not_found'], 404);
            //     }

            $userList = UserList::get(); //UserList adalah model

            return response()->json($userList, 200);
        }

    function addData(Request $request)
        {
            //DB transaction
            DB::beginTransaction(); //untuk membungkus transaksi, fungsinya adalah jika insert data sukses maka data 
            // akan dicommit dan disave ke database, dan jika gagal maka data akan dirollback

            try
                {
                    //validasi client untuk input
                    $this->validate($request,[
                        'name' => 'required', //required artinya data tidak boleh kosong
                        'email' => 'required|email' // email tidak boleh sama
                    ]);

                    //save ke database
                    $name = $request->input('name'); //data diambil dari client ke server
                    $address = $request->input('address');
                    $email = $request->input('email');

                    // save ke database menggunakan metode eloquen
                    $usr = new UserList;
                    $usr->name = $name;
                    $usr->address = $address;
                    $usr->email = $email;
                    $usr->save();

                     $usrList = UserList::get();

                    DB::commit(); //jika insert data sukses maka data akan dicommit dan disave ke database
                    return response()->json($usrList, 200); //saat add user maka akan melakukan add $usrList
                }
            catch (\Exception $e)
                {
                    DB::rollback(); //dan jika gagal maka data akan dirollback
                    return response()->json(["message" => $e->getMessage()], 500); //500->internal server error
                }
        }

    function deleteData(Request $request)
        {
            DB::beginTransaction();
            try
                {
                    $this->validate($request,[
                        'id' => 'required' //required artinya data tidak boleh kosong
                    ]);

                    $id = (integer)$request->input('id');
                    $usr = UserList::find($id);

                    if(empty($usr))
                        {
                            return response()->json(["message" => "User not found"], 404);
                        }

                    $usr->delete();

                    $usrList = UserList::get();

                    // $data = UserList::where('id','=',$request->input("id"))->delete();
                    DB::commit();
                    return response()->json(["message" => "Success !!"], 200);
                }
            catch (\Exception $e)
                {
                    DB::rollback();
                    return response()->json(["message" => $e->getMessage()], 500);
                }    
        }
}
