<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @package    Convertix_Pixel
 * @subpackage Convertix_Pixel/admin
 * @file       class-convertix-pixel-admin.php
 */

/**
 * The admin-specific functionality of the plugin.
 */
class Convertix_Pixel_Admin {

	/**
	 * Add settings menu.
	 *
	 * @since    1.0.0
	 */
	public function admin_init() {
		register_setting( CONVERTIX_PIXEL_ADMIN_GROUP, CONVERTIX_PIXEL_ADMIN_OPTIONS );

		add_settings_section(
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			__( 'Instalação Convertix Pixel', 'convertix-pixel' ),
			array( $this, 'admin_output_section' ),
			CONVERTIX_PIXEL_ADMIN_SLUG
		);

		add_settings_field(
			CONVERTIX_PIXEL_WEB_CONTAINER_PLACEMENT,
			__( 'Convertix Pixel On/Off', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_WEB_CONTAINER_PLACEMENT,
				'description' => __( 'Escolha.', 'convertix-pixel' ),
			)
		);

		add_settings_field(
			CONVERTIX_PIXEL_META_PIXEL_ID_1,
			__( 'Meta Pixel (Facebook Pixel) 1', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_META_PIXEL_ID_1,
				'description' => __( 'Digite seu Meta Pixel (Facebook Pixel) primário. Somente números, por exemplo: 1234567890987654', 'convertix-pixel' ),
			)
		);

		add_settings_field(
			CONVERTIX_PIXEL_META_PIXEL_TOKEN_API_1,
			__( 'Meta Pixel (Facebook Pixel) Token API 1', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_META_PIXEL_TOKEN_API_1,
				'description' => __( 'Digite seu Token API Meta Pixel (Facebook Pixel) primário. Pode conter números e letras em MAIÚSCULO.', 'convertix-pixel' ),
			)
		);

		add_settings_field(
			CONVERTIX_PIXEL_META_PIXEL_TESTID_1,
			__( 'Meta Pixel (Facebook Pixel) TEST ID 1', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_META_PIXEL_TESTID_1,
				'description' => __( 'Digite seu TEST ID da Meta Pixel (Facebook Pixel) primário. Pode conter números e letras em MAIÚSCULO. <i>Use somente para testes de eventos e primeira instalação</i>.', 'convertix-pixel' ),
			)
		);

		add_settings_field(
			CONVERTIX_PIXEL_META_PIXEL_ID_2,
			__( 'Meta Pixel (Facebook Pixel) 2', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_META_PIXEL_ID_2,
				'description' => __( 'Digite seu Meta Pixel (Facebook Pixel) secundário. Somente números, por exemplo: 2234567890987654', 'convertix-pixel' ),
			)
		);

		add_settings_field(
			CONVERTIX_PIXEL_META_PIXEL_TOKEN_API_2,
			__( 'Meta Pixel (Facebook Pixel) Token API 2', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_META_PIXEL_TOKEN_API_2,
				'description' => __( 'Digite seu Token API Meta Pixel (Facebook Pixel) secundário. Pode conter números e letras em MAIÚSCULO.', 'convertix-pixel' ),
			)
		);

		add_settings_field(
			CONVERTIX_PIXEL_META_PIXEL_TESTID_2,
			__( 'Meta Pixel (Facebook Pixel) TEST ID 2', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_META_PIXEL_TESTID_2,
				'description' => __( 'Digite seu TEST ID da Meta Pixel (Facebook Pixel) secundário. Pode conter números e letras em MAIÚSCULO. <i>Use somente para testes de eventos e primeira instalação</i>.', 'convertix-pixel' ),
			)
		);

		add_settings_field(
			CONVERTIX_PIXEL_GOOGLE_UNIVERSAL_ANALYTICS_1,
			__( 'Google Universal Analytics', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_GOOGLE_UNIVERSAL_ANALYTICS_1,
				'description' => __( 'Formato válido: UA-XXXXXXXXX-X. Onde X pode ser numeros. Por exemplo: UA-123456789-1.', 'convertix-pixel' ),
			)
		);

		add_settings_field(
			CONVERTIX_PIXEL_GOOGLE_ANALYTICS4_1,
			__( 'Google Analytics 4', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_GOOGLE_ANALYTICS4_1,
				'description' => __( 'Formato válido: G-XXXXXXXXX. Onde X pode ser numeros ou letras em MAIÚSCULO. Por exemplo: G-1A2B3C4D5.', 'convertix-pixel' ),
			)
		);

		add_settings_field(
			CONVERTIX_PIXEL_GOOGLE_ADWORDS_ID_1,
			__( 'Google AdWords Conversion ID "AW-"', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_GOOGLE_ADWORDS_ID_1,
				'description' => __( 'Formato válido: AW-XXXXXXXXX. Onde X pode ser números. Você deve digitar somente a parte numérica.', 'convertix-pixel' ),
			)
		);

		add_settings_field(
			CONVERTIX_PIXEL_GOOGLE_OPTIMIZE_1,
			__( 'Google Optimize', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_GOOGLE_OPTIMIZE_1,
				'description' => __( 'Formato válido: OPT-XXXXXX. Onde X pode ser numeros ou letras em MAIÚSCULO. Por exemplo: OPT-1A2B3C.', 'convertix-pixel' ),
			)
		);

		add_settings_field(
			CONVERTIX_PIXEL_GOOGLE_ANTIFLICKERING_1,
			__( 'Google Anti-Flickering (snippet antioscilação)', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_GOOGLE_ANTIFLICKERING_1,
				'description' => __( 'Deseja adicionar o snippet de antioscilação? Faça isso, somente após ler o site: https://support.google.com/optimize/answer/7100284?hl=pt-BR', 'convertix-pixel' ),
			)
		);

		add_settings_field(
			CONVERTIX_PIXEL_TIKTOK_PIXEL_1,
			__( 'Tiktok Pixel (Developer)', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_TIKTOK_PIXEL_1,
				'description' => __( 'Digite seu Tiktok Pixel (Somente a versão developer). Pode conter números e letras em MAIÚSCULO.', 'convertix-pixel' ),
			)
		);

		add_settings_field(
			CONVERTIX_PIXEL_TIKTOK_PIXEL_TOKEN_API_1,
			__( 'Tiktok Token API', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_TIKTOK_PIXEL_TOKEN_API_1,
				'description' => __( 'Digite seu Tiktok Token API. Pode conter números e letras em MAIÚSCULO.', 'convertix-pixel' ),
			)
		);

		add_settings_field(
			CONVERTIX_PIXEL_TIKTOK_PIXEL_TESTID_1,
			__( 'Tiktok Pixel TESTID', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_TIKTOK_PIXEL_TESTID_1,
				'description' => __( 'Digite seu TEST ID do Tiktok Pixel. Pode conter números e letras em MAIÚSCULO. <i>Use somente para testes de eventos e primeira instalação</i>.', 'convertix-pixel' ),
			)
		);

		add_settings_field(
			CONVERTIX_PIXEL_LINKEDIN_INSIGHT_TAG_1,
			__( 'LinkedIn Insight Tag', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_LINKEDIN_INSIGHT_TAG_1,
				'description' => __( 'Digite seu LinkedIn Insight Tag. Pode conter números.', 'convertix-pixel' ),
			)
		);

		add_settings_field(
			CONVERTIX_PIXEL_ACTIVECAMPAIGN_PIXEL_1,
			__( 'ActiveCampaign Tracking Code', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_ACTIVECAMPAIGN_PIXEL_1,
				'description' => __( 'Digite seu ActiveCampaign Tracking Code. Pode conter números.', 'convertix-pixel' ),
			)
		);

		add_settings_field(
			CONVERTIX_PIXEL_ACTIVECAMPAIGN_EVENTKEY_1,
			__( 'ActiveCampaign Event Key', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_ACTIVECAMPAIGN_EVENTKEY_1,
				'description' => __( 'Digite seu ActiveCampaign Event Key. Pode conter números e letras em minúsculo.', 'convertix-pixel' ),
			)
		);

		add_settings_field(
			CONVERTIX_PIXEL_SERVER_CONTAINER_URL,
			__( 'Convertix Pixel URL', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_SERVER_CONTAINER_URL,
				'description' => __( 'Digite a sua URL Convertix. O valor não pode terminar com "/" Por exemplo: https://ctx.example.com', 'convertix-pixel' ),
			)
		);

		add_settings_field(
			CONVERTIX_PIXEL_CLIENT_EVENT,
			__( 'Evento Pessoal Convertix', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_CLIENT_EVENT,
				'description' => __( 'Digite o evento único cadastrado em sua conta. Você recebeu junto com seu acesso.', 'convertix-pixel' ),
			)
		);

		add_settings_field(
			CONVERTIX_PIXEL_CLIENT_VARIABLE,
			__( 'Variável Única de Validação', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_CLIENT_VARIABLE,
				'description' => __( 'Variável única usada para acessar as funcionalidades convertix.', 'convertix-pixel' ),
			)
		);

		add_settings_field(
			CONVERTIX_PIXEL_CLIENT_TOKEN,
			__( 'Chave de Ativação (Token Convertix)', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_CLIENT_TOKEN,
				'description' => __( 'Token de validação da conta Convertix', 'convertix-pixel' ),
			)
		);

		add_settings_field(
			CONVERTIX_PIXEL_WEB_CONTAINER_ID,
			__( 'Conteiner do cliente', 'convertix-pixel' ),
			array( $this, 'input_callback_function' ),
			CONVERTIX_PIXEL_ADMIN_SLUG,
			CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL,
			array(
				'label_for'   => CONVERTIX_PIXEL_WEB_CONTAINER_ID,
				'description' => __( 'Formato válido: GTM-XXXXXX. Onde X pode ser numeros ou letras em MAIÚSCULO. Por exemplo: GTM-1A2B3C.', 'convertix-pixel' ),
			)
		);
	}

