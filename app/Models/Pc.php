<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pc extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['processor'];
    // protected $appends = ['count_comments'];

    private $publicPath = ' https://6fb9-175-107-228-222.ngrok.io/';
    private $folderName ='images/pc';
 
     public function getImageAttribute($value)
     {
         
         return config('app.ngrok').$this->folderName.'/'.$value;
     }

    public function processors()
    {
      return  $this->hasMany(Processor::class);
    }

    public function getPcTypeAttribute($value)
    {


      // dd($this);
      if($value== 1)
      {
        return 'TYPE_GAMING_PC';
      }elseif($value== 2)
      {
        
        return 'TYPE_LEGACY_PC';

      }else{
        return 'TYPE_WORKSTATION_PC';

      }
      return 5;
    }
}
