<?php

namespace Chamber\Plugin\Controllers;

use Chamber\Plugin\Helper;
use Chamber\Models\Person;

/**
 * Class AdminController.
 */
class PersonController {

    public function showPerson($id) {
        $person = Person::find($id);

        if($person) {
            // return view
        }
        else {
            // return
            return 'ID ' . $id . ' not found.';
        }
    }