	/**
	 * Add input text.
	 *
	 * @param mixed[] $data Data.
	 *
	 * @since    1.0.0
	 */
	public function input_callback_function( $data ) {
		$id = $data['label_for'];

		if ( CONVERTIX_PIXEL_WEB_CONTAINER_PLACEMENT === $id ) {

			echo '<input required class="' . esc_attr( CONVERTIX_PIXEL_WEB_CONTAINER_PLACEMENT ) . '" type="radio" id="' . esc_attr( CONVERTIX_PIXEL_WEB_CONTAINER_PLACEMENT_ON ) . '" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" class="set-width" value="' . esc_attr( CONVERTIX_PIXEL_WEB_CONTAINER_PLACEMENT_ON ) . '" ' . ( esc_attr( $this->get_option( CONVERTIX_PIXEL_WEB_CONTAINER_PLACEMENT ) ) === CONVERTIX_PIXEL_WEB_CONTAINER_PLACEMENT_ON ? 'checked="checked"' : '' ) . '/> ' . esc_html__( 'On - Adicionar o Pixel Convertix em todas as páginas. Se você possui algum pixel instalado, por favor desabilite todos.', 'convertix-pixel' ) . '<br />';
			echo '<input required class="' . esc_attr( CONVERTIX_PIXEL_WEB_CONTAINER_PLACEMENT ) . '" type="radio" id="' . esc_attr( CONVERTIX_PIXEL_WEB_CONTAINER_PLACEMENT_OFF ) . '" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" class="set-width" value="' . esc_attr( CONVERTIX_PIXEL_WEB_CONTAINER_PLACEMENT_OFF ) . '" ' . ( esc_attr( $this->get_option( CONVERTIX_PIXEL_WEB_CONTAINER_PLACEMENT ) ) === CONVERTIX_PIXEL_WEB_CONTAINER_PLACEMENT_OFF ? 'checked="checked"' : '' ) . '/> ' . esc_html__( 'Off - Desligar o Pixel Convertix totalmente. Útil para verificar se ainda existe outro pixel instalado em caso de duplicidade de eventos. <i>(selecione somente após falar com nosso suporte)</i>', 'convertix-pixel' );

			return;
		}

		if ( CONVERTIX_PIXEL_META_PIXEL_ID_1 === $id ) {

			echo '<input type="number" pattern=".*" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" class="set-width" value="' . esc_attr( $this->get_option( $id ) ) . '"/><br />' . esc_html( $data['description'] );

			return;
		}

		if ( CONVERTIX_PIXEL_META_PIXEL_TOKEN_API_1 === $id ) {

			echo '<input type="text" pattern=".*" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" class="set-width" value="' . esc_attr( $this->get_option( $id ) ) . '"/><br />' . esc_html( $data['description'] );

			return;
		}

		if ( CONVERTIX_PIXEL_META_PIXEL_TESTID_1 === $id ) {

			echo '<input type="text" pattern="TEST.*" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" value="' . esc_attr( $this->get_option( $id ) ) . '"/><br />' . esc_html( $data['description'] );

			return;
		}

		if ( CONVERTIX_PIXEL_META_PIXEL_ID_2 === $id ) {

			echo '<input type="number" pattern=".*" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" value="' . esc_attr( $this->get_option( $id ) ) . '"/><br />' . esc_html( $data['description'] );

			return;
		}

		if ( CONVERTIX_PIXEL_META_PIXEL_TOKEN_API_2 === $id ) {

			echo '<input type="text" pattern=".*" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" value="' . esc_attr( $this->get_option( $id ) ) . '"/><br />' . esc_html( $data['description'] );

			return;
		}

		if ( CONVERTIX_PIXEL_META_PIXEL_TESTID_2 === $id ) {

			echo '<input type="text" pattern="TEST.*" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" value="' . esc_attr( $this->get_option( $id ) ) . '"/><br />' . esc_html( $data['description'] );

			return;
		}

		if ( CONVERTIX_PIXEL_GOOGLE_UNIVERSAL_ANALYTICS_1 === $id ) {
			
			echo '<input type="text" pattern="UA-.*" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" value="' . esc_attr( $this->get_option( $id ) ) . '"/><br />' . esc_html( $data['description'] );

			return;
		}

		if ( CONVERTIX_PIXEL_GOOGLE_ANALYTICS4_1 === $id ) {

			echo '<input type="text" pattern="G-.*" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" value="' . esc_attr( $this->get_option( $id ) ) . '"/><br />' . esc_html( $data['description'] );

			return;
		}

		if ( CONVERTIX_PIXEL_GOOGLE_ADWORDS_ID_1 === $id ) {

			echo '<input type="number" pattern=".*" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" value="' . esc_attr( $this->get_option( $id ) ) . '"/><br />' . esc_html( $data['description'] );

			return;
		}

		if ( CONVERTIX_PIXEL_GOOGLE_OPTIMIZE_1 === $id ) {

			echo '<input type="text" pattern="OPT-.*" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" value="' . esc_attr( $this->get_option( $id ) ) . '"/><br />' . esc_html( $data['description'] );

			return;
		}

		if ( CONVERTIX_PIXEL_GOOGLE_ANTIFLICKERING_1 === $id ) {

			echo '<input type="checkbox" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" value="Anti-Flickering-ON"/ ';if($this->get_option( CONVERTIX_PIXEL_GOOGLE_ANTIFLICKERING_1 )) {echo 'checked';} echo ' ><label for="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']"> Ligar o snipet antioscilação</label><br />' . esc_html( $data['description'] );

			return;
		}

