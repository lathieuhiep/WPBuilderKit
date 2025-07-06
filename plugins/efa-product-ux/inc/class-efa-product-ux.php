<?php
declare(strict_types=1);

final class EFA_Product_UX
{
    public string $version;
    public string $text_domain;
    public string $path;
    public string $url;

    public function __construct(
        string $version = '1.0.0',
        string $text_domain = 'efa-product-ux'
    )
    {
        $this->version = $version;
        $this->text_domain = $text_domain;
        $this->path = plugin_dir_path( dirname(__FILE__, 1) );
        $this->url = plugin_dir_url( dirname(__FILE__, 1) );
    }

    public function init(): void
    {
        if ( !$this->is_woocommerce_active() ) {
            add_action( 'admin_notices', [$this, 'admin_notice_woocommerce_required'] );
        }

        $this->define_constants();
        $this->load_text_domain();
        $this->load_db();
        $this->load_core();
    }

    private function is_woocommerce_active(): bool
    {
        return class_exists( 'WooCommerce' );
    }

    public function admin_notice_woocommerce_required(): void
    {
    ?>
        <div class="notice notice-error is-dismissible">
            <p><?php esc_html_e( 'EFA Product UX cần WooCommerce được cài và kích hoạt.', $this->text_domain ); ?></p>
        </div>
    <?php
    }

    private function define_constants(): void
    {
        if (!defined('EFA_PRODUCT_UX_VERSION')) {
            define('EFA_PRODUCT_UX_VERSION', $this->version);
        }

        if (!defined('EFA_PRODUCT_TEXT_DOMAIN')) {
            define('EFA_PRODUCT_TEXT_DOMAIN', $this->text_domain);
        }

        if (!defined('EFA_PRODUCT_UX_PATH')) {
            define('EFA_PRODUCT_UX_PATH', $this->path);
        }

        if (!defined('EFA_PRODUCT_UX_URL')) {
            define('EFA_PRODUCT_UX_URL', $this->url);
        }
    }

    private function load_text_domain(): void
    {
        load_plugin_textdomain(
            $this->text_domain,
            false,
            dirname( plugin_basename( __FILE__ ), 1 ) . '/languages/'
        );
    }

    private function load_db(): void
    {
        require_once $this->path . 'inc/class-efa-product-db.php';
        require_once $this->path . 'modules/swatches/class-efa-swatches-db.php';
    }

    public function activate(): void
    {
        $this->load_db();

        if ( class_exists( 'EFA_Product_DB' ) ) {
            EFA_Product_DB::create_all_tables();
        }
    }

    private function load_core(): void
    {
        require_once $this->path . 'inc/enqueue-scripts.php';
        require_once $this->path . 'inc/core-init.php';
    }
}