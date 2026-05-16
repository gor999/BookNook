<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class AdminController extends Controller
{
    public function dashboard()
    {
    $books = Book::latest()->get();
    return view('admin.dashboard', compact('books'));
    }

    
    public function index()
    {
     return view('static.login'); 
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
         $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);
    return redirect()->route('login')->with('success', 'Հաջողությամբ գրանցվեցիք, այժմ կարող եք մուտք գործել։');

    }

    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        return view('edit', compact('book'));
    }

    public function update(Request $request, string $id)
    {

    $request->validate([
       'title' => 'required|string|max:255',
       'author' => 'required|string|max:255',
       'price' => 'required|numeric|min:0',
    ]);

    $book = Book::findOrFail($id);
    $book->update($request->all());
    return redirect()->route('admin.dashboard')->with('success', 'Գիրքը թարմացվեց');
    }

    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->back()->with('success', 'Գիրքը ջնջվեց');
    }
 


    public function register(){
        return view('static.register');
    }
    
    public function roles()
    {    
        //$users = User::all();
        $user = User::with('role')->get();
        dd($user);
        $roles = Role::all();
        return view('admin.role', compact('users', 'roles'));
    }
    public function assignRole(Request $request, $userId)
{
    $request->validate([
        'role_id' => 'required|exists:roles,id',
    ]);

    $user = User::findOrFail($userId);
    $user->role_id = $request->role_id; 
    $user->save();

    return back()->with('success', 'Դերը հաջողությամբ վերագրվեց օգտատիրոջը:');
}
}