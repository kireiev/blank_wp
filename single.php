<?php get_header(); ?>
<div id="content">
  <div class="row flex">
    <article>
      <div class="blocks-items">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
          <div class="block-item">
            <div class="thumb-post" style="background-image: url(<?php the_post_thumbnail_url('big-photo'); ?>)"></div>
            <div class="dec-post">
              <div class="title-date">
                <h3><?php the_title(); ?></h3>
                <span><?php the_date() ?></span>
              </div>
              <?php the_content() ?>
            </div>
          </div>
        <?php endwhile; endif; ?>
      </div>
    </article>
    <?php get_sidebar(); ?>
  </div>
</div>
<?php get_footer(); ?>

