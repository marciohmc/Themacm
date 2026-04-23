<?php
/**
 * Template para exibição de post individual - C&M Global Services
 */

get_header(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <!-- Header do Artigo -->
    <section class="pt-40 pb-20 px-6 bg-slate-dark relative overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-blue-500/5 blur-[120px] rounded-full -z-10"></div>
        
        <div class="container mx-auto max-w-4xl">
            <div class="flex items-center gap-4 mb-8">
                <span class="text-blue-500 font-mono text-xs tracking-widest font-bold uppercase py-1 px-3 border border-blue-500/20 bg-blue-500/5 rounded">
                    <?php the_date(); ?>
                </span>
                <span class="text-slate-500 text-xs font-mono uppercase">Por: <?php the_author(); ?></span>
            </div>
            
            <h1 class="text-4xl md:text-6xl font-display font-bold leading-tight mb-8">
                <?php the_title(); ?>
            </h1>

            <?php if ( has_post_thumbnail() ) : ?>
                <div class="w-full aspect-video rounded-2xl overflow-hidden border border-white/5 shadow-2xl">
                    <?php the_post_thumbnail('full', array('class' => 'w-full h-full object-cover filter brightness-75')); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Conteúdo do Artigo -->
    <section class="pb-32 px-6 bg-slate-dark">
        <div class="container mx-auto max-w-3xl">
            <div class="prose prose-invert prose-lg max-w-none prose-slate
                prose-headings:font-display prose-headings:font-bold prose-headings:tracking-tight
                prose-a:text-blue-500 hover:prose-a:text-blue-400
                prose-img:rounded-xl prose-img:border prose-img:border-white/5
                prose-strong:text-white">
                <?php
                if ( have_posts() ) :
                    while ( have_posts() ) :
                        the_post();
                        the_content();
                    endwhile;
                endif;
                ?>
            </div>
            
            <!-- Tags e Navegação -->
            <div class="mt-20 pt-10 border-t border-white/5 flex flex-wrap gap-3">
                <?php the_tags('<span class="text-xs font-mono uppercase text-slate-500 mr-2">Tags:</span> <span class="px-3 py-1 bg-white/5 rounded text-xs text-slate-400">', '</span> <span class="px-3 py-1 bg-white/5 rounded text-xs text-slate-400">', '</span>'); ?>
            </div>

            <div class="mt-12 flex justify-between items-center bg-white/2 p-8 rounded-2xl border border-white/5">
                <div class="text-slate-400 text-sm">
                    Gostou deste artigo? Compartilhe conhecimento industrial.
                </div>
                <div class="flex gap-4">
                    <!-- Placeholder para botões de redes sociais -->
                </div>
            </div>
        </div>
    </section>
</article>

<?php get_footer(); ?>
