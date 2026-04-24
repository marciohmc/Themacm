<?php get_header(); ?>

<main id="primary" class="site-main">
    <?php
    // Verifica se a página tem conteúdo no editor (via AI Publish)
    $current_content = get_the_content();
    
    if ( !empty($current_content) ) :
        // Se houver conteúdo publicado via AI Publish, exibe ele
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                the_content();
            endwhile;
        endif;
    else :
        // Caso a página esteja vazia, exibe o Layout Institucional Padrão (Tech-Moderno)
        ?>
        <!-- HERO SECTION -->
        <section class="relative pt-32 pb-20 md:pt-48 md:pb-32 px-6 overflow-hidden">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[600px] bg-blue-500/10 blur-[120px] rounded-full -z-10"></div>
            <div class="container mx-auto text-center max-w-5xl">
                <h1 class="text-5xl md:text-8xl font-display font-bold leading-[1.05] tracking-tight mb-8">
                    Engenharia Conectada ao <br/>
                    <span class="bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent">Amanhã.</span>
                </h1>
                <p class="text-slate-400 text-lg md:text-xl leading-relaxed max-w-2xl mx-auto mb-10">
                    Liderando a transformação industrial através de soluções integradas em infraestrutura física e digital de alto desempenho.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="#contato" class="btn-primary w-full sm:w-auto">Solicitar Consultoria</a>
                    <a href="#servicos" class="btn-secondary w-full sm:w-auto">Ver Nossos Portfólio</a>
                </div>
            </div>
        </section>

        <!-- GRID DE SERVIÇOS -->
        <section id="servicos" class="py-24 px-6 relative">
            <div class="container mx-auto">
                <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
                    <div class="max-w-2xl">
                        <span class="text-blue-500 font-mono text-sm tracking-widest font-bold uppercase mb-4 block">Especialidades</span>
                        <h2 class="text-4xl md:text-5xl font-display font-bold">Soluções Industriais <br/> de Ponta a Ponta.</h2>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Engenharia Elétrica -->
                    <div class="card-glass group">
                        <div class="w-12 h-12 bg-blue-500/10 rounded-lg flex items-center justify-center text-blue-500 mb-6 group-hover:bg-blue-500 group-hover:text-white transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Engenharia Elétrica</h3>
                        <p class="text-slate-400 leading-relaxed mb-6 text-sm">Especialistas em conformidade NR-10 e manutenção crítica de sistemas de média e baixa tensão.</p>
                    </div>
                    <!-- Prevenção de Incêndio -->
                    <div class="card-glass group">
                        <div class="w-12 h-12 bg-blue-500/10 rounded-lg flex items-center justify-center text-blue-500 mb-6 group-hover:bg-blue-500 group-hover:text-white transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 19l4-4 4 4m0-14l-4 4-4-4"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Prevenção de Incêndio</h3>
                        <p class="text-slate-400 leading-relaxed mb-6 text-sm">Projetos rigorosos conforme NR-23 e instalação de sistemas avançados de detecção e combate.</p>
                    </div>
                    <!-- Eficiência Energética -->
                    <div class="card-glass group">
                        <div class="w-12 h-12 bg-blue-500/10 rounded-lg flex items-center justify-center text-blue-500 mb-6 group-hover:bg-blue-500 group-hover:text-white transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Eficiência Energética</h3>
                        <p class="text-slate-400 leading-relaxed mb-6 text-sm">Consultoria técnica para redução drástica de custos operacionais e sustentabilidade industrial.</p>
                    </div>
                    <!-- Infraestrutura de TI -->
                    <div class="card-glass group">
                        <div class="w-12 h-12 bg-blue-500/10 rounded-lg flex items-center justify-center text-blue-500 mb-6 group-hover:bg-blue-500 group-hover:text-white transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6" y2="6"/><line x1="6" y1="18" x2="6" y2="18"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Infraestrutura de TI</h3>
                        <p class="text-slate-400 leading-relaxed mb-6 text-sm">Cabeamento estruturado, redes lógicas e montagem de Data Centers certificados e resilientes.</p>
                    </div>
                    <!-- Segurança Eletrônica -->
                    <div class="card-glass group">
                        <div class="w-12 h-12 bg-blue-500/10 rounded-lg flex items-center justify-center text-blue-500 mb-6 group-hover:bg-blue-500 group-hover:text-white transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Segurança Eletrônica</h3>
                        <p class="text-slate-400 leading-relaxed mb-6 text-sm">Ecossistemas de monitoramento 24h, CFTV inteligente e controle de acesso biométrico.</p>
                    </div>
                    <!-- Créditos de ICMS -->
                    <div class="card-glass group">
                        <div class="w-12 h-12 bg-blue-500/10 rounded-lg flex items-center justify-center text-blue-500 mb-6 group-hover:bg-blue-500 group-hover:text-white transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Créditos de ICMS</h3>
                        <p class="text-slate-400 leading-relaxed mb-6 text-sm">Gestão tributária estratégica focada na recuperação de créditos sobre energia para indústrias.</p>
                    </div>
                </div>
            </div>
        </section>
        <?php
    endif;
    ?>
</main>

<?php get_footer(); ?>
