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
    // Rota para Atualizar Home
    register_rest_route( 'cm-global/v1', '/update-layout', array(
        'methods' => 'POST',
        'callback' => 'cm_handle_layout_update',
        'permission_callback' => '__return_true',
    ) );

    // Rota para Criar Blog Post
    register_rest_route( 'cm-global/v1', '/create-post', array(
        'methods' => 'POST',
        'callback' => 'cm_handle_create_post',
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
        return new WP_REST_Response( array( 'status' => 'success', 'message' => 'Home Page atualizada!' ), 200 );
    }
    return new WP_Error( 'no_home', 'Pagina Inicial não definida', array( 'status' => 404 ) );
}

// Callback para criar post
function cm_handle_create_post( $request ) {
    $params = $request->get_json_params();
    $content = $params['content'];
    $title = !empty($params['title']) ? $params['title'] : 'Novo Artigo Industrial - ' . date('d/m/Y');
    
    $post_id = wp_insert_post( array(
        'post_title'   => $title,
        'post_content' => $content,
        'post_status'  => 'publish',
        'post_author'  => 1,
        'post_type'    => 'post'
    ) );

    if ( is_wp_error($post_id) ) {
        return new WP_Error( 'post_fail', 'Erro ao criar post', array( 'status' => 500 ) );
    }

    return new WP_REST_Response( array( 
        'status' => 'success', 
        'message' => 'Artigo publicado!',
        'url' => get_permalink($post_id)
    ), 200 );
}

// Adicionar Menu Admin
add_action('admin_menu', function() {
    add_menu_page(
        'Huxxconect AI Studio',
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
        <h1 style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 30px;">🚀</span> Huxxconect AI Studio: Publicação Rápida
        </h1>
        <p>Crie conteúdos no Gemini e publique diretamente no seu site WordPress.</p>
        
        <div style="background: #fff; padding: 30px; border: 1px solid #ccd0d4; border-radius: 8px; max-width: 1000px; margin-top: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px;">1. O que deseja fazer?</label>
                <select id="ai-target-type" style="width: 100%; height: 40px; font-size: 14px; border-radius: 4px;">
                    <option value="home">Atualizar Página Inicial (Home)</option>
                    <option value="post">Criar Novo Artigo no Blog</option>
                </select>
            </div>

            <div id="title-wrapper" style="margin-bottom: 25px; display: none;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px;">2. Título do Artigo</label>
                <input type="text" id="ai-post-title" style="width: 100%; height: 40px;" placeholder="Ex: A Importância da Manutenção de Média Tensão">
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px;">3. Conteúdo (HTML / Tailwind)</label>
                <textarea id="ai-content-input" style="width: 100%; height: 500px; font-family: 'JetBrains Mono', monospace; font-size: 13px; line-height: 1.5; padding: 15px; border-radius: 4px; background: #f9f9f9;" placeholder="Cole o código <section> ou <article> gerado pelo Gemini aqui..."></textarea>
            </div>
            
            <div style="display: flex; align-items: center; gap: 20px;">
                <button id="publish-ai-btn" class="button button-primary button-large" style="height: 48px; padding: 0 30px; font-weight: bold; font-size: 16px;">
                    Publicar Agora
                </button>
                <span id="ai-status" style="font-weight: bold; font-size: 14px;"></span>
            </div>

            <div id="post-link-wrapper" style="margin-top: 20px; display: none;">
                <a id="view-post-link" href="#" target="_blank" class="button">Visualizar Artigo Publicado →</a>
            </div>
        </div>

        <script>
        const targetType = document.getElementById('ai-target-type');
        const titleWrapper = document.getElementById('title-wrapper');
        const status = document.getElementById('ai-status');
        const linkWrapper = document.getElementById('post-link-wrapper');
        const viewLink = document.getElementById('view-post-link');

        targetType.addEventListener('change', (e) => {
            titleWrapper.style.display = e.target.value === 'post' ? 'block' : 'none';
        });

        document.getElementById('publish-ai-btn').addEventListener('click', async () => {
            const content = document.getElementById('ai-content-input').value;
            const type = targetType.value;
            const title = document.getElementById('ai-post-title').value;

            if(!content) { alert('Erro: O conteúdo está vazio.'); return; }
            if(type === 'post' && !title) { alert('Erro: Defina um título para o post.'); return; }

            status.innerText = '⏳ Sincronizando com Huxley...';
            status.style.color = '#72777c';
            linkWrapper.style.display = 'none';

            const endpoint = type === 'home' ? 'update-layout' : 'create-post';
            
            try {
                const response = await fetch('<?php echo get_rest_url(null, 'cm-global/v1/'); ?>' + endpoint, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ 
                        content: content,
                        title: title
                    })
                });
                
                const result = await response.json();
                
                if(response.ok) {
                    status.innerText = '✅ ' + result.message;
                    status.style.color = '#46b450';
                    if(result.url) {
                        viewLink.href = result.url;
                        linkWrapper.style.display = 'block';
                    }
                } else {
                    status.innerText = '❌ Erro: ' + (result.message || 'Falha na publicação');
                    status.style.color = '#dc3232';
                }
            } catch (e) {
                status.innerText = '❌ Erro de conexão com o servidor.';
                status.style.color = '#dc3232';
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
