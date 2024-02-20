<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

class Credit extends Model
{
  use HasFactory;
  protected $guarded = ['id'];
  public function category()
  {
    return $this->belongsTo(Category::class);
  }
  public function source()
  {
    return $this->belongsTo(Source::class);
  }

  public function getFile(){
    if($this->file && Storage::disk('s3')->exists($this->file)){
      return Storage::disk('s3')->url($this->file);
    }else{
      return null;
    }
  }
}
