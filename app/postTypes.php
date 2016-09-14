<?php

/** @var  \PostTypes\PostType */

function chamber_posttypes()
{
	$cpt = [];

	$cpt = new \Chamber\PostTypes\Attraction;
	$cpt = new \Chamber\PostTypes\Person;
	// $cpt = new \Chamber\PostTypes\Project;

	return $cpt;
}

chamber_posttypes();
