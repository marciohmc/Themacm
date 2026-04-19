<?php
/**
 * Fallback Principal: C&M Global Services v2
 */

get_header(); ?>

<section class="py-32 bg-slate-dark px-10">
    <div class="container mx-auto">
        <h1 class="text-4xl md:text-5xl font-bold text-text-primary mb-12 tracking-tighter">Blog & Notícias <span class="text-electric-blue">Setoriais</span></h1>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <article class="service-card group overflow-hidden">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="aspect-video mb-6 overflow-hidden rounded-sm border border-border-color">
                            <?php the_post_thumbnail( 'large', array( 'class' => 'object-cover w-full h-full grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-700' ) ); ?>
                        </div>
                    <?php endif; ?>
                    
                    <span class="text-[10px] font-mono font-bold uppercase tracking-[0.2em] text-electric-blue mb-4 block"><?php echo get_the_date(); ?></span>
                    <h2 class="text-xl font-bold text-text-primary mb-4 leading-tight group-hover:text-electric-blue transition-colors"><?php the_title(); ?></h2>
                    <div class="text-text-secondary text-sm leading-relaxed mb-6 line-clamp-3">
                        <?php the_excerpt(); ?>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="text-text-primary font-bold text-[11px] uppercase tracking-widest inline-flex items-center gap-2 hover:text-electric-blue transition-colors">
                        Ler Artigo 
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </article>
            <?php endwhile; else : ?>
                <p class="text-text-secondary"><?php _e( 'Nenhuma infraestrutura encontrada.', 'temacmv2' ); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
