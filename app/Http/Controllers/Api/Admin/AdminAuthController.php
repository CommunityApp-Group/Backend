<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Traits\GetRequestType;
use App\Helpers\ResourceHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use App\Http\Requests\Auth\AdminPasswordResetRequest;
use App\Http\Requests\Auth\CreateNewAdminRequest;
use App\Http\Resources\Admin\AdminCollection;
use App\Http\Resources\Admin\AdminResource;
use App\Http\Resources\Admin\AdminlistResource;
use App\Http\Resources\User\UserlistResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;
use Validator;

class AdminAuthController extends Controller
{
    use GetRequestType;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin')->except(['authenticate', 'logout']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
      $admin = Admin::latest()->paginate(10);
       return AdminlistResource::collection($admin);

    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function user()
    {
      $user = User::latest()->paginate(10);
       return UserlistResource::collection($user);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return AdminResource
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return AdminResource
     */
    public function store(CreateNewAdminRequest $request)
    {
        $admin = new Admin;
        $admin->name = $request->name;
        $admin->status = $request->status;
        $admin->email = $request->email;
        $admin->password =  Hash::make($request->password);
        $admin->phone = $request->phone;
        $admin->location = $request->location;
        $admin->created_by = auth()->guard('admin')->user()->id;
        $admin->save();
        return ResourceHelpers::returnAdminData($admin);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return AdminResource
     */
    public function show(Admin $admin)
    {
        return new AdminResource($admin);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return AdminResource
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'phone' => 'required',
            'password' => 'required',
        ]);
        $user = auth()->guard('admin')->user();
        if($admin->id !== $user->id) return response()->errorResponse('Permission Denied', [], 403);

        $admin->update($request->all());

        return (new AdminResource($admin))->additional([
            'message' => 'Details successfully updated',
            'status' => 'success'
        ]);
    }


    /**
     * @param AdminLoginRequest $request
     * @return \App\Http\Resources\Admin\AdminResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(AdminLoginRequest $request)
    {
        if(auth('api')->check()) {
            auth('api')->logout();
        }

        return $request->authenticate();

    }
    /**
     * @param Request $request
     * @return mixed
     */
    public function forgotPassword(Request $request) {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
            ? response()->success(__($status))
            : response()->errorResponse(__($status));
    }


    /**
     * @param AdminPasswordResetRequest $request
     * @return mixed
     */
    public function resetPassword(AdminPasswordResetRequest $request) {
        return $request->resetPassword();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return AdminResource
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return (new AdminResource($admin))->additional([
            'message' => 'Admin successfully Deleted',
            'status' => 'success'
        ]);
    }

    /**
     * Get the authenticated Admin.
     *
     * @return AdminResource
     */
    public function me()
    {
        return logedAdmin();
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
 public function logout()
 {
     if (auth()->guard('admin')->check()) {
         auth()->guard('admin')->logout();
         return response()->success('Session ended! Log out was successful');
     }
     return response()->errorResponse('You are not logged in', [], 401);
 }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $admin = auth()->guard('admin')->user();

        return response()->json([
            'user'=>$admin,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
