<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['user_id','item_id','title','description','total_amount','photo'];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }


    public function rules()
    {
        return
        [
            'item_id' => 'nullable',
            'title' => 'required',
            'description'  => 'nullable', 
            'total_amount' => 'required|numeric',
            'photo' => 'nullable|file|max:512000'
        ];
    }

    use HasFactory;
}
