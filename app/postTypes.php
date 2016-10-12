<?php

/** @var  \PostTypes\PostType */

function chamber_posttypes()
{
	$cpt = [];

	$cpt = new \Chamber\Plugin\PostTypes\Attraction;
	$cpt = new \Chamber\Plugin\PostTypes\Business;
	$cpt = new \Chamber\Plugin\PostTypes\Person;
	$cpt = new \Chamber\Plugin\PostTypes\Project;
	$cpt = new \Chamber\Plugin\PostTypes\Testimonial;

	return $cpt;
}

chamber_posttypes();