		if ( CONVERTIX_PIXEL_TIKTOK_PIXEL_1 === $id ) {

			echo '<input type="text" pattern=".*" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" value="' . esc_attr( $this->get_option( $id ) ) . '"/><br />' . esc_html( $data['description'] );

			return;
		}

		if ( CONVERTIX_PIXEL_TIKTOK_PIXEL_TOKEN_API_1 === $id ) {

			echo '<input type="text" pattern=".*" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" value="' . esc_attr( $this->get_option( $id ) ) . '"/><br />' . esc_html( $data['description'] );

			return;
		}

		if ( CONVERTIX_PIXEL_TIKTOK_PIXEL_TESTID_1 === $id ) {

			echo '<input type="text" pattern=".*" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" value="' . esc_attr( $this->get_option( $id ) ) . '"/><br />' . esc_html( $data['description'] );

			return;
		}

		if ( CONVERTIX_PIXEL_LINKEDIN_INSIGHT_TAG_1 === $id ) {

			echo '<input type="number" pattern=".*" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" value="' . esc_attr( $this->get_option( $id ) ) . '"/><br />' . esc_html( $data['description'] );

			return;
		}

		if ( CONVERTIX_PIXEL_ACTIVECAMPAIGN_PIXEL_1 === $id ) {

			echo '<input type="number" pattern=".*" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" value="' . esc_attr( $this->get_option( $id ) ) . '"/><br />' . esc_html( $data['description'] );

			return;
		}

