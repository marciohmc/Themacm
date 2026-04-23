<?php
/**
 * Template para Páginas Estáticas (Ex: Sobre, Serviços, Contato)
 * C&M Global Services v2
 */

get_header(); ?>

<main id="primary" class="site-main">
    <?php
    while ( have_posts() ) :
        the_post();
        
        $content = get_the_content();
        
        if ( !empty($content) ) :
            // LAYOUT PARA PÁGINAS COM CONTEÚDO (IA OU MANUAL)
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('section-glow min-h-screen'); ?>>
                <!-- Cabeçalho de Página Industrial -->
                <header class="pt-20 pb-12 px-6 border-b border-white/5 relative bg-[#0f172a]">
                    <div class="container mx-auto max-w-7xl">
                        <span class="text-blue-500 font-mono text-[10px] tracking-[0.3em] font-bold uppercase mb-4 block">C&M Global / Documentação</span>
                        <h1 class="text-4xl md:text-6xl font-display font-bold text-white leading-tight">
                            <?php the_title(); ?>
                        </h1>
                        <div class="w-16 h-1 bg-gradient-to-r from-blue-500 to-blue-600 mt-8 rounded-full"></div>
                    </div>
                </header>

                <div class="container mx-auto px-6 py-16 max-w-7xl">
                    <div class="entry-content prose prose-invert prose-blue max-w-none">
                        <?php the_content(); ?>
                    </div>
                </div>
            </article>
            <?php
        else :
            // LAYOUT INDUSTRIAL DEFAULT PARA PÁGINAS VAZIAS (SINCRO COM A HOME)
            ?>
            <section class="section-glow min-h-screen flex items-center py-32 px-6">
                <div class="container mx-auto max-w-5xl text-center">
                    <div class="inline-block p-1 px-3 bg-blue-500/10 border border-blue-500/20 rounded-full mb-8">
                         <span class="text-blue-400 font-mono text-[10px] tracking-widest font-bold uppercase">Módulo em Otimização</span>
                    </div>
                    <h1 class="text-5xl md:text-8xl font-display font-bold mb-10 tracking-tighter">
                        Layout <span class="bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent">Industrial</span> <br/> em Processamento.
                    </h1>
                    <p class="text-slate-400 text-lg md:text-xl leading-relaxed mb-12 max-w-2xl mx-auto">
                        Esta interface está configurada com o DNA da C&M Global. Ative o motor <strong>AI Publish</strong> no painel administrativo para injetar o conteúdo final agora.
                    </p>
                    <div class="flex flex-wrap justify-center gap-6">
                        <a href="<?php echo esc_url( home_url( '/wp-admin/admin.php?page=ai-publish-studio' ) ); ?>" class="btn-primary">Acessar IA Studio</a>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-secondary">Retornar ao Painel</a>
                    </div>
                </div>
            </section>
            <?php
        endif;
    endwhile;
    ?>
</main>

<?php get_footer(); ?>
