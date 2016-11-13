<?php

namespace Chamber\Plugin\Widgets;

use Chamber\Plugin\Helper;

/**
 * @see docs
 */
class WidgetBuilder
{

	public function thumbnail( $size = 'thumbnail', $class = 'alignleft' )
	{
		?>
		<a class="widget-post-thumbnail" href="<?php the_permalink() ?>" itemprop="bookmark">
		    <?= get_the_post_thumbnail( null, $size, [ 'class' => $class, 'itemprop' => 'image' ]); ?>
		</a>
		<?php
	}
	
	public function postTitle( $class = 'widget-post-title' )
	{
		?>
		<h4 class="<?= $class; ?>" itemprop="headline"><a href="<?php the_permalink() ?>" itemprop="bookmark"><?= get_the_title(); ?></a></h4>
		<?php
	}
	
	public function dateTime()
	{
		?>
		<time class="widget-post-meta" datetime="<?= get_the_time( 'Y-m-d\TH:i:sP' ); ?>" itemprop="datePublished"><?= get_the_date(); ?></time>
		<?php
	}
	
	public function excerpt( $limit = 16 )
	{
		printf( '<p class="widget-post-summary" itemprop="description">' );
		if ( has_excerpt() ) :
		    echo get_the_excerpt();
		else :
		    echo wp_trim_words( get_the_content(), $limit, '&hellip;' );
		endif;

		echo $this->readMore();

		printf( '</p>' );
	}
	
	public function readMore()
	{
		?>
		<a class="readmore" href="<?php the_permalink() ?>" itemprop="url">Read More&nbsp;<span class="icon" m-Icon="xsmall" aria-hidden="true"><svg role="presentation" viewBox="0 0 32 32"><use xlink:href="#icon-fat-arrow"></use></svg></span></a>
		<?php
	}

}