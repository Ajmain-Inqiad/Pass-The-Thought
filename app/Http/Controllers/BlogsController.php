<?php

namespace App\Http\Controllers;
use App\Blog;
use App\Category;
use Illuminate\Http\Request;
use Session;
use App\User;
use App\Mail\BlogPublished;
use Illuminate\Support\Facades\Mail;

class BlogsController extends Controller
{
    public function __construct(){
        $this->middleware('author', ['only' => ['create', 'store', 'edit', 'update']]);
        $this->middleware('admin', ['only' => ['delete', 'trash', 'restore', 'permanentDelete']]);
    }
    // public function index(){
    //     //$blogs = Blog::latest()->get();
    //     $blogs = Blog::where('status', 1)->latest()->paginate(1);
    //     return view('blogs.index', compact('blogs'));
    // }
    public function index(Request $request){
        //if($blogs = Blog::where('status', 1)->latest()->paginate(1)){
            $blogs = Blog::where(function($query) use ($request){
                if($term = $request->get('term')){
                    $query->orWhere('title', 'like', '%' . $term . '%');
                }
            })->where('status', 1)->latest()->paginate(2);
            return view('blogs.index', compact('blogs'));
        //}
    }
    public function create(){
        $categories = Category::latest()->get();
        return view('blogs.create', compact('categories'));
    }
    public function store(Request $request){
        $rules = [
            'title' => ['required', 'min:20', 'max:160'],
            'body' => ['required', 'min:200'],
        ];
        $this->validate($request, $rules);
        $input = $request->all();

        //meta Info
        $input['slug'] = str_slug($request->title);
        $input['meta_title'] = str_limit($request->title, 55);
        $input['meta_description'] = str_limit($request->body, 155);
        //image upload
        if($file = $request->file('featured_image')){
            $name = uniqid() . $file->getClientOriginalName();
            $name = strtolower(str_replace(' ', '-', $name));
            $file->move('images/featured_image/', $name);
            $input['featured_image'] = $name;
        }
        //$blog = Blog::create($input);
        $blogByUser = $request->user()->blogs()->create($input);

        //==============1 way to save in database=============
        // $blog = new Blog();
        // $blog->title = $request->title;
        // $blog->body = $request->body;
        // $blog->save();

        //sync with category
        if($request->category_id){
            $blogByUser->category()->sync($request->category_id);
        }
        $users = User::all();
        foreach ($users as $user) {
            Mail::to($user->email)->queue(new BlogPublished($blogByUser, $user));
        }
        Session::flash('blog_created_message', 'Congratulations on creating a blog');

        return redirect('/blogs');
    }
    public function show($slug){
        //$blog = Blog::findOrFail($slug);
        $blog = Blog::whereSlug($slug)->first();
        return view('blogs.show', compact('blog'));
    }
    public function edit($id){
        $blog = Blog::findOrFail($id);
        $categories = Category::latest()->get();
        $bc = array();
        foreach ($blog->category as $c) {
            $bc[] = $c->id;
        }
        $filtered = array_except($categories, $bc);
        //return view('blogs.edit', compact('blog'));
        return view('blogs.edit', ['blog' => $blog, 'categories' => $categories, 'filtered' => $filtered]);
    }
    public function update(Request $request, $id){
        $input = $request->all();
        $blog = Blog::findOrFail($id);
        if($file = $request->file['featured_image']){
            if($blog['featured_image']){
                unlink('/images/featured_image/'.$blog->featured_image);
            }
            $name = uniqid() . $file->getClientOriginalName();
            $name = strtolower(str_replace(' ', '-', $name));
            $file->move('images/featured_image/', $name);
            $input['featured_image'] = $name;
        }
        if($request->category_id){
            $blog->category()->sync($request->category_id);
        }
        $blog->update($input);
        return redirect('blogs');
    }
    public function delete($id){
        $blog = Blog::findOrFail($id);
        $blog->delete($id);
        return redirect('blogs');
    }
    public function trash(){
        $trashedBlogs = Blog::onlyTrashed()->get();
        return view('blogs.trash', compact('trashedBlogs'));
    }
    public function restore($id){
        $restoreBlog = Blog::onlyTrashed()->findOrFail($id);
        $restoreBlog->restore($restoreBlog);
        return redirect('blogs');
    }
    public function permanentDelete($id){
        $permanentDeleteBlog = Blog::onlyTrashed()->findOrFail($id);
        $permanentDeleteBlog->forceDelete($permanentDeleteBlog);
        return redirect('blogs');
    }
}
