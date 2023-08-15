<?php
// model for task
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    // variable to set table name for this model
    protected $table = 'tbl_task';

    //variable to define list of column fields where create and update can occur.
    protected $fillable = [
        'title',
        'description',
        'status',
        'fileName'
    ];
}
