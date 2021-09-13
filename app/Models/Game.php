<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    protected $guarded = [];

//    private $publicPath = 'https://6fb9-175-107-228-222.ngrok.io/';
//    private $publicPath = config('app.ngrok');

   private $folderName ='images/games';

    public function getImageAttribute($value)
    {
        
        return config('app.ngrok').$this->folderName.'/'.$value;
    }
}
