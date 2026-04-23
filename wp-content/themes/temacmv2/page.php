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
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('section-glow'); ?>>
                <div class="container mx-auto px-6 py-20 max-w-7xl">
                    <header class="mb-16">
                        <h1 class="text-4xl md:text-6xl font-display font-bold leading-tight"><?php the_title(); ?></h1>
                        <div class="w-20 h-1 bg-blue-500 mt-6"></div>
                    </header>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </div>
            </article>
            <?php
        else :
            ?>
            <section class="section-glow py-32 px-6 text-center">
                <div class="container mx-auto max-w-4xl">
                    <span class="text-blue-500 font-mono text-sm tracking-widest font-bold uppercase mb-4 block">Engine Room</span>
                    <h1 class="text-5xl md:text-7xl font-display font-bold mb-8"><?php the_title(); ?></h1>
                    <p class="text-slate-400 text-lg md:text-xl leading-relaxed mb-12">
                        Esta interface está sendo otimizada. Use o motor <strong class="text-white">AI Publish</strong> para injetar o layout industrial agora!
                    </p>
                    <div class="flex justify-center gap-4">
                        <a href="<?php echo esc_url( home_url( '/wp-admin/admin.php?page=ai-publish-studio' ) ); ?>" class="btn-primary">Acessar Inteligência Studio</a>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-secondary">Voltar ao Radar</a>
                    </div>
                </div>
            </section>
            <?php
        endif;
    endwhile;
    ?>
</main>

<?php get_footer(); ?>
