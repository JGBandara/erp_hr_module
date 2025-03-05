<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;
    protected $table = 'hr_mst_document_type';
    protected $fillable = [
        'type',
        'remark',
        'active',
        'created_by',
        'is_deleted',
        'deleted_by',
    ];

}
