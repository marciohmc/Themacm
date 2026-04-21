<?php get_header(); ?>

<main id="primary" class="site-main">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            the_content();
        endwhile;
    else :
        // Fallback caso não haja conteúdo no banco de dados ainda
        ?>
        <!-- SEÇÃO HERO (DIRETO NO CÓDIGO COMO BACKUP) -->
        <section id="hero" class="min-h-[70vh] flex items-center px-10 pt-20">
            <div class="container mx-auto grid lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-8 hero-content">
                    <h1 class="text-text-primary text-6xl md:text-7xl font-bold font-sans leading-[1.1] tracking-tighter">
                        Engenharia <br/> Conectada ao <br/>
                        <span class="text-electric-blue">Amanhã</span>.
                    </h1>
                    <p class="text-text-secondary text-lg leading-relaxed max-w-md">
                        Soluções integradas em infraestrutura física e digital.
                    </p>
                    <div class="flex flex-wrap items-center gap-4 pt-4">
                        <a href="#contato" class="btn-primary">Solicitar Consultoria</a>
                    </div>
                </div>
            </div>
        </section>
        <?php
    endif;
    ?>
</main>

<?php get_footer(); ?>

<?php get_footer(); ?>
