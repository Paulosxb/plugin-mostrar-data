<?php
/**
 * Plugin Name: Meu Plugin
 * Plugin URI: http://www.exemplo.com.br/
 * Description: Plugin para demonstração
 * Version: 1.0
 * Author: Seu nome
 * Author URI: http://www.exemplo.com.br/
 */

function mostrar_data_atual() {
  return date('d/m/Y');
}
add_shortcode('data_atual', 'mostrar_data_atual');

function adicionar_pagina_configuracao() {
  add_menu_page(
    'Configurações do Meu Plugin',
    'Meu Plugin',
    'manage_options',
    'configuracoes-meu-plugin',
    'mostrar_pagina_configuracao',
    'dashicons-admin-generic',
    90
  );
}
add_action('admin_menu', 'adicionar_pagina_configuracao');

function mostrar_pagina_configuracao() {
  ?>
  <div class="wrap">
    <h1>Configurações do Meu Plugin</h1>
    <form method="post" action="options.php">
      <?php settings_fields('configuracoes-meu-plugin-group'); ?>
      <?php do_settings_sections('configuracoes-meu-plugin'); ?>
      <?php submit_button(); ?>
    </form>
  </div>
  <?php
}

function adicionar_campos_configuracao() {
  add_settings_section(
    'configuracoes-meu-plugin-section',
    'Configurações do Meu Plugin',
    'mostrar_descricao_configuracao',
    'configuracoes-meu-plugin'
  );
  
  add_settings_field(
    'data_atual_formato',
    'Formato da Data Atual',
    'mostrar_campo_formato_data_atual',
    'configuracoes-meu-plugin',
    'configuracoes-meu-plugin-section'
  );
  
  register_setting(
    'configuracoes-meu-plugin-group',
    'data_atual_formato'
  );
}
add_action('admin_init', 'adicionar_campos_configuracao');

function mostrar_descricao_configuracao() {
  echo '<p>Configure o formato da data atual exibida pelo plugin.</p>';
}

function mostrar_campo_formato_data_atual() {
  $formato = get_option('data_atual_formato', 'd/m/Y');
  echo '<input type="text" name="data_atual_formato" value="' . esc_attr($formato) . '" />';
}

$data_atual_formato = get_option('data_atual_formato', 'd/m/Y');
$data_atual = date($data_atual_formato);


function data_atual_shortcode() {
  $data_atual_formato = get_option('data_atual_formato', 'd/m/Y');
  $data_atual = date($data_atual_formato);
  return $data_atual;
}
add_shortcode('data_atual', 'data_atual_shortcode');
