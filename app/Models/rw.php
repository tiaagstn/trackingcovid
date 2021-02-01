<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB ;


class rw extends Model
{
        protected $fillable = ['id_kelurahan', 'nama'];
        protected $table = "rws";
        public $timestemps = true;

    public function kelurahan(){
     return $this->belongsTo('App\Models\kelurahan', 'id_kelurahan');
    }
    public function rw(){
        return $this->hasMany('App\Models\rw', 'nama');
    }
    use HasFactory;

  }
