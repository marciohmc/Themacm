<?php
/**
 * Fallback Principal: C&M Global Services
 * Arquiteto de Software: Marcio
 */

get_header(); ?>

<section class="py-32 bg-gray-50">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl md:text-5xl font-display text-slate-dark mb-12">Blog & Notícias <span class="text-electric-blue">Setoriais</span></h1>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-12">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <article class="glass-card hover:border-electric-blue transition-all group overflow-hidden">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="aspect-video mb-6 overflow-hidden rounded-xl">
                            <?php the_post_thumbnail( 'large', array( 'class' => 'object-cover w-full h-full transform transition-transform group-hover:scale-105' ) ); ?>
                        </div>
                    <?php endif; ?>
                    
                    <span class="text-xs font-mono font-bold uppercase tracking-widest text-electric-blue mb-4 block"><?php echo get_the_date(); ?></span>
                    <h2 class="text-2xl font-display font-bold text-slate-dark mb-4 leading-tight group-hover:text-electric-blue transition-colors"><?php the_title(); ?></h2>
                    <div class="text-slate-500 text-sm leading-relaxed mb-6 line-clamp-3">
                        <?php the_excerpt(); ?>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="text-slate-dark font-bold text-sm tracking-tight inline-flex items-center gap-2 hover:text-electric-blue">
                        LER ARTIGO COMPLETO
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </article>
            <?php endwhile; else : ?>
                <p><?php _e( 'Nenhuma infraestrutura encontrada.', 'cm-global' ); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
