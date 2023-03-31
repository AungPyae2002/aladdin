<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;


    public static function TYPES(){
       return collect([
            (object)[
                'id' => 1,
                'name' => 'Viber'
            ],
            (object)[
                'id' => 1,
                'name' => 'Messenger'
            ],
            (object)[
                'id' => 1,
                'name' => 'Cellular'
            ]
        ]);
    }

    public function getTypeNameAttribute(){
        $id = $this->type;
        return self::TYPES()->first(function($type) use($id){
            return $type->id == $id;
        })->name;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
