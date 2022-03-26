<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['title','text','image','author_id'];

    public function author(){
        return $this->belongsTo(User::class,'author_id');
    }

    public function scopeActive($query){
        return $query->where('active','1');
    }

    public function scopeSearch($query,$request){
        return $query->where(function ($query) use ($request){
            $query->where('title','LIKE',"%".$request->search_text."%");
            $query->where('text','LIKE',"%".$request->search_text."%");
            $query->orWhereHas('author',function ($q) use ($request){
                $q->where('name','Like','%'.$request->search_text."%");
            });
        });
    }

    public function categories(){
        return $this->belongsToMany(Category::class,'blog_categories','blog_id','category_id');
    }
}
