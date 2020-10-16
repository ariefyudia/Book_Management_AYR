<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

// Models
use App\Models\Author;

class AuthorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $authors = Author::latest()->paginate(5);

        return view('authors.index', compact('authors'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('authors.create');
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
            'name' => 'required',
        ]);

        Author::create($request->all());

        return redirect()->route('authors.index')
            ->with('success', 'Author created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $author->update($request->all());

        return redirect()->route('authors.index')
            ->with('success', 'Author updated successfully');
    }
    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Author  $author
    //  * @return \Illuminate\Http\Response
    //  */
    public function destroy(Author $author)
    {
        $userRole = DB::table('role_permission')
        ->join('user_role', 'user_role.role_id', '=', 'role_permission.role_id')
        ->where('user_role.user_id', Auth::user()->id)
        ->where('role_permission.permission_id', 5)
        ->first();

        if($userRole) {
            $author->delete();
            return redirect()->route('authors.index')
            ->with('success', 'Author deleted successfully');
        } else {
            return redirect()->route('authors.index')
            ->with('danger', 'Author deleted failed');
        }
        

        
    }
}
