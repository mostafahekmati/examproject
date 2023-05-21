<?php
namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\Contracts\ApiController;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;

class UsersController extends ApiController
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
        
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'full_name' => 'required|string|min:3|max:255' ,
            'email' => 'required|email' ,
            'mobile' => 'required|string|digits:11' ,
            'password' => 'required' ,
        ]);
         $this->userRepository->create([
            'full_name' => $request->full_name ,
            'email' => $request->email,
            'mobile' => $request->mobile ,
            'password' => app('hash')->make($request->password)  ,
         ]);

         return $this->respondCreated('User created successfully.' ,[
            'full_name' => $request->full_name ,
            'email' => $request->email,
            'mobile' => $request->mobile ,
            'password' => $request->password ,
        ]);
          /*  return response()->json(
                [
                'success' => true ,
                'message' => 'User created successfully' ,
            
                'data' => [
                    'full_name' => $request->full_name ,
                    'email' => $request->email,
                    'mobile' => $request->mobile ,
                    'password' => $request->password ,
                ],
            ]
        )->setStatusCode(201); */
    }
}