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
                    background-color: #0f172a;
                }
                h1, h2, h3, h4, h5, h6 { 
                    @apply font-display tracking-tight text-white font-bold; 
                }
                p { @apply text-text-secondary leading-relaxed; }
                a { @apply transition-all duration-300; }
            }
            @layer components {
                .btn-primary { @apply px-8 py-4 bg-[#3b82f6] text-white rounded-md font-bold transition-all hover:bg-[#2563eb] shadow-lg shadow-blue-500/20 active:scale-95 text-center inline-block; }
                .btn-secondary { @apply px-8 py-4 border border-[#1e293b] text-white rounded-md font-bold transition-all hover:bg-white/5 active:scale-95 text-center inline-block; }
                .card-glass { @apply bg-[#1e293b]/50 backdrop-blur-sm border border-white/5 rounded-xl p-8 transition-all hover:border-[#3b82f6]/40 hover:shadow-xl hover:shadow-blue-500/5; }
                .section-glow { @apply relative overflow-hidden; }
                .section-glow::before {
                    content: '';
                    @apply absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-blue-500/5 blur-[120px] rounded-full -z-10;
                }
            }
        </style>
        <?php
    }, 1 );
}
add_action( 'wp_enqueue_scripts', 'cm_global_v2_enqueue_scripts' );

/**
 * Walker Custom para o Menu Tailwind
 */
class CM_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $active_class = in_array('current-menu-item', $classes) ? 'text-[#3b82f6]' : 'text-slate-400 hover:text-white';
        
        $url = $item->url;
        // Se for um link de âncora (ex: #contato), garante que funcione em outras páginas voltando para a Home
        if (strpos($url, '#') === 0) {
            $url = home_url('/') . $url;
        }

        $output .= '<a href="' . $url . '" class="' . $active_class . ' font-display font-medium text-sm tracking-wide transition-colors">';
        $output .= $item->title;
        $output .= '</a>';
    }
}

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

    // Rota para buscar lista de páginas
    register_rest_route( 'cm-global/v1', '/get-pages', array(
        'methods' => 'GET',
        'callback' => 'cm_get_all_pages',
        'permission_callback' => '__return_true',
    ) );

    // Rota para buscar conteúdo de uma página específica
    register_rest_route( 'cm-global/v1', '/get-page-content/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'cm_get_page_content_by_id',
        'permission_callback' => '__return_true',
    ) );

    // Rota para buscar Histórico (Revisões) de uma página/post específico
    register_rest_route( 'cm-global/v1', '/get-history/(?P<id>\d+)', array(
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

    // Rota Universal para Salvar (Página ou Post)
    register_rest_route( 'cm-global/v1', '/save-content', array(
        'methods' => 'POST',
        'callback' => 'cm_handle_save_content',
        'permission_callback' => '__return_true',
    ) );
    // Rota para Chat com Gemini
    register_rest_route( 'cm-global/v1', '/gemini-chat', array(
        'methods' => 'POST',
        'callback' => 'cm_handle_gemini_chat',
        'permission_callback' => '__return_true',
    ) );

    // Rota para salvar Configuração do Gemini
    register_rest_route( 'cm-global/v1', '/save-gemini-config', array(
        'methods' => 'POST',
        'callback' => 'cm_handle_save_gemini_config',
        'permission_callback' => '__return_true',
    ) );
} );

// Salvar configuração do Gemini
function cm_handle_save_gemini_config( $request ) {
    $params = $request->get_json_params();
    $key = $params['api_key'];
    if ( $key ) {
        update_option('cm_gemini_api_key', $key);
        return array( 'status' => 'success', 'message' => 'Chave API salva com sucesso!' );
    }
    return new WP_Error( 'invalid', 'Chave vazia.', array( 'status' => 400 ) );
}

// Callback para Chat Gemini
function cm_handle_gemini_chat( $request ) {
    $params = $request->get_json_params();
    $user_prompt = $params['prompt'];
    
    // Tenta buscar a chave de múltiplos lugares (Ambiente ou Opção do WP)
    $api_key = getenv('GEMINI_API_KEY');
    if (!$api_key) $api_key = getenv('GOOGLE_API_KEY');
    if (!$api_key && isset($_ENV['GEMINI_API_KEY'])) $api_key = $_ENV['GEMINI_API_KEY'];
    if (!$api_key && isset($_SERVER['GEMINI_API_KEY'])) $api_key = $_SERVER['GEMINI_API_KEY'];
    
    // Fallback para uma opção salva no WordPress (caso o ambiente falhe)
    if (!$api_key) $api_key = get_option('cm_gemini_api_key');

    if ( !$api_key ) {
        return new WP_Error( 'no_key', 'GEMINI_API_KEY não configurada. Por favor, configure nas variáveis de ambiente do AI Studio ou use o campo de configuração abaixo.', array( 'status' => 500 ) );
    }

    $system_instruction = "Você é um desenvolvedor frontend especialista em Tailwind CSS e WordPress. 
    Seu objetivo é gerar APENAS o código HTML com classes Tailwind para o tema da empresa C&M Global Services.
    Diretrizes de Design:
    - Background principal: slate-dark (#0f172a)
    - Cor de destaque: electric-blue (#3b82f6)
    - Fontes: 'Space Grotesk' (display) para títulos e 'Inter' (sans) para textos.
    - Estilo: Industrial, Tech-Moderno, Profissional, Minimalista.
    - Componentes de vidro (glassmorphism): use 'card-glass' (bg-[#1e293b]/50 backdrop-blur-sm border border-white/5).
    - Botões: use 'btn-primary' ou 'btn-secondary'.
    Retorne APENAS o código HTML limpo, sem explicações, sem blocos de código markdown (```html), apenas o conteúdo que será inserido no body.";

    $body = array(
        'system_instruction' => array(
            'parts' => array( array('text' => $system_instruction) )
        ),
        'contents' => array(
            array(
                'role' => 'user',
                'parts' => array(
                    array('text' => $user_prompt)
                )
            )
        ),
        'generationConfig' => array(
            'temperature' => 0.4,
            'topP' => 0.95,
            'topK' => 40,
            'maxOutputTokens' => 8192,
        ),
        'safetySettings' => array(
            array( 'category' => 'HARM_CATEGORY_HARASSMENT', 'threshold' => 'BLOCK_NONE' ),
            array( 'category' => 'HARM_CATEGORY_HATE_SPEECH', 'threshold' => 'BLOCK_NONE' ),
            array( 'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT', 'threshold' => 'BLOCK_NONE' ),
            array( 'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT', 'threshold' => 'BLOCK_NONE' )
        )
    );

    $response = wp_remote_post( "https://generativelanguage.googleapis.com/v1beta/models/gemini-3-flash-preview:generateContent?key=" . $api_key, array(
        'headers'     => array( 'Content-Type' => 'application/json' ),
        'body'        => json_encode( $body ),
        'timeout'     => 60,
    ) );

    if ( is_wp_error( $response ) ) {
        return $response;
    }

    $body_text = wp_remote_retrieve_body( $response );
    $data = json_decode( $body_text, true );
    
    if ( !isset($data['candidates'][0]['content']['parts'][0]['text']) ) {
        $error_msg = 'A IA não retornou conteúdo. ';
        if ( isset($data['error']['message']) ) $error_msg .= 'Motivo: ' . $data['error']['message'];
        elseif ( isset($data['promptFeedback']['blockReason']) ) $error_msg .= 'Filtro de segurança: ' . $data['promptFeedback']['blockReason'];
        else $error_msg .= 'Resposta técnica: ' . $body_text;
        
        return new WP_Error( 'ai_fail', $error_msg, array( 'status' => 500 ) );
    }

    $ai_text = $data['candidates'][0]['content']['parts'][0]['text'];
    
    // Limpar possíveis blocos markdown se o modelo ignorar a instrução
    $ai_text = str_replace( array('```html', '```'), '', $ai_text );
    $ai_text = trim($ai_text);

    return array( 'status' => 'success', 'content' => $ai_text );
}

// Buscar todas as páginas
function cm_get_all_pages() {
    $pages = get_pages();
    $result = array();
    foreach ( $pages as $page ) {
        $result[] = array(
            'id'    => $page->ID,
            'title' => $page->post_title,
            'url'   => get_permalink($page->ID)
        );
    }
    return $result;
}

// Buscar conteúdo de página
function cm_get_page_content_by_id( $request ) {
    $id = $request['id'];
    $post = get_post($id);
    if ( $post ) {
        return array( 'content' => $post->post_content );
    }
    return new WP_Error( 'not_found', 'Página não encontrada', array( 'status' => 404 ) );
}

// Callback universal para salvar
function cm_handle_save_content( $request ) {
    $params = $request->get_json_params();
    $target = $params['target']; // 'page' ou 'new_post' ou 'new_page'
    $content = $params['content'];
    $title = $params['title'];
    $id = isset($params['id']) ? $params['id'] : null;

    if ( $target === 'new_post' || $target === 'new_page' ) {
        $post_type = ($target === 'new_post') ? 'post' : 'page';
        $new_id = wp_insert_post( array(
            'post_title'   => $title ? $title : 'Novo Item - ' . date('d/m/Y'),
            'post_content' => $content,
            'post_status'  => 'publish',
            'post_type'    => $post_type,
            'post_author'  => 1
        ) );
        if ( is_wp_error($new_id) ) return $new_id;
        return array( 'status' => 'success', 'message' => 'Criado com sucesso!', 'url' => get_permalink($new_id), 'id' => $new_id );
    } else {
        // Atualizar existente
        if ( !$id ) return new WP_Error( 'missing_id', 'ID necessário para atualizar', array( 'status' => 400 ) );
        wp_update_post( array( 'ID' => $id, 'post_content' => $content, 'post_title' => $title ? $title : get_the_title($id) ) );
        return array( 'status' => 'success', 'message' => 'Atualizado!', 'url' => get_permalink($id) );
    }
}

// Callback para buscar histórico (Revisões)
function cm_get_layout_history( $request ) {
    $id = $request['id'];
    if ( !$id ) return array();
    
    $revisions = wp_get_post_revisions( $id, array( 'posts_per_page' => 10 ) );
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
    $target_id = $params['target_id'];
    
    $revision = wp_get_post_revision( $rev_id );
    if ( $revision && $target_id ) {
        wp_update_post( array( 'ID' => $target_id, 'post_content' => $revision->post_content ) );
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

        <!-- CHAT COM GEMINI -->
        <div style="background: #1e293b; color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; border-left: 5px solid #3b82f6; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
            <h2 style="color: #3b82f6; margin-top: 0; display: flex; align-items: center; gap: 10px; font-size: 18px;">
                <span style="font-size: 24px;">🤖</span> Huxx Assistente IA (Gemini 1.5 Flash)
            </h2>
            <p style="font-size: 13px; color: #94a3b8; margin-bottom: 15px;">Descreva o que você deseja criar ou alterar (ex: "Crie uma seção de depoimentos de clientes com 3 cards no estilo dark mode").</p>
            
            <div style="display: flex; gap: 10px;">
                <input type="text" id="ai-chat-prompt" style="flex: 1; height: 45px; background: #0f172a; border: 1px solid #334155; color: white; padding: 0 15px; border-radius: 6px;" placeholder="O que vamos construir hoje?">
                <button id="generate-ai-code-btn" class="button" style="background: #3b82f6; color: white; border: none; height: 45px; padding: 0 25px; border-radius: 6px; font-weight: bold; cursor: pointer;">Gerar Código</button>
            </div>
            <div id="ai-chat-status" style="margin-top: 10px; font-size: 12px; color: #3b82f6; min-height: 15px;"></div>
            
            <!-- CONFIGURAÇÃO DE CHAVE (MINIMIZÁVEL) -->
            <details style="margin-top: 15px; border-top: 1px solid #334155; pt-15px;">
                <summary style="font-size: 11px; cursor: pointer; color: #64748b;">⚙️ Configurar Ponte Gemini (caso necessário)</summary>
                <div style="padding-top: 10px; display: flex; gap: 10px;">
                    <input type="password" id="gemini-key-input" style="flex: 1; height: 30px; background: #0f172a; border: 1px solid #334155; color: white; font-size: 11px;" placeholder="Insira seu GEMINI_API_KEY">
                    <button id="save-gemini-key-btn" class="button" style="height: 30px; line-height: 28px; font-size: 11px;">Salvar Chave</button>
                </div>
            </details>
        </div>
        
        <div style="display: grid; grid-template-cols: 1fr; gap: 20px; margin-top: 20px;">
            
            <!-- COLUNA ESQUERDA: EDITOR -->
            <div style="background: #fff; padding: 25px; border: 1px solid #ccd0d4; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: flex-start; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-weight: bold; margin-bottom: 8px;">1. Destino / Ação</label>
                        <select id="ai-target-type" style="width: 100%; height: 35px;">
                            <optgroup label="Criar Novo">
                                <option value="new_post">Novo Post Blog</option>
                                <option value="new_page">Nova Página Estática</option>
                            </optgroup>
                            <optgroup label="Atualizar Existente" id="existing-pages-group">
                                <!-- Preenchido via JS -->
                            </optgroup>
                        </select>
                    </div>

                    <div style="text-align: right;">
                         <label style="display: block; font-weight: bold; margin-bottom: 8px;">🕒 Snapshots da Seleção</label>
                         <div style="display: flex; gap: 5px; justify-content: flex-end;">
                            <select id="ai-history-list" style="width: 200px; height: 35px;">
                                <option value="">Selecione um destino...</option>
                            </select>
                            <button id="restore-btn" class="button" style="display:none;">Voltar</button>
                         </div>
                    </div>
                </div>

                <div id="title-wrapper" style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 8px;">2. Título (Página ou Post)</label>
                    <input type="text" id="ai-post-title" style="width: 100%; height: 35px;" placeholder="Ex: Serviços de Engenharia 2024">
                </div>

                <div style="display: flex; gap: 10px; margin-bottom: 8px; align-items: center;">
                    <label style="font-weight: bold;">3. Código HTML / Tailwind</label>
                    <button id="toggle-live-code" type="button" class="button" style="font-size: 10px; height: 22px; line-height: 20px;">Ver Código em Produção</button>
                </div>
                
                <div id="live-code-wrapper" style="display: none; margin-bottom: 20px;">
                    <span style="font-size: 10px; color: #ef4444; font-weight: bold; display: block; margin-bottom: 5px;">🔴 CÓDIGO ATUAL EM PRODUÇÃO (SOMENTE LEITURA)</span>
                    <textarea id="ai-live-content-view" style="width: 100%; height: 200px; font-family: 'JetBrains Mono', monospace; font-size: 12px; background: #fff5f5; border: 1px solid #feb2b2; border-radius: 4px; color: #7f1d1d;" readonly></textarea>
                    <button id="copy-to-draft" type="button" class="button" style="margin-top: 5px; width: 100%;">Copiar para o Editor de Rascunho ↑</button>
                </div>

                <textarea id="ai-content-input" style="width: 100%; height: 350px; font-family: 'JetBrains Mono', monospace; font-size: 12px; background: #fafafa; border-radius: 4px;" placeholder="Cole aqui seu novo código..."></textarea>
                
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
        const liveView = document.getElementById('ai-live-content-view');
        const preview = document.getElementById('preview-frame');
        const production = document.getElementById('production-frame');
        const historySelect = document.getElementById('ai-history-list');
        const restoreBtn = document.getElementById('restore-btn');
        const toggleLiveBtn = document.getElementById('toggle-live-code');
        const liveWrapper = document.getElementById('live-code-wrapper');
        const copyBtn = document.getElementById('copy-to-draft');
        const targetSelect = document.getElementById('ai-target-type');
        const existingPagesGroup = document.getElementById('existing-pages-group');
        const titleInput = document.getElementById('ai-post-title');
        
        let currentLiveContent = "";
        let pagesCache = [];

        // 1. Carregar lista de páginas existentes
        async function loadPagesList() {
            const res = await fetch('<?php echo get_rest_url(null, 'cm-global/v1/get-pages'); ?>');
            pagesCache = await res.json();
            existingPagesGroup.innerHTML = "";
            pagesCache.forEach(p => {
                const opt = document.createElement('option');
                opt.value = "page_" + p.id;
                opt.innerText = "Página: " + p.title;
                existingPagesGroup.appendChild(opt);
            });
            
            // Tentar selecionar a Home por padrão
            const homeId = <?php echo get_option('page_on_front') ? get_option('page_on_front') : 'null'; ?>;
            if(homeId) {
                targetSelect.value = "page_" + homeId;
                handleTargetChange();
            }
        }

        // 2. Lidar com mudança de destino
        async function handleTargetChange() {
            const val = targetSelect.value;
            const status = document.getElementById('ai-status');
            
            if(val.startsWith("page_")) {
                const id = val.split("_")[1];
                const page = pagesCache.find(p => p.id == id);
                titleInput.value = page ? page.title : "";
                
                status.innerText = "⏳ Carregando dados da página...";
                const res = await fetch('<?php echo get_rest_url(null, 'cm-global/v1/get-page-content/'); ?>' + id);
                const data = await res.json();
                currentLiveContent = data.content;
                
                liveView.value = currentLiveContent;
                renderInFrame(production, currentLiveContent);
                loadHistory(id);
                status.innerText = "";
            } else {
                titleInput.value = "";
                currentLiveContent = "";
                liveView.value = "";
                renderInFrame(production, "");
                historySelect.innerHTML = '<option value="">Sem histórico (Conteúdo Novo)</option>';
            }
        }

        targetSelect.addEventListener('change', handleTargetChange);

        // Lógica de Visualização de Código Live
        toggleLiveBtn.addEventListener('click', () => {
            const isHidden = liveWrapper.style.display === 'none';
            liveWrapper.style.display = isHidden ? 'block' : 'none';
            toggleLiveBtn.innerText = isHidden ? 'Ocultar Código Produção' : 'Ver Código em Produção';
        });

        copyBtn.addEventListener('click', () => {
            if(confirm('Isso substituirá o código no editor de rascunho. Continuar?')) {
                input.value = currentLiveContent;
                renderInFrame(preview, input.value);
                // Dispara evento input para garantir sincronia se houver outros listeners
                input.dispatchEvent(new Event('input'));
            }
        });

        // Lógica de Chat com Gemini
        document.getElementById('generate-ai-code-btn').addEventListener('click', async () => {
            const prompt = document.getElementById('ai-chat-prompt').value;
            const chatStatus = document.getElementById('ai-chat-status');
            
            if(!prompt) return alert('Por favor, digite o que você deseja gerar.');
            
            chatStatus.innerText = '🧠 Huxley está pensando e codificando...';
            document.getElementById('generate-ai-code-btn').disabled = true;

            try {
                const response = await fetch('<?php echo get_rest_url(null, 'cm-global/v1/gemini-chat'); ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ prompt: prompt })
                });
                const data = await response.json();
                
                if(data.status === 'success' && data.content) {
                    const editorField = document.getElementById('ai-content-input');
                    if(editorField) {
                        editorField.value = data.content;
                        renderInFrame(preview, data.content);
                        chatStatus.innerText = '✨ Código gerado com sucesso!';
                        document.getElementById('ai-chat-prompt').value = '';
                    }
                } else {
                    // Mostra a mensagem de erro real vinda do PHP
                    chatStatus.innerText = '❌ Erro: ' + (data.message || 'Resposta inesperada da IA.');
                }
            } catch (e) {
                chatStatus.innerText = '❌ Erro de conexão com a IA.';
            } finally {
                document.getElementById('generate-ai-code-btn').disabled = false;
            }
        });

        // Salvar Chave API Manualmente
        document.getElementById('save-gemini-key-btn').addEventListener('click', async () => {
            const key = document.getElementById('gemini-key-input').value;
            if(!key) return alert('Insira uma chave válida.');
            
            const res = await fetch('<?php echo get_rest_url(null, 'cm-global/v1/save-gemini-config'); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ api_key: key })
            });
            const data = await res.json();
            alert(data.message);
            location.reload(); // Recarrega para aplicar
        });

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
                            img { max-width: 100%; height: auto; }
                        </style>
                    </head>
                    <body>${content || '<div style="color: #64748b; text-align: center; margin-top: 50px;">Nenhum conteúdo definido</div>'}</body>
                </html>
            `);
            doc.close();
        }

        // Função para atualizar o Preview de Rascunho
        function updateDraftPreview() {
            renderInFrame(preview, input.value);
        }

        input.addEventListener('input', updateDraftPreview);

        // Função para carregar histórico
        async function loadHistory(id) {
            if(!id) return;
            try {
                const response = await fetch('<?php echo get_rest_url(null, 'cm-global/v1/get-history/'); ?>' + id);
                const data = await response.json();
                historySelect.innerHTML = '<option value="">Snapshot da Página...</option>';
                data.forEach(rev => {
                    historySelect.innerHTML += `<option value="${rev.id}">${rev.date} (${rev.author})</option>`;
                });
            } catch (e) {}
        }

        historySelect.addEventListener('change', (e) => {
            restoreBtn.style.display = e.target.value ? 'inline-block' : 'none';
        });

        restoreBtn.addEventListener('click', async () => {
            const val = targetSelect.value;
            if(!val.startsWith("page_")) return;
            const targetId = val.split("_")[1];

            if(!confirm('Deseja restaurar esta versão?')) return;
            const res = await fetch('<?php echo get_rest_url(null, 'cm-global/v1/restore-version'); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    version_id: historySelect.value,
                    target_id: targetId
                })
            });
            const data = await res.json();
            if(data.status === 'success') {
                input.value = data.content;
                updateDraftPreview();
                alert('Versão restaurada no editor! Clique em "Publicar Live" para aplicar.');
            }
        });

        // Publish principal Universal
        document.getElementById('publish-ai-btn').addEventListener('click', async () => {
            const status = document.getElementById('ai-status');
            status.innerText = '⏳ Publicando com Huxley...';
            
            const target = targetSelect.value;
            let id = null;
            let actionType = target;

            if(target.startsWith("page_")) {
                id = target.split("_")[1];
                actionType = "page";
            }
            
            const response = await fetch('<?php echo get_rest_url(null, 'cm-global/v1/save-content'); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    target: actionType,
                    id: id,
                    content: input.value,
                    title: titleInput.value
                })
            });
            
            const result = await response.json();
            if(response.ok) {
                status.innerText = '✅ ' + result.message;
                if(id || result.id) {
                    const finalId = id || result.id;
                    // Se for novo, recarrega a lista
                    if(!id) await loadPagesList();
                    targetSelect.value = "page_" + finalId;
                    handleTargetChange();
                }
            } else {
                status.innerText = '❌ ' + (result.message || 'Erro ao salvar');
            }
        });

        loadPagesList();
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
