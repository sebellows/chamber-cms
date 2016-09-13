<?php

namespace Chamber\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Oni\Framework\Models\SoftDeletes\SoftDeletes;

/**
 * Person information
 */
class Person extends Model
{

	use SoftDeletes;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'chamber_people';

    protected $fillable = [
	    'first_name',
	    'middle_initial',
	    'last_name',
	    'job_title',
	    'department',
	    'telephone',
	    'email',
	    'profile_image'
    ];

    public function profile()
    {
    	$attrs = collect($fillable);

    	$attrs->map(function($attr) {
    		return get_field('person_' . $attr);
    	});
    }
}
