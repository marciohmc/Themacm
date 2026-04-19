<!DOCTYPE html>
<html <?php language_attributes(); ?> class="h-full">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <style>
        /* Immediate Fix for Theme Colors */
        :root {
            --slate-dark: #0a0e14;
            --electric-blue: #00a3ff;
            --text-primary: #f8fafc;
        }
        body, html {
            background-color: #0a0e14 !important;
            color: #f8fafc !important;
        }
        .text-text-primary { color: #f8fafc !important; }
        .text-electric-blue { color: #00a3ff !important; }
        .bg-slate-dark { background-color: #0a0e14 !important; }
    </style>
</head>
<body <?php body_class( 'h-full flex flex-col bg-[#0a0e14]' ); ?>>
    <header id="site-header" class="fixed top-0 left-0 w-full z-50 h-20 border-b border-border-color flex items-center bg-slate-dark/95 backdrop-blur transition-all duration-300">
        <div class="container mx-auto px-10 flex items-center justify-between">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3 group">
                <div class="w-8 h-8 bg-electric-blue flex items-center justify-center rounded-sm text-slate-dark font-bold text-lg">
                    CM
                </div>
                <span class="text-text-primary font-bold text-xl tracking-tighter uppercase whitespace-nowrap">C&M GLOBAL SERVICES</span>
            </a>

            <nav class="hidden md:flex items-center gap-8">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-electric-blue font-medium text-sm uppercase tracking-widest">Início</a>
                <a href="#servicos" class="text-text-secondary hover:text-text-primary font-medium text-sm uppercase tracking-widest transition-colors">Serviços</a>
                <a href="#sst" class="text-text-secondary hover:text-text-primary font-medium text-sm uppercase tracking-widest transition-colors">SST</a>
                <a href="#sobre" class="text-text-secondary hover:text-text-primary font-medium text-sm uppercase tracking-widest transition-colors">Sobre</a>
                <a href="#contato" class="text-text-secondary hover:text-text-primary font-medium text-sm uppercase tracking-widest transition-colors">Contato</a>
            </nav>

            <div class="md:hidden">
                <button id="mobile-menu-toggle" class="text-text-primary p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
            </div>
        </div>
    </header>
    <main class="flex-grow pt-24 min-h-screen">
