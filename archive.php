<?php get_header(); ?>
<div id="content">
  <div class="row flex">
    <article>
      <div class="blocks-items">
        <?php if ( have_posts() ) : $pnCount=1; while ( have_posts() ) : the_post(); ?>
          <div class="block-item <?php if ($pnCount == 1) {echo "big-post";} ?>">
            <?php if ($pnCount == 1) { ?>
              <a href="<?php the_permalink(); ?>" class="thumb-post" style="background-image: url(<?php the_post_thumbnail_url('big-photo'); ?>)"></a>
              <?php $pnCount--; } else { ?>
              <a href="<?php the_permalink(); ?>" class="thumb-post" style="background-image: url(<?php the_post_thumbnail_url('small-photo'); ?>)"></a>
            <?php } ?>
            <div class="dec-post">
              <div class="title-date">
                <a href="<?php the_permalink(); ?>"><h3><?php echo wp_trim_words( get_the_title(), 8, '...' ); ?></h3></a>
                <span><?php the_date() ?></span>
              </div>
              <p><?php echo wp_trim_words( get_the_content(), 45, '...' ); ?></p>
              <a href="<?php the_permalink(); ?>" class="read-more">Read More ></a>
            </div>
          </div>
        <?php endwhile; endif; ?>
      </div>
    </article>
    <?php get_sidebar(); ?>
  </div>
</div>
<?php get_footer(); ?>