		if ( CONVERTIX_PIXEL_ACTIVECAMPAIGN_EVENTKEY_1 === $id ) {

			echo '<input type="text" pattern=".*" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" value="' . esc_attr( $this->get_option( $id ) ) . '"/><br />' . esc_html( $data['description'] );

			return;
		}

		if ( CONVERTIX_PIXEL_SERVER_CONTAINER_URL === $id ) {

			echo '<input type="url" required pattern="https://.*" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" value="' . esc_attr( $this->get_option( $id ) ) . '"/><br />' . esc_html( $data['description'] );

			return;
		}

		if ( CONVERTIX_PIXEL_CLIENT_EVENT === $id ) {

			echo '<input type="text" required pattern=".*" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" value="' . esc_attr( $this->get_option( $id ) ) . '"/><br />' . esc_html( $data['description'] );

			return;
		}

		if ( CONVERTIX_PIXEL_CLIENT_VARIABLE === $id ) { // Evento do Cliente com HASH MD5

			echo '<input type="text" required pattern=".*" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" value="' . esc_attr( md5( $this->get_option( CONVERTIX_CLIENT_EVENT ) ) )  . '" disabled/><br />' . esc_html( $data['description'] );

			return;
		}

		if ( CONVERTIX_PIXEL_CLIENT_TOKEN === $id ) {

			echo '<input type="text" required pattern=".*" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" value="' . esc_attr( $this->get_option( $id ) ) . '"/><br />' . esc_html( $data['description'] );

			return;
		}

