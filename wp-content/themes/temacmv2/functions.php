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

    // Rota para buscar Histórico (Revisões)
    register_rest_route( 'cm-global/v1', '/get-history', array(
        'methods' => 'GET',
        'callback' => 'cm_get_layout_history',
        'permission_callback' => '__return_true',
    ) );

    // Rota para Restaurar Versão
    register_rest_route( 'cm-global/v1', '/restore-version', array(
        'methods' => 'POST',
        'callback' => 'cm_restore_version',
        'permission_callback' => '__return_true',
    ) );
} );

// Callback para atualizar a home
function cm_handle_layout_update( $request ) {
    $params = $request->get_json_params();
    $content = $params['content'];
    $home_id = get_option( 'page_on_front' );
    if ( $home_id ) {
        // O wp_update_post gera automaticamente uma revisão no WP
        wp_update_post( array('ID' => $home_id, 'post_content' => $content) );
        return new WP_REST_Response( array( 'status' => 'success', 'message' => 'Home Page atualizada e Snaphot criado!' ), 200 );
    }
    return new WP_Error( 'no_home', 'Pagina Inicial não definida', array( 'status' => 404 ) );
}

// Callback para buscar histórico
function cm_get_layout_history() {
    $home_id = get_option( 'page_on_front' );
    if ( !$home_id ) return array();
    
    $revisions = wp_get_post_revisions( $home_id, array( 'posts_per_page' => 10 ) );
    $history = array();
    
    foreach ( $revisions as $rev ) {
        $history[] = array(
            'id' => $rev->ID,
            'date' => get_the_time( 'd/m H:i', $rev->ID ),
            'author' => get_the_author_meta( 'display_name', $rev->post_author )
        );
    }
    return $history;
}

