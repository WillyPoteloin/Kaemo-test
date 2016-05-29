<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
  // Defining primary key
  protected $primaryKey = 'id';

  // Definining table name
  protected $table = 'videos';

  // Defining mass assignable field
  protected $fillable = array('title', 'date', 'realisator');

  /**
   * Indicates if the model should be timestamped.
   *
   * @var bool
   */
   public $timestamps = false;
}
