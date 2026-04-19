<?php get_header(); ?>

<!-- SEÇÃO HERO -->
<section id="hero" class="min-h-[70vh] flex items-center px-10 pt-20">
    <div class="container mx-auto grid lg:grid-cols-2 gap-16 items-center">
        <div class="space-y-8 hero-content">
            <h1 class="text-text-primary text-6xl md:text-7xl font-bold font-sans leading-[1.1] tracking-tighter">
                Engenharia <br/> Conectada ao <br/>
                <span class="text-electric-blue">Amanhã</span>.
            </h1>
            
            <p class="text-text-secondary text-lg leading-relaxed max-w-md">
                Soluções integradas em infraestrutura física e digital com foco em Segurança do Trabalho e Eficiência Energética.
            </p>
            
            <div class="flex flex-wrap items-center gap-4 pt-4">
                <a href="#contato" class="btn-primary">Solicitar Consultoria</a>
                <a href="#portfolio" class="btn-secondary">Ver Portfólio</a>
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-4 services-grid">
            <div class="service-card">
                <span class="font-mono text-electric-blue text-[11px] mb-2 block uppercase tracking-widest">[NR-10]</span>
                <h3 class="text-text-primary text-base font-bold mb-2">Engenharia Elétrica</h3>
                <p class="text-text-secondary text-[13px] leading-relaxed">Projetos de alta complexidade e laudos técnicos especializados.</p>
            </div>
            <div class="service-card">
                <span class="font-mono text-electric-blue text-[11px] mb-2 block uppercase tracking-widest">[NR-23]</span>
                <h3 class="text-text-primary text-base font-bold mb-2">Prevenção de Incêndio</h3>
                <p class="text-text-secondary text-[13px] leading-relaxed">Sistemas de detecção e combate conforme normas internacionais.</p>
            </div>
            <div class="service-card">
                <span class="font-mono text-electric-blue text-[11px] mb-2 block uppercase tracking-widest">[EFIC]</span>
                <h3 class="text-text-primary text-base font-bold mb-2">Eficiência Energética</h3>
                <p class="text-text-secondary text-[13px] leading-relaxed">Otimização de consumo e redução de custos operacionais reais.</p>
            </div>
            <div class="service-card">
                <span class="font-mono text-electric-blue text-[11px] mb-2 block uppercase tracking-widest">[ICT]</span>
                <h3 class="text-text-primary text-base font-bold mb-2">Infraestrutura de TI</h3>
                <p class="text-text-secondary text-[13px] leading-relaxed">Cabeamento estruturado e redes de alta disponibilidade.</p>
            </div>
        </div>
    </div>
</section>

<!-- SEÇÃO STATS BAR -->
<section id="stats" class="h-32 bg-slate-surface border-t border-border-color flex items-center px-10">
    <div class="container mx-auto flex justify-around items-center">
        <div class="text-center group">
            <div class="font-mono text-4xl text-electric-blue font-bold tracking-tight">+15</div>
            <div class="text-[11px] uppercase tracking-widest text-text-secondary mt-1 group-hover:text-text-primary transition-colors">Anos de Mercado</div>
        </div>
        <div class="text-center group">
            <div class="font-mono text-4xl text-electric-blue font-bold tracking-tight">+500</div>
            <div class="text-[11px] uppercase tracking-widest text-text-secondary mt-1 group-hover:text-text-primary transition-colors">Clientes Ativos</div>
        </div>
        <div class="text-center group">
            <div class="font-mono text-4xl text-electric-blue font-bold tracking-tight">24/7</div>
            <div class="text-[11px] uppercase tracking-widest text-text-secondary mt-1 group-hover:text-text-primary transition-colors">Suporte Técnico</div>
        </div>
        <div class="text-center group">
            <div class="font-mono text-4xl text-electric-blue font-bold tracking-tight">ISO 9001</div>
            <div class="text-[11px] uppercase tracking-widest text-text-secondary mt-1 group-hover:text-text-primary transition-colors">Qualidade Certificada</div>
        </div>
    </div>
</section>

<section id="servicos" class="bg-slate-dark py-32 relative overflow-hidden px-10 border-t border-border-color">
    <div class="container mx-auto">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="service-card group">
                <span class="font-mono text-electric-blue text-[11px] mb-2 block uppercase tracking-widest">[SEC]</span>
                <h3 class="text-text-primary text-base font-bold mb-2">Segurança Eletrônica (CFTV)</h3>
                <p class="text-text-secondary text-[13px] leading-relaxed">Monitoramento inteligente e controle de acesso biométrico.</p>
            </div>
            <div class="service-card group">
                <span class="font-mono text-electric-blue text-[11px] mb-2 block uppercase tracking-widest">[ICMS]</span>
                <h3 class="text-text-primary text-base font-bold mb-2">Recuperação de ICMS</h3>
                <p class="text-text-secondary text-[13px] leading-relaxed">Engenharia tributária focada em lucro operacional através da recuperação de créditos.</p>
            </div>
             <div class="service-card flex flex-col justify-center items-center text-center group cursor-pointer border-dashed">
                <div class="flex items-center gap-2 group-hover:text-electric-blue transition-colors">
                    <span class="font-bold text-sm uppercase tracking-widest">Ver Todos os Serviços</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transform transition-transform group-hover:translate-x-1"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SEÇÃO SOBRE -->
