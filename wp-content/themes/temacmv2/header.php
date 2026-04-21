<!DOCTYPE html>
<html <?php language_attributes(); ?> class="h-full">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <style>
        :root {
            --slate-dark: #0f172a;
            --electric-blue: #3b82f6;
        }
        body { background-color: #0f172a !important; }
    </style>
</head>
<body <?php body_class( 'bg-[#0f172a]' ); ?>>
    <header id="site-header" class="fixed top-0 left-0 w-full z-50 h-24 flex items-center bg-[#0f172a]/80 backdrop-blur-md border-b border-white/5 transition-all duration-300">
        <div class="container mx-auto px-6 md:px-12 flex items-center justify-between">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-[#3b82f6] to-[#2563eb] rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-blue-500/30">
                    CM
                </div>
                <div class="flex flex-col">
                    <span class="text-white font-display font-bold text-lg leading-tight tracking-tight uppercase">C&M Global</span>
                    <span class="text-[#3b82f6] font-mono text-[10px] tracking-[0.2em] font-bold uppercase">Services</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-10">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-[#3b82f6] font-display font-medium text-sm tracking-wide">Início</a>
                <a href="#servicos" class="text-slate-400 hover:text-white font-display font-medium text-sm tracking-wide transition-colors">Serviços</a>
                <a href="#diferenciais" class="text-slate-400 hover:text-white font-display font-medium text-sm tracking-wide transition-colors">Diferenciais</a>
                <a href="#sobre" class="text-slate-400 hover:text-white font-display font-medium text-sm tracking-wide transition-colors">Sobre Nós</a>
                <a href="#contato" class="px-5 py-2 bg-white/5 border border-white/10 text-white rounded-full font-display font-medium text-sm hover:bg-white/10 transition-all">Contato</a>
            </nav>

            <div class="md:hidden">
                <button id="mobile-menu-toggle" class="text-text-primary p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
            </div>
        </div>
    </header>
    <main class="flex-grow pt-24 min-h-screen">
