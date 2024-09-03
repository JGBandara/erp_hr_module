<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingProgramme extends Model
{
    use HasFactory;
    protected $table = 'hr_mst_training_programme';
    protected $fillable = ['htp_name', 'htp_category_id', 'htp_type_id','htp_is_domestic','htp_country_id','htp_institute','htp_period','htp_amount','htp_bond_required','htp_bond_value','htp_bond_period','htp_remark', 'htp_status'];
}
