<article <?php post_class(); ?>>
    <header>
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php get_template_part('partials/entry-meta'); ?>
    </header>
    <div class="entry-content">
        <?php the_content(); ?>
    </div>
    <?php comments_template(); ?>
</article>