<section id="sobre" class="py-32 bg-slate-dark border-t border-border-color px-10">
    <div class="container mx-auto px-6 grid md:grid-cols-2 gap-24 items-center">
        <div class="space-y-8">
            <span class="text-electric-blue font-mono text-xs font-bold uppercase tracking-[0.3em]">Quality Assurance / SST</span>
            <h2 class="text-white text-4xl md:text-5xl font-bold leading-[1.1] tracking-tighter">Onde Segurança e Tecnologia se Fundem.</h2>
            <div class="space-y-6 text-text-secondary text-lg leading-relaxed">
                <p>A C&M Global Services nasceu da necessidade crítica do mercado industrial por parceiros que compreendam tanto a complexidade da <strong>Segurança e Saúde no Trabalho (SST)</strong> quanto a urgência da modernização digital.</p>
                <p>Nossa abordagem é <strong>360 graus</strong>: tratamos a infraestrutura física como o alicerce onde a produtividade digital é construída, sempre com foco em continuidade operacional e risco zero.</p>
            </div>
            
            <div class="grid grid-cols-2 gap-4 pt-8">
                <div class="p-6 bg-slate-surface border border-border-color rounded-sm flex items-center gap-4 group hover:border-electric-blue transition-colors duration-500">
                    <div class="w-10 h-10 bg-electric-blue/10 rounded-sm flex items-center justify-center text-electric-blue group-hover:bg-electric-blue group-hover:text-slate-dark transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <span class="text-text-primary font-bold text-sm tracking-tight leading-none uppercase">SST <br/> Expert Center</span>
                </div>
                <div class="p-6 bg-slate-surface border border-border-color rounded-sm flex items-center gap-4 group hover:border-electric-blue transition-colors duration-500">
                    <div class="w-10 h-10 bg-electric-blue/10 rounded-sm flex items-center justify-center text-electric-blue group-hover:bg-electric-blue group-hover:text-slate-dark transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                    </div>
                    <span class="text-text-primary font-bold text-sm tracking-tight leading-none uppercase">Physical-Digital <br/> Integration</span>
                </div>
            </div>
        </div>
        
        <div class="relative group">
            <div class="aspect-square bg-slate-800 rounded-3xl overflow-hidden border border-slate-700 relative shadow-2xl skew-y-3 group-hover:skew-y-0 transition-transform duration-700">
                 <img src="https://picsum.photos/seed/engineer/1200/1200" alt="C&M Global Engineering" class="object-cover w-full h-full opacity-40 grayscale group-hover:grayscale-0 transition-all duration-700 hover:scale-105" referrerpolicy="no-referrer" />
                 <div class="absolute inset-0 bg-gradient-to-tr from-slate-950 via-transparent to-electric-blue/20"></div>
                 
                 <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[80%] aspect-square border border-dashed border-white/10 rounded-full animate-[spin_20s_linear_infinite]"></div>
            </div>
        </div>
    </div>
</section>

<!-- SEÇÃO CONTATO: Call to Action -->
<section id="contato" class="py-24 bg-slate-dark px-10 border-t border-border-color">
    <div class="container mx-auto px-6">
        <div class="bg-slate-surface border border-border-color p-12 md:p-24 rounded-sm shadow-2xl relative overflow-hidden group">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-electric-blue/5 blur-[120px] rounded-full transition-colors group-hover:bg-electric-blue/10"></div>
            
            <div class="relative z-10 grid lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-6">
                    <h2 class="text-text-primary text-5xl font-bold tracking-tighter leading-tight">Pronto para <br/> a Evolução?</h2>
                    <p class="text-text-secondary text-lg max-w-md leading-relaxed">Inicie sua jornada de eficiência energética e segurança normativa com quem entende do chão de fábrica ao servidor central.</p>
                    <div class="space-y-2 pt-4">
                        <p class="text-text-primary font-bold text-xl uppercase tracking-tighter">comercial@cmglobalservices.com.br</p>
                        <p class="text-electric-blue font-mono font-bold text-xs uppercase tracking-widest">Av. das Nações, 1200 - São Paulo, SP</p>
                    </div>
                </div>
                
                <div class="flex flex-col gap-4">
                    <a href="mailto:comercial@cmglobalservices.com.br" class="btn-primary w-full py-6 flex items-center justify-center gap-4 text-xl group/btn">
                        FALE COM UM ESPECIALISTA
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transform transition-transform group-hover/btn:translate-x-2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                    <p class="text-center text-text-secondary text-[11px] font-mono font-bold uppercase tracking-widest">Tempo de resposta médio: <span class="text-electric-blue">45 min</span></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
