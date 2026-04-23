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
                <?php if ( has_custom_logo() ) : ?>
                    <div class="max-h-12 w-auto">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <div class="w-10 h-10 bg-gradient-to-br from-[#3b82f6] to-[#2563eb] rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-blue-500/30">
                        CM
                    </div>
                    <div class="flex flex-col">
                        <span class="text-white font-display font-bold text-lg leading-tight tracking-tight uppercase">C&M Global</span>
                        <span class="text-[#3b82f6] font-mono text-[10px] tracking-[0.2em] font-bold uppercase">Services</span>
                    </div>
                <?php endif; ?>
            </a>

            <nav class="hidden md:flex items-center gap-10">
                <?php 
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'flex items-center gap-10',
                    'fallback_cb'    => '__return_false',
                    'items_wrap'     => '%3$s',
                    'walker'         => new CM_Walker_Nav_Menu()
                ) );
                ?>
            </nav>

            <div class="md:hidden">
                <button id="mobile-menu-toggle" class="text-white p-2 focus:outline-none">
                    <svg id="menu-icon-open" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                    <svg id="menu-icon-close" class="hidden" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
        </div>

        <!-- MOBILE MENU DRAWER (HIDDEN BY DEFAULT) -->
        <div id="mobile-menu-drawer" class="fixed inset-0 top-24 bg-[#0f172a]/95 backdrop-blur-xl z-40 transform translate-x-full transition-transform duration-500 ease-in-out md:hidden flex flex-col p-8 border-t border-white/5">
            <nav class="flex flex-col gap-6">
                <?php 
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'flex flex-col gap-6 text-xl font-display font-bold text-white',
                    'fallback_cb'    => '__return_false',
                    'items_wrap'     => '%3$s'
                ) );
                ?>
            </nav>
            <div class="mt-auto pb-12">
                <div class="w-12 h-1 bg-blue-500 mb-6"></div>
                <p class="text-slate-400 text-sm font-mono uppercase tracking-widest italic">C&M Global Services</p>
            </div>
        </div>
    </header>
    <main class="flex-grow pt-24 min-h-screen">
