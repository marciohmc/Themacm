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
        
        // Verifica se a página está vazia (caso queira layout padrão) ou tem conteúdo (AI Publish)
        $content = get_the_content();
        
        if ( !empty($content) ) :
            // Exibe o conteúdo gerado pela IA ou Editor
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="entry-content px-6 py-12">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
        else :
            // Layout de Fallback caso a página não tenha conteúdo ainda
            ?>
            <section class="py-24 px-6 bg-slate-dark text-center">
                <div class="container mx-auto max-w-4xl">
                    <span class="text-electric-blue font-mono text-sm tracking-widest font-bold uppercase mb-4 block">Página em Construção</span>
                    <h1 class="text-4xl md:text-6xl font-display font-bold mb-8"><?php the_title(); ?></h1>
                    <p class="text-slate-400 text-lg leading-relaxed mb-12">
                        Esta página está sendo preparada pela nossa equipe técnica. 
                        Use o painel <strong class="text-white">AI Publish</strong> para gerar um layout exclusivo agora!
                    </p>
                    <a href="<?php echo esc_url( home_url( '/wp-admin/admin.php?page=ai-publish-studio' ) ); ?>" class="btn-primary">Acessar IA Studio</a>
                </div>
            </section>
            <?php
        endif;

    endwhile;
    ?>
</main>

<?php get_footer(); ?>
