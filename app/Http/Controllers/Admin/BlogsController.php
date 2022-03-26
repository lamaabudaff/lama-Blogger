<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogsRequest;
use App\Http\Traits\BlogTrait;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class BlogsController extends Controller
{

    use BlogTrait;

    public function __construct()
    {
//        $this->middleware('permission:create-blogs')->only(['create','store']);
    }

    public function index(Request $request){

        dd(Blog::with('categories')->get()->all());
        $blogs = Blog::paginate($request->per_page ?? 10);
        if($request->search_text){
            $blogs = Blog::search($request)->paginate($request->per_page ?? 10);
        }
        return view('admin.blogs.index',compact('blogs'));
    }
    public function show($id){
        $blog = Blog::with('categories')->find($id);
        foreach ($blog->categories as $category){
            echo $category->name."<br>";
        }
        dd($blog);
    }



    public function create(){
        $users = User::select(['name','id'])->get();
        $categories = Category::select(['name','id'])->get();
//        dd($users);
        return view('admin.blogs.create',compact('users','categories'));
    }
    public function store(BlogsRequest $request){
        $blog = Blog::create($request->all());
        $blog->categories()->attach($request->get('categories'));

//        foreach ($request->get('categories') as $category){
//            BlogCategory::create([
//                'blog_id'=>$blog->id,
//                'category_id'=>$category
//            ]);
//        }

//        return redirect()->back();
        return redirect(route('admin.blogs.index'));
    }

    public function delete($id){
//        $blog = Blog::find($id);
        try {
            $blog = Blog::withTrashed()->where('id',$id)->get()->first();
            if($blog){
                if($blog->trashed()){
                    $blog->forceDelete();
                    return response()->json(['success'=>'blog deleted successfully','type'=>'all']);
                }else{
                    $blog->delete();
                    return response()->json(['success'=>'blog deleted successfully','type'=>'soft']);
                }
            }else{
                return response()->json(['error'=>'blog not found']);
            }
        }catch (\Throwable $exception){
            return response()->json(['error'=> "blog can't be deleted"]);
        }

    }

    public function restore($id){
        try {
            $blog = Blog::onlyTrashed()->where('id',$id)->get()->first();
            if($blog){
                $blog->restore();
                return response()->json(['success'=>'blog restored successfully']);
            }else{
                return response()->json(['error'=>'blog not found']);
            }
        }catch (\Throwable $exception){
            return response()->json(['error'=> "blog can't be restored"]);
        }

    }


    public function edit($id){
        $blog = Blog::find($id);
        return view('admin.blogs.edit',compact('blog'));
    }


    public function update($id,BlogsRequest $request){
        $blog = Blog::find($id);
//        dd($request->all());

        if($request->hasFile('image')){
            $image_name = "image-".time().".".$request->file('image')->getClientOriginalExtension(); //image-1645368708.png
            $request->file('image')->move($image_path = public_path('uploads/blogs'),$image_name);
//            $image_path = 'uploads/blogs'. $image_name;
//dd($image_path);
            $blog->update([
                'title'=>$request->title,
                'text'=>$request->text,
                'image' => "$image_path",
            ]);
        }else{
            $blog->update([
                'title'=>$request->title,
                'text'=>$request->text,
            ]);
        }

        if($blog){
            $blog->update($request->all());
        }
        return redirect(route('admin.blogs.edit',$blog->id));

    }

}
