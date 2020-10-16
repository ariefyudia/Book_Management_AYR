<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

// Models
use App\Models\Book;
use App\Models\Author;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $books = Book::latest()->paginate(5);
        
        return view('books.index', compact('books'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $authors = Author::all();
        return view('books.create', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' =>'required',
            'description' =>'required',
        ]);

        $book = new Book([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        $book->save();
        
        $ids = [];
        foreach($request->author as $authorID){
            $book->author()->attach($authorID);
        }
        
        return redirect()->route('books.index')->with('success','New book created');
    }

    public function edit($id)
    {
        //
        $book = Book::find($id);
        $authors = Author::all();
        $authorIDS = [];
        foreach($book->author as $author){
            $authorIDS[] = $author->id;
        }
        return view('books.edit', compact('authors','book','authorIDS'));
    }

    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name' =>'required',
            'description' =>'required',
        ]);

        $book = Book::find($id);
        $book->name = $request->name;
        $book->description = $request->description;
        $book->save();
        
        $ids = [];
        foreach($request->author as $authorID){
            $ids[] = $authorID;
        }

        $book->author()->sync($ids);
        
        return redirect()->route('books.index')->with('success','Book updated');
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Author  $author
    //  * @return \Illuminate\Http\Response
    //  */
    public function destroy(Book $book)
    {
        $userRole = DB::table('role_permission')
        ->join('user_role', 'user_role.role_id', '=', 'role_permission.role_id')
        ->where('user_role.user_id', Auth::user()->id)
        ->where('role_permission.permission_id', 5)
        ->first();

        if($userRole) {
            $book->delete();
            return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully');
        } else {
            return redirect()->route('books.index')
            ->with('danger', 'Book deleted failed');
        }
        

        
    }
}
