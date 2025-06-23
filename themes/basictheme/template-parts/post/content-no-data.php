<div class="site-serach-no-data">
    <h3>
        <?php  esc_html_e('Không có dữ liệu', 'basictheme');?>
    </h3>

    <div class="page-content">
        <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
            <p>
                <?php printf( esc_html__( 'Sẵn sàng đăng bài viết đầu tiên của bạn chưa? <a href="%1$s">Bắt đầu ở đây</a>.', 'basictheme' ), esc_url( admin_url( 'post-new.php' ) ) ); ?>
            </p>
        <?php elseif ( is_search() ) : ?>
            <p>
                <?php esc_html_e( 'Xin lỗi, nhưng không có kết quả nào khớp với từ khóa tìm kiếm của bạn. Vui lòng thử lại với một số từ khóa khác.', 'basictheme' ); ?>
            </p>

            <?php get_search_form(); ?>
        <?php else : ?>
            <p>
                <?php esc_html_e( 'Có vẻ như chúng tôi không tìm thấy những gì bạn đang tìm kiếm. Có lẽ tìm kiếm có thể giúp ích.', 'basictheme' ); ?>
            </p>

            <?php get_search_form(); ?>
        <?php endif; ?>
    </div>
</div>