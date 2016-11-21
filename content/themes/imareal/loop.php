<div class="blog-main-container">
<?php if (is_page()): the_post() ?>
	<article id="page-<?php the_ID() ?>">
		<?php the_content(); ?>
	</article>
<?php else: ?>
	<?php if (have_posts()):
		while (have_posts()) : the_post() ?>
			<div class="row post-loop-block">
			<article id="article-<?php the_ID() ?>" class="article">

				<header class="article-header">
					<div class="col-md-4 blog-img">
						<?php if (has_post_thumbnail() and !is_singular()): ?>
							<div class="featured-image">
								<a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>"><?php the_post_thumbnail() ?></a>
							</div>
						<?php endif; ?>
					</div>
					<div class="col-md-5">
						<!--<h1 class="article-title"><?php if(!is_singular()): ?><a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>"><?php endif; the_title() ?><?php if(!is_singular()): ?></a><?php endif; ?></h1>-->
						<div class="article-content blog-main">
							<?php // (is_single()) ? the_content() : the_excerpt() ?>
							<div class="blog-main-title"><?php the_title() ?></div>
							<div class="blog-main-text" <?php the_content() ?></div>
						</div>


					</div>
					<div class="col-md-3">
						<div class="article-info">
							<span class="blog-more"><a href="<?php the_permalink(); ?>">Die ganze story lesen >></a></span>
							</br>
							<span class="blog-date date"><?php the_date('j, F Y') ?></span>
							<!--<span class="comments"><?php comments_popup_link(__('Leave a comment'), __('1 Comment'), __('% Comments')) ?></span>-->
						</div>
					</div>
				</header>

			</article>
		</div>

<?php endwhile; ?>
	<?php else: ?>
		<p>Nothing matches your query.</p>
	<?php  endif; ?>
<?php  endif; ?>
</div>