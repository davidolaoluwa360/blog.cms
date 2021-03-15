<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ["title", "description", "content", "image", "published_at"];

    protected $dates = ["deleted_at", "published_at"];

    public static function deleteImage($path){
        Storage::delete($path);
    }

    public function categories(){
        return $this->belongsToMany(Category::class, "post_category", "post_id", "category_id")->withTimestamps();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, "post_tag", "post_id", "tag_id")->withTimestamps();
    }

    public function hasTag($tag_id){
        return in_array($tag_id, $this->tags->pluck("id")->toArray());
    }
}
