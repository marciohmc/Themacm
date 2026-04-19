<?php
/**
 * C&M Global Services Functions - Sophisticated Dark v2
 * Arquiteto de Software: Marcio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function cm_global_v2_setup() {
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    register_nav_menus( array(
        'primary' => __( 'Menu Principal', 'temacmv2' ),
        'footer'  => __( 'Menu Rodapé', 'temacmv2' ),
    ) );
}
add_action( 'after_setup_theme', 'cm_global_v2_setup' );

function cm_global_v2_enqueue_scripts() {
    // Fontes Industriais: Inter e JetBrains Mono
    wp_enqueue_style( 'cm-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=JetBrains+Mono:wght@500;700&display=swap', array(), null );

    // Tailwind CSS via CDN
    wp_enqueue_script( 'tailwind-cdn', 'https://cdn.tailwindcss.com', array(), null, false );

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
                body { @apply font-sans antialiased text-text-primary bg-[#0a0e14]; }
            }
            @layer components {
                .btn-primary { @apply px-7 py-3.5 bg-[#00a3ff] text-[#0a0e14] rounded-sm font-bold transition-all hover:brightness-110 active:scale-95; }
                .btn-secondary { @apply px-7 py-3.5 border border-[#1e293b] text-[#f8fafc] rounded-sm font-bold transition-all hover:bg-white/5 active:scale-95; }
                .service-card { @apply bg-[#141b24] border border-[#1e293b] rounded-sm p-6 transition-all hover:border-[#00a3ff]/50; }
            }
        </style>
        <?php
    }, 1 );
}
add_action( 'wp_enqueue_scripts', 'cm_global_v2_enqueue_scripts' );

// Performance
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
