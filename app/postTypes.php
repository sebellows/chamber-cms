<?php

/** @var  \PostTypes\PostType */

function chamber_posttypes()
{
	$cpt = [];

	$cpt = new \Chamber\PostTypes\Attraction;
	$cpt = new \Chamber\PostTypes\Business;
	$cpt = new \Chamber\PostTypes\Person;
	$cpt = new \Chamber\PostTypes\Project;
	$cpt = new \Chamber\PostTypes\Testimonial;

	return $cpt;
}

chamber_posttypes();
