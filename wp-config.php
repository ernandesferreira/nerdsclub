<?php
/** 
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'plantaomesquita');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'root');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', '');

/** nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'HLk@K<`5[dU;MHU~n:gq@]wW`u9MgGR88%1#OFZiUiNiraH|81@nD{gCY7ow4B-)');
define('SECURE_AUTH_KEY',  'q&-2e-_+c#|`.cgPD+jA|swZ-*7b~w-@vY4t>`NGo5T0IEV2#]-GK`NM&!j!$q8=');
define('LOGGED_IN_KEY',    '0x&Mfoch+&M_fhQaYA]5HLVi~Uz|K-Vr]mijv5~(TX%2}o?=MZO3e@+xde2~;+,k');
define('NONCE_KEY',        'uWrLo3&:ht47,FQ]>D@MKs[-_ 6Q}Y4y ??oo@5WFl2q]IW5HUUM<xtFsFT&F_r$');
define('AUTH_SALT',        'u.*1)`Zt7v^ #yP:Mf6N.)+p,]D]<d5zSm*%mZCrX8dL2Z}~<GOm9`-g9F*p?fkb');
define('SECURE_AUTH_SALT', '.3PC*n108hcG7WO|T|?6yComi-4$Uc&dgCHI3&|V--A_dvQkSY$uvH@y~5SD{Z`,');
define('LOGGED_IN_SALT',   '[6H[#]6yH +|krGt;S0ppoP8l1d-HVrCtO}-oDWf+ws?]#+#75Kj!+`IYc#J& lE');
define('NONCE_SALT',       'g)x^%oZu`>CH#H>cpqMN:3D#E,JT:y-~x1B6FM1*6f{ii}QR_S6|-%-|4vZB 1+^');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';


/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');