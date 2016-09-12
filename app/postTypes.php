<?php

/** @var  \PostTypes\PostType */

function chamber_posttypes()
{
	$cpt = [];

	$cpt = new \Chamber\PostTypes\AttractionPostType;
	$cpt = new \Chamber\PostTypes\PersonPostType;
	// $cpt = new \Chamber\PostTypes\ProjectPostType;

	return $cpt;
}

chamber_posttypes();