// Callback para restaurar versão
function cm_restore_version( $request ) {
    $params = $request->get_json_params();
    $rev_id = $params['version_id'];
    $home_id = get_option( 'page_on_front' );
    
    $revision = wp_get_post_revision( $rev_id );
    if ( $revision ) {
        wp_update_post( array( 'ID' => $home_id, 'post_content' => $revision->post_content ) );
        return array( 'status' => 'success', 'message' => 'Versão restaurada!', 'content' => $revision->post_content );
    }
    return new WP_Error( 'fail', 'Erro ao restaurar', array( 'status' => 500 ) );
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

// Interface da Página de Publicação (Versão Pro com Preview e Histórico)
function cm_ai_publish_page() {
    ?>
    <div class="wrap">
        <h1 style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 30px;">🚀</span> Huxxconect AI Studio: Versão 2.1 Pro
        </h1>
        
        <div style="display: grid; grid-template-cols: 1fr; gap: 20px; margin-top: 20px;">
            
            <!-- COLUNA ESQUERDA: EDITOR -->
            <div style="background: #fff; padding: 25px; border: 1px solid #ccd0d4; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
                    <div style="flex: 1;">
                        <label style="display: block; font-weight: bold; margin-bottom: 8px;">1. Destino</label>
                        <select id="ai-target-type" style="width: 250px; height: 35px;">
                            <option value="home">Atualizar Página Inicial</option>
                            <option value="post">Criar Artigo Blog</option>
                        </select>
                    </div>

                    <div style="flex: 1; text-align: right;">
                         <label style="display: block; font-weight: bold; margin-bottom: 8px;">🕒 Snapshots (Restauração)</label>
                         <select id="ai-history-list" style="width: 200px; height: 35px;">
                             <option value="">Carregando histórico...</option>
                         </select>
                         <button id="restore-btn" class="button" style="display:none;">Restaurar</button>
                    </div>
                </div>

                <div id="title-wrapper" style="margin-bottom: 20px; display: none;">
                    <label style="display: block; font-weight: bold; margin-bottom: 8px;">2. Título do Post</label>
                    <input type="text" id="ai-post-title" style="width: 100%; height: 35px;" placeholder="Título dinâmico">
                </div>

                <label style="display: block; font-weight: bold; margin-bottom: 8px;">3. Código HTML / Tailwind</label>
                <textarea id="ai-content-input" style="width: 100%; height: 300px; font-family: 'JetBrains Mono', monospace; font-size: 12px; background: #fafafa; border-radius: 4px;" placeholder="Cole aqui..."></textarea>
                
                <div style="margin-top: 20px; display: flex; align-items: center; gap: 15px;">
                    <button id="publish-ai-btn" class="button button-primary button-large" style="padding: 0 40px; height: 45px; font-weight: bold;">Publicar Live</button>
                    <span id="ai-status"></span>
                </div>
            </div>

            <!-- ÁREA DE PREVISÃO DUPLA (SPLIT SCREEN) -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; background: #0f172a; padding: 20px; border-radius: 12px; border: 4px solid #1e293b;">
                
                <!-- PREVISÃO 1: PRODUÇÃO (ESTADO ATUAL) -->
                <div>
                     <h3 style="color: #64748b; margin-top: 0; font-family: sans-serif; font-size: 14px; display: flex; justify-content: space-between;">
                        🔴 PRODUÇÃO (LIVE)
                        <span style="font-size: 10px; font-weight: normal;">SINCRO: WP CORE</span>
                    </h3>
                    <div style="background: white; border-radius: 4px; overflow: hidden; height: 400px; border: 2px solid #ef4444; opacity: 0.8;">
                        <iframe id="production-frame" style="width: 100%; height: 100%; border: none;"></iframe>
                    </div>
                </div>

                <!-- PREVISÃO 2: RASCUNHO (O QUE VOCÊ ESTÁ CRIANDO) -->
                <div>
                    <h3 style="color: #3b82f6; margin-top: 0; font-family: sans-serif; font-size: 14px; display: flex; justify-content: space-between;">
                        🔵 MESA DE PROJETO (IA DRAFT)
                        <span style="font-size: 10px; font-weight: normal;">RENDERIZANDO...</span>
                    </h3>
                    <div style="background: white; border-radius: 4px; overflow: hidden; height: 400px; border: 2px solid #3b82f6;">
                        <iframe id="preview-frame" style="width: 100%; height: 100%; border: none;"></iframe>
                    </div>
                </div>
            </div>

        </div>

        <script>
        const input = document.getElementById('ai-content-input');
        const preview = document.getElementById('preview-frame');
        const production = document.getElementById('production-frame');
        const historySelect = document.getElementById('ai-history-list');
        const restoreBtn = document.getElementById('restore-btn');
        
        // Conteúdo atual em produção
        const liveContent = <?php 
            $home_id = get_option('page_on_front');
            echo json_encode($home_id ? get_post($home_id)->post_content : ''); 
        ?>;

        // Função Genérica para renderizar HTML em Iframe com Tailwind
        function renderInFrame(iframe, content) {
            const doc = iframe.contentDocument || iframe.contentWindow.document;
            doc.open();
            doc.write(`
                <html>
                    <head>
                        <script src="https://cdn.tailwindcss.com"><\/script>
                        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
                        <script>
                            tailwind.config = {
                                theme: {
                                    extend: {
                                        colors: { 'slate-dark': '#0f172a', 'electric-blue': '#3b82f6', 'text-primary': '#f8fafc', 'text-secondary': '#94a3b8', 'border-color': '#1e293b' },
                                        fontFamily: { 'sans': ['Inter', 'sans-serif'], 'display': ['Space Grotesk', 'sans-serif'] }
                                    }
                                }
                            }
                        <\/script>
                        <style>
                            body { background: #0f172a; color: white; padding: 20px; font-family: 'Inter', sans-serif; overflow-x: hidden; }
                            h1, h2, h3 { font-family: 'Space Grotesk', sans-serif; }
                            .card-glass { background: rgba(30, 41, 59, 0.5); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.05); padding: 40px; border-radius: 12px; }
                            .btn-primary { background: #3b82f6; color: white; padding: 12px 24px; border-radius: 6px; font-weight: bold; text-decoration: none; display: inline-block; }
                        </style>
                    </head>
                    <body>${content || '<div style="color: #64748b; text-align: center; margin-top: 50px;">Vazio</div>'}</body>
                </html>
            `);
            doc.close();
        }

        // Função para atualizar o Preview de Rascunho
        function updateDraftPreview() {
            renderInFrame(preview, input.value);
        }

        // Inicializa Previsão de Produção
        function initProductionPreview() {
            renderInFrame(production, liveContent);
        }

        input.addEventListener('input', updateDraftPreview);

        // Função para carregar histórico
        async function loadHistory() {
            try {
                const response = await fetch('<?php echo get_rest_url(null, 'cm-global/v1/get-history'); ?>');
                const data = await response.json();
                historySelect.innerHTML = '<option value="">Restaurar Snapshot...</option>';
                data.forEach(rev => {
                    historySelect.innerHTML += `<option value="${rev.id}">${rev.date} (${rev.author})</option>`;
                });
            } catch (e) {}
        }

        historySelect.addEventListener('change', (e) => {
            restoreBtn.style.display = e.target.value ? 'inline-block' : 'none';
        });

        restoreBtn.addEventListener('click', async () => {
            if(!confirm('Deseja restaurar esta versão?')) return;
            const res = await fetch('<?php echo get_rest_url(null, 'cm-global/v1/restore-version'); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ version_id: historySelect.value })
            });
            const data = await res.json();
            if(data.status === 'success') {
                input.value = data.content;
                updateDraftPreview();
                alert('Versão restaurada no editor! Clique em "Publicar Live" para aplicar ao site.');
            }
        });

        // Publish principal
        document.getElementById('publish-ai-btn').addEventListener('click', async () => {
            const status = document.getElementById('ai-status');
            status.innerText = '⏳ Sincronizando...';
            
            const type = document.getElementById('ai-target-type').value;
            const endpoint = type === 'home' ? 'update-layout' : 'create-post';
            
            const response = await fetch('<?php echo get_rest_url(null, 'cm-global/v1/'); ?>' + endpoint, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    content: input.value,
                    title: document.getElementById('ai-post-title').value
                })
            });
            const result = await response.json();
            status.innerText = '✅ ' + result.message;
            loadHistory();
            
            // Opcional: Atualizar produção após publicar (recarregar página ou iframe)
            if(type === 'home') {
                renderInFrame(production, input.value);
            }
        });

        document.getElementById('ai-target-type').addEventListener('change', (e) => {
            document.getElementById('title-wrapper').style.display = e.target.value === 'post' ? 'block' : 'none';
        });

        loadHistory();
        updateDraftPreview();
        initProductionPreview();
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
