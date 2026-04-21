<?php
/**
 * C&M Global Services Functions - Sophisticated Dark v2
 * Arquiteto de Software: Marcio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Configurações Básicas do Tema
function cm_global_v2_setup() {
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    register_nav_menus( array(
        'primary' => __( 'Menu Principal', 'temacmv2' ),
        'footer'  => __( 'Menu Rodapé', 'temacmv2' ),
    ) );
}
add_action( 'after_setup_theme', 'cm_global_v2_setup' );

// Enqueue Scripts e Tailwind
function cm_global_v2_enqueue_scripts() {
    // Fontes Modernas: Space Grotesk e Inter
    wp_enqueue_style( 'cm-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Space+Grotesk:wght@500;700&display=swap', array(), null );
    wp_enqueue_script( 'tailwind-cdn', 'https://cdn.tailwindcss.com', array(), null, false );

    add_action( 'wp_head', function() {
        ?>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'slate-dark': '#0f172a',
                            'electric-blue': '#3b82f6',
                            'text-primary': '#f8fafc',
                            'text-secondary': '#94a3b8',
                            'border-color': '#1e293b',
                        },
                        fontFamily: {
                            'sans': ['Inter', 'sans-serif'],
                            'display': ['Space Grotesk', 'sans-serif'],
                        }
                    }
                }
            }
        </script>
        <style type="text/tailwindcss">
            @layer base {
                html, body { 
                    @apply bg-[#0f172a] text-[#f8fafc] font-sans antialiased;
                }
                h1, h2, h3, h4 { @apply font-display tracking-tight text-white; }
            }
            @layer components {
                .btn-primary { @apply px-8 py-4 bg-[#3b82f6] text-white rounded-md font-bold transition-all hover:bg-[#2563eb] shadow-lg shadow-blue-500/20 active:scale-95; }
                .btn-secondary { @apply px-8 py-4 border border-[#1e293b] text-white rounded-md font-bold transition-all hover:bg-white/5 active:scale-95; }
                .card-glass { @apply bg-[#1e293b]/50 backdrop-blur-sm border border-white/5 rounded-xl p-8 transition-all hover:border-[#3b82f6]/40 hover:shadow-xl hover:shadow-blue-500/5; }
            }
        </style>
        <?php
    }, 1 );
}
add_action( 'wp_enqueue_scripts', 'cm_global_v2_enqueue_scripts' );

// --- LÓGICA DE API E PUBLICAÇÃO AI ---

// Rota de REST API
add_action( 'rest_api_init', function () {
    register_rest_route( 'cm-global/v1', '/update-layout', array(
        'methods' => 'POST',
        'callback' => 'cm_handle_layout_update',
        'permission_callback' => '__return_true',
    ) );
} );

// Callback para atualizar a home
function cm_handle_layout_update( $request ) {
    $params = $request->get_json_params();
    $content = $params['content'];
    $home_id = get_option( 'page_on_front' );
    if ( $home_id ) {
        wp_update_post( array('ID' => $home_id, 'post_content' => $content) );
        return new WP_REST_Response( array( 'status' => 'success', 'message' => 'Layout atualizado!' ), 200 );
    }
    return new WP_Error( 'no_home', 'Pagina Inicial não definida', array( 'status' => 404 ) );
}

// Adicionar Menu Admin
add_action('admin_menu', function() {
    add_menu_page(
        'AI Studio Publish',
        'AI Publish',
        'manage_options',
        'ai-publish-studio',
        'cm_ai_publish_page',
        'dashicons-performance',
        2
    );
});

// Interface da Página de Publicação
function cm_ai_publish_page() {
    ?>
    <div class="wrap">
        <h1>🚀 AI Studio: Publicação Rápida</h1>
        <p>Gere o layout no Gemini e cole abaixo para atualizar sua Home Page instantaneamente.</p>
        
        <div style="background: #fff; padding: 20px; border: 1px solid #ccd0d4; border-radius: 4px;">
            <h3>Conteúdo HTML (Tailwind)</h3>
            <textarea id="ai-content-input" style="width: 100%; height: 400px; font-family: monospace;" placeholder="Cole o código <section> aqui..."></textarea>
            <br><br>
            <button id="publish-ai-btn" class="button button-primary button-large">Atualizar Home Page Agora</button>
            <span id="ai-status" style="margin-left: 15px; font-weight: bold;"></span>
        </div>

        <script>
        document.getElementById('publish-ai-btn').addEventListener('click', async () => {
            const content = document.getElementById('ai-content-input').value;
            const status = document.getElementById('ai-status');
            if(!content) { alert('Cole o conteúdo!'); return; }
            status.innerText = '⏳ Processando...';
            try {
                const response = await fetch('<?php echo get_rest_url(null, 'cm-global/v1/update-layout'); ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ content: content })
                });
                const result = await response.json();
                status.innerText = '✅ ' + (result.message || 'Sucesso!');
            } catch (e) {
                status.innerText = '❌ Erro na conexão.';
            }
        });
        </script>
    </div>
    <?php
}

// Forçar Endpoint do WPGetAPI
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
