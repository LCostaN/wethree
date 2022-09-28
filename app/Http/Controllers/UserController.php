<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Imports\UsersImport;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return UserCollection
     */
    public function index()
    {
        return new UserCollection(User::paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'phone_number' => 'required||max:255',
            ]);
            return User::create($validatedData);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], ResponseAlias::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return UserResource
     */
    public function show($user)
    {
        return new UserResource(User::findOrFail($user));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     */
    public function destroy($user)
    {
        $flight = User::findOrFail($user);

        $flight->delete();

        return response()->json(['message' => 'removed successfully']);
    }

    /**
     * @return BinaryFileResponse
     */
    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    /**
     * @return RedirectResponse
     */
    public function import()
    {
        Excel::import(new UsersImport,request()->file('file'));

        return back();
    }

    public function load_missing()
    {
        $users = User::whereRaw('ifnull(length(phone_number), 0) = 0')
            ->orWhereRaw('ifnull(length(last_name), 0) = 0')
            ->orWhereRaw('ifnull(length(email), 0) = 0')
            ->orWhereRaw('ifnull(length(first_name), 0) = 0')->limit(100)
            ->get();
        return view('users', compact('users'));
    }
}
