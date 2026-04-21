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
                html, body { 
                    @apply bg-[#0a0e14] text-[#f8fafc] font-sans antialiased;
                    background-color: #0a0e14 !important;
                    color: #f8fafc !important;
                }
            }
            @layer components {
                .btn-primary { @apply px-7 py-3.5 bg-[#00a3ff] text-[#0a0e14] rounded-sm font-bold transition-all hover:brightness-110 active:scale-95; }
                .btn-secondary { @apply px-7 py-3.5 border border-[#1e293b] text-[#f8fafc] rounded-sm font-bold transition-all hover:bg-white/5 active:scale-95; }
                .service-card { @apply bg-[#141b24] border border-[#1e293b] rounded-sm p-6 transition-all hover:border-[#00a3ff]/50; }
                
                /* Fallbacks de cor diretos */
                .text-text-primary { color: #f8fafc !important; }
                .text-text-secondary { color: #94a3b8 !important; }
                .text-electric-blue { color: #00a3ff !important; }
                .bg-slate-dark { background-color: #0a0e14 !important; }
                .bg-slate-surface { background-color: #141b24 !important; }
                .border-border-color { border-color: #1e293b !important; }
            }
        </style>
        <?php
    }, 1 );
}
add_action( 'wp_enqueue_scripts', 'cm_global_v2_enqueue_scripts' );


// Rota de Publicação Rápida via AI Studio
add_action( 'rest_api_init', function () {
    register_rest_route( 'cm-global/v1', '/update-layout', array(
        'methods' => 'POST',
        'callback' => 'cm_handle_layout_update',
        'permission_callback' => '__return_true', // Recomendo proteger isso com um Token depois
    ) );
} );


// Interface de Comando AI no Admin
add_action('admin_menu', function() {
    add_menu_page(
        'AI Studio Publish',
        'AI Publish',
        'manage_options',
        'ai-publish-studio',
        'cm_ai_publish_page',
        'dashicons-superhero',
        2
    );
});


function cm_handle_layout_update( $request ) {
    $params = $request->get_json_params();
    $content = $params['content'];
    $home_id = get_option( 'page_on_front' );
    if ( $home_id ) {
        wp_update_post( array('ID' => $home_id, 'post_content' => $content) );
        return new WP_REST_Response( array( 'status' => 'success', 'message' => 'Layout atualizado!' ), 200 );
    }
    return new WP_Error( 'no_home', 'Erro', array( 'status' => 404 ) );
}

// Forçar criação do Endpoint do WPGetAPI
add_action('admin_init', function() {
    $opt = 'wpgetapi_endpoints';
    $endpoints = get_option($opt, array());
    if (!isset($endpoints['google_gemini']) || empty($endpoints['google_gemini'])) {
        $endpoints['google_gemini'] = array(array(
            'id' => 'gerar_conteudo',
            'endpoint' => 'models/gemini-1.5-flash:generateContent',
            'method' => 'POST',
            'results_format' => 'json',
            'timeout' => '30',
            'headers' => array(array('key' => 'Content-Type', 'value' => 'application/json')),
            'body' => '{"contents":[{"parts":[{"text":"Teste"}]}]}'
        ));
        update_option($opt, $endpoints);
    }
});
    ?>
    <div class="wrap">
        <h1>🚀 AI Studio: Publicação Rápida</h1>
        <p>Use esta interface para integrar o Gemini e atualizar seu layout instantaneamente.</p>
        
        <div style="background: #fff; padding: 20px; border: 1px solid #ccd0d4; border-radius: 4px;">
            <h3>Passo 1: Gere o Layout no Gemini</h3>
            <p>Copie e cole este prompt no seu Gemini (ou use o WPGetAPI configurado):</p>
            <code>"Gere um layout HTML usando classes do Tailwind CSS para a home page da C&M Global Services. Foque em estética Sophisticated Dark. Retorne apenas o código dentro de tags section."</code>
            
            <hr>
            
            <h3>Passo 2: Publicar Conteúdo</h3>
            <textarea id="ai-content-input" style="width: 100%; height: 200px; font-family: monospace;" placeholder="Cole o código HTML/Tailwind gerado aqui..."></textarea>
            <br><br>
            <button id="publish-ai-btn" class="button button-primary button-large">Publicar Agora no Site</button>
            <span id="ai-status" style="margin-left: 15px; font-weight: bold;"></span>
        </div>

        <script>
        document.getElementById('publish-ai-btn').addEventListener('click', async () => {
            const content = document.getElementById('ai-content-input').value;
            const status = document.getElementById('ai-status');
            
            if(!content) {
                alert('Cole o conteúdo primeiro!');
                return;
            }

            status.innerText = '⏳ Publicando...';
            
            try {
                const response = await fetch('<?php echo get_rest_url(null, 'cm-global/v1/update-layout'); ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ content: content })
                });
                const result = await response.json();
                status.innerText = '✅ ' + result.message;
            } catch (e) {
                status.innerText = '❌ Erro ao publicar.';
            }
        });
        </script>
    </div>
    <?php
}