		if ( CONVERTIX_PIXEL_WEB_CONTAINER_ID === $id ) {

			echo '<input type="text" required pattern="GTM-.*" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" value="' . esc_attr( $this->get_option( $id ) ) . '"/><br />' . esc_html( $data['description'] );

			return;
		}

		echo '<input type="text" name="' . esc_attr( CONVERTIX_PIXEL_ADMIN_OPTIONS ) . '[' . esc_attr( $id ) . ']" id="' . esc_attr( $id ) . '" class="set-width" value="' . esc_attr( $this->get_option( $id ) ) . '"/><br />' . esc_html( $data['description'] );
	}

	/**
	 * Add settings menu.
	 *
	 * @since    1.0.0
	 */
	public function display_admin_page() {
		add_options_page(
			'Convertix Pixel',
			'Convertix Pixel',
			'manage_options',
			CONVERTIX_PIXEL_ADMIN_SLUG,
			array( $this, 'show_options_page' ),
			27
		);

	}

	/**
	 * Add admin page.
	 *
	 * @since    1.0.0
	 */
	public function show_options_page() {
		require_once 'partials/convertix-pixel-admin-display.php';
	}

	/**
	 * Admin output section
	 *
	 * @param array $args Arguments.
	 *
	 * @return void
	 */
	public function admin_output_section( $args ) {
		echo '<span class="tabinfo">';

		if ( CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL === $args['id'] ) {
			esc_html_e( 'Este plugin deve ser usado somente por clientes Convertix. Se ainda não possui uma conta, você pode criar uma agora ', 'convertix-pixel' );
			echo '<a href="https://convertix.digital/" target="_blank">';
			esc_html_e( 'falando com um especialista', 'convertix-pixel' );
			echo '</a>.<br />';
			echo 'Se você já possui uma conta ativa, pode tirar dúvidas em nossa <a href="https://convertix.digital/base-de-conhecimento" target="_blank">Base de Conhecimento</a><br />';
			echo 'Para desabilitar algum pixel ou analytics, simplesmente deixe o campo em branco.<br />';
			echo 'Caso não tenha ou não lembre as informações do seu Convertix Pixel, acesse sua conta ou entre em contato com o suporte.<br />';
		} // end switch

		echo '</span>';
	}

	/**
	 * Add plugin links.
	 *
	 * @param array  $links Links.
	 * @param string $file File.
	 *
	 * @return mixed
	 */
	public function add_plugin_action_links( $links, $file ) {
		if ( strpos( $file, '/' . CONVERTIX_PIXEL_BASENAME . '.php' ) === false ) {
			return $links;
		}

		$settings_link = '<a href="' . menu_page_url( CONVERTIX_PIXEL_ADMIN_SLUG, false ) . '">' . esc_html( __( 'Settings' ) ) . '</a>';

		array_unshift( $links, $settings_link );

		return $links;
	}

	/**
	 * Get option.
	 *
	 * @param string $id The option id.
	 *
	 * @return mixed
	 */
	protected function get_option( $id ) {
		return isset( get_option( CONVERTIX_PIXEL_ADMIN_OPTIONS )[ $id ] ) ? get_option( CONVERTIX_PIXEL_ADMIN_OPTIONS )[ $id ] : '';
	}
}
