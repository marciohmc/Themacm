<?php
/**
 * C&M Global Services Functions and Definitions
 * Arquiteto de Software: Marcio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function cm_global_theme_setup() {
    // Suporte a Imagens de Destaque
    add_theme_support( 'post-thumbnails' );
    
    // Suporte a Título Dinâmico do Documento
    add_theme_support( 'title-tag' );

    // Registro de Menus Dinâmicos
    register_nav_menus( array(
        'primary' => __( 'Menu Principal', 'cm-global' ),
        'footer'  => __( 'Menu Rodapé', 'cm-global' ),
    ) );
}
add_action( 'after_setup_theme', 'cm_global_theme_setup' );

function cm_global_enqueue_scripts() {
    // Fontes: Inter e Space Grotesk via Google Fonts
    wp_enqueue_style( 'cm-global-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@500;600;700&display=swap', array(), null );

    // Theme Stylesheet Fallback
    wp_enqueue_style( 'cm-global-style', get_stylesheet_uri(), array(), '1.0.0' );

    // Tailwind CSS Play CDN (Uso em desenvolvimento/prototipação no WP)
    // Para produção HostGator, recomenda-se compilar via PostCSS/Vite.
    wp_enqueue_script( 'tailwind-cdn', 'https://cdn.tailwindcss.com', array(), null, false );

    // Injeção da Configuração Industrial do Tailwind
    add_action( 'wp_head', function() {
        ?>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'slate-dark': '#0a0e14',
                            'slate-surface': '#141b24',
                            'electric-blue': '#00a3ff',
                            'text-primary': '#f8fafc',
                            'text-secondary': '#94a3b8',
                            'border-color': '#1e293b',
                        },
                        fontFamily: {
                            'sans': ['Inter', 'sans-serif'],
                            'mono': ['JetBrains Mono', 'monospace'],
                        }
                    }
                }
            }
        </script>
        <style type="text/tailwindcss">
            @layer base {
                body { @apply font-sans antialiased text-text-primary bg-slate-dark; }
            }
            @layer components {
                .btn-primary { @apply px-7 py-3.5 bg-electric-blue text-slate-dark rounded-md font-semibold transition-all hover:brightness-110 active:scale-95; }
                .btn-secondary { @apply px-7 py-3.5 border border-border-color text-text-primary rounded-md font-semibold transition-all hover:bg-white/5 active:scale-95; }
                .service-card { @apply bg-slate-surface border border-border-color rounded-xl p-6 transition-all hover:border-electric-blue/50; }
            }
        </style>
        <?php
    }, 1 );
}
add_action( 'wp_enqueue_scripts', 'cm_global_enqueue_scripts' );

// Remover excessos do WordPress Head para performance
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
