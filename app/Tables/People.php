<?php

namespace Chamber\Tables;

use Illuminate\Database\Schema\Blueprint;

class People
{

	/**
	 * Activates the table.
	 */
	public function activate(Blueprint $table)
	{
	    $table->increments('id');
	    $table->string('first_name');
	    $table->string('middle_initial');
	    $table->string('last_name');
	    $table->string('job_title');
	    $table->string('department');
	    $table->string('telephone');
	    $table->string('email');
	    $table->string('profile_image');
	    $table->timestamps();
	};

	/**
	 * Deactivates the table.
	 *
	 * @param \Illuminate\Database\Schema\Blueprint $table
	 */
	public function deactivate(Blueprint $table)
	{
	    //
	}
	/**
	 * Deletes the table.
	 *
	 * @param \Illuminate\Database\Schema\Blueprint $table
	 */
	public function delete(Blueprint $table)
	{
	    $table->dropIfExists();
	}
}