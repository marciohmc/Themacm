<?php
/**
 * Blog / Listagem de Artigos - C&M Global Services v2
 */

get_header(); ?>

<main id="primary" class="site-main article-feed">
    <!-- CABEÇALHO DO BLOG INDUSTRIAL -->
    <header class="section-glow pt-32 pb-20 px-6 border-b border-white/5 bg-[#0f172a]">
        <div class="container mx-auto max-w-7xl">
            <span class="text-blue-500 font-mono text-[11px] tracking-[0.4em] font-bold uppercase mb-4 block">Inteligência Industrial</span>
            <h1 class="text-5xl md:text-7xl font-display font-bold text-white tracking-tighter">
                Radar de <span class="bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent">Inovação.</span>
            </h1>
            <p class="text-slate-400 mt-6 text-lg max-w-2xl leading-relaxed">
                Insights técnicos, atualizações de infraestrutura e gestão estratégica de energia para o setor industrial.
            </p>
        </div>
    </header>

    <section class="py-24 px-6 bg-[#0f172a]">
        <div class="container mx-auto max-w-7xl">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                    <article class="group relative flex flex-col h-full card-glass p-0 overflow-hidden border-none bg-transparent">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>" class="aspect-[16/10] block overflow-hidden rounded-xl border border-white/5 mb-6">
                                <?php the_post_thumbnail( 'large', array( 'class' => 'object-cover w-full h-full grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-700 opacity-60 group-hover:opacity-100' ) ); ?>
                            </a>
                        <?php endif; ?>
                        
                        <div class="flex flex-col flex-grow">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-blue-500"><?php echo get_the_date(); ?></span>
                                <div class="w-4 h-[1px] bg-white/10"></div>
                                <span class="text-[10px] font-mono text-slate-500 uppercase"><?php the_author(); ?></span>
                            </div>
                            
                            <h2 class="text-2xl font-display font-bold text-white mb-4 leading-snug group-hover:text-blue-400 transition-colors">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            
                            <div class="text-slate-400 text-sm leading-relaxed mb-8 line-clamp-3">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <div class="mt-auto pt-6 border-t border-white/5">
                                <a href="<?php the_permalink(); ?>" class="text-white font-bold text-[11px] uppercase tracking-widest inline-flex items-center gap-2 hover:text-blue-500 transition-colors">
                                    Explorar Artigo
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; else : ?>
                    <div class="col-span-full py-20 text-center card-glass">
                        <p class="text-slate-400 text-lg"><?php _e( 'Nenhuma publicação encontrada no momento.', 'temacmv2' ); ?></p>
                        <a href="<?php echo home_url(); ?>" class="btn-primary mt-8">Voltar para a Base</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Paginação -->
            <div class="mt-20 flex justify-center">
                <?php the_posts_pagination( array(
                    'prev_text' => '<span class="px-4 py-2 bg-white/5 rounded-md hover:bg-white/10 transition-all">Anterior</span>',
                    'next_text' => '<span class="px-4 py-2 bg-white/5 rounded-md hover:bg-white/10 transition-all">Próximo</span>',
                ) ); ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
