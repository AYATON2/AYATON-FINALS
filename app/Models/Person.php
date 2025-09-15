<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    // Make sure the following attributes are mass assignable
    protected $fillable = ['name', 'age', 'bio'];
}
