<?php
/**
 * Plugin Name: WC Bale Product Manager
 * Plugin URI: #
 * Description: افزودن ساده محصول از گوشی + ربات بله
 * Version: 1.0.0
 * Author: Admin
 * Requires at least: 5.0
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) exit;

define('WCBPM_VERSION', '1.0.0');
define('WCBPM_PATH', plugin_dir_path(__FILE__));
define('WCBPM_URL', plugin_dir_url(__FILE__));

// ===================================================
// CSS
// ===================================================
function wcbpm_get_css() {
    return '
    <style>
    * {
        box-sizing: border-box;
        -webkit-tap-highlight-color: transparent;
    }
    .wcbpm-container {
        max-width: 500px;
        margin: 0 auto;
        padding: 16px;
        font-family: Tahoma, sans-serif;
        direction: rtl;
        background: #f5f5f5;
        min-height: 100vh;
    }
    .wcbpm-header {
        background: linear-gradient(135deg, #1a73e8, #0d47a1);
        color: white;
        padding: 16px;
        border-radius: 16px;
        margin-bottom: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .wcbpm-header h2 {
        margin: 0;
        font-size: 18px;
    }
    .wcbpm-alert {
        padding: 12px 16px;
        border-radius: 12px;
        margin-bottom: 16px;
        font-size: 14px;
        text-align: center;
        display: none;
    }
    .wcbpm-alert.success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .wcbpm-alert.error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    .wcbpm-field {
        background: white;
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    .wcbpm-field label {
        display: block;
        font-size: 14px;
        font-weight: bold;
        color: #333;
        margin-bottom: 8px;
    }
    .wcbpm-field input[type="text"],
    .wcbpm-field input[type="number"],
    .wcbpm-field textarea,
    .wcbpm-field select {
        width: 100%;
        padding: 12px;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        font-size: 16px;
        font-family: Tahoma, sans-serif;
        direction: rtl;
        outline: none;
        transition: border-color 0.2s;
        background: #fafafa;
        -webkit-appearance: none;
    }
    .wcbpm-field input:focus,
    .wcbpm-field textarea:focus,
    .wcbpm-field select:focus {
        border-color: #1a73e8;
        background: white;
    }
    .wcbpm-image-upload {
        position: relative;
        border: 3px dashed #dee2e6;
        border-radius: 16px;
        padding: 24px;
        text-align: center;
        cursor: pointer;
        background: #fafafa;
        min-height: 120px;
    }
    .wcbpm-image-placeholder span {
        font-size: 40px;
        display: block;
    }
    .wcbpm-image-placeholder p {
        margin: 8px 0 0;
        color: #6c757d;
        font-size: 14px;
    }
    .wcbpm-image-upload input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
    }
    #wcbpm-preview {
        width: 100%;
        border-radius: 12px;
        max-height: 200px;
        object-fit: cover;
        display: none;
    }
    .wcbpm-price-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }
    .wcbpm-price-input label {
        font-size: 12px;
        color: #6c757d;
        font-weight: normal;
        margin-bottom: 4px;
        display: block;
    }
    .wcbpm-status-buttons {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-top: 4px;
    }
    .wcbpm-status-btn {
        padding: 12px;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        background: #fafafa;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.2s;
        font-family: Tahoma, sans-serif;
        text-align: center;
    }
    .wcbpm-status-btn.active {
        border-color: #1a73e8;
        background: #e8f0fe;
        color: #1a73e8;
        font-weight: bold;
    }
    .wcbpm-submit-btn {
        width: 100%;
        padding: 18px;
        background: linear-gradient(135deg, #1a73e8, #0d47a1);
        color: white;
        border: none;
        border-radius: 16px;
        font-size: 18px;
        font-family: Tahoma, sans-serif;
        font-weight: bold;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(26,115,232,0.4);
        margin-top: 8px;
        width: 100%;
    }
    .wcbpm-submit-btn:active { transform: scale(0.98); }
    .wcbpm-submit-btn:disabled { opacity: 0.7; cursor: not-allowed; }
    .wcbpm-recent {
        background: white;
        border-radius: 16px;
        padding: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        margin-top: 16px;
    }
    .wcbpm-recent h3 {
        margin: 0 0 12px;
        font-size: 15px;
        color: #333;
    }
    .wcbpm-product-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .wcbpm-product-list li {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
        gap: 8px;
    }
    .wcbpm-product-list li:last-child { border-bottom: none; }
    .wcbpm-product-name { flex: 1; font-size: 14px; color: #333; }
    .wcbpm-edit-btn { font-size: 18px; text-decoration: none; }
    .wcbpm-login-msg {
        background: white;
        border-radius: 16px;
        padding: 40px 24px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    .wcbpm-login-btn {
        display: inline-block;
        padding: 12px 32px;
        background: linear-gradient(135deg, #1a73e8, #0d47a1);
        color: white;
        border-radius: 12px;
        text-decoration: none;
        font-weight: bold;
        margin-top: 12px;
    }
    .wcbpm-upload-status {
        font-size: 13px;
        margin-top: 8px;
        color: #1a73e8;
        display: none;
    }
    .wcbpm-no-products {
        color: #6c757d;
        font-size: 14px;
        text-align: center;
        padding: 16px 0;
    }
    </style>';
}

// ===================================================
// JavaScript
// ===================================================
function wcbpm_get_js() {
    return '
    <script>
    (function($) {
        $(document).ready(function() {

            var uploadedImageId = null;
            var isUploading     = false;

            // آپلود عکس
            $("#wcbpm-image-input").on("change", function() {
                var file = this.files[0];
                if (!file) return;

                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#wcbpm-preview").attr("src", e.target.result).show();
                    $("#wcbpm-placeholder").hide();
                };
                reader.readAsDataURL(file);

                isUploading = true;
                var formData = new FormData();
                formData.append("action", "wcbpm_upload_image");
                formData.append("nonce", wcbpm_ajax.nonce);
                formData.append("image", file);

                $("#wcbpm-upload-status").html("⏳ در حال آپلود عکس...").show();

                $.ajax({
                    url: wcbpm_ajax.ajax_url,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        isUploading = false;
                        if (response.success) {
                            uploadedImageId = response.data.attachment_id;
                            $("#wcbpm-upload-status")
                                .html("✅ عکس آپلود شد!")
                                .css("color", "green");
                            setTimeout(function() {
                                $("#wcbpm-upload-status").hide();
                            }, 2000);
                        } else {
                            $("#wcbpm-upload-status")
                                .html("❌ خطا در آپلود!")
                                .css("color", "red");
                        }
                    },
                    error: function() {
                        isUploading = false;
                        $("#wcbpm-upload-status")
                            .html("❌ خطا در اتصال!")
                            .css("color", "red");
                    }
                });
            });

            // وضعیت انتشار
            $(".wcbpm-status-btn").on("click", function() {
                $(".wcbpm-status-btn").removeClass("active");
                $(this).addClass("active");
                $("#product-status").val($(this).data("status"));
            });

            // ارسال فرم
            $("#wcbpm-form").on("submit", function(e) {
                e.preventDefault();

                if (isUploading) {
                    showAlert("⏳ صبر کنید عکس آپلود شود...", "error");
                    return;
                }

                var title = $("#product-title").val().trim();
                if (!title) {
                    showAlert("❌ عنوان محصول را وارد کنید!", "error");
                    $("#product-title").focus();
                    return;
                }

                setLoading(true);

                $.post(wcbpm_ajax.ajax_url, {
                    action:      "wcbpm_add_product",
                    nonce:       wcbpm_ajax.nonce,
                    title:       title,
                    description: $("#product-desc").val(),
                    price:       $("#product-price").val(),
                    sale_price:  $("#product-sale-price").val(),
                    category:    $("#product-category").val(),
                    stock:       $("#product-stock").val(),
                    status:      $("#product-status").val(),
                    image_id:    uploadedImageId || 0,
                }, function(response) {
                    setLoading(false);
                    if (response.success) {
                        showAlert("🎉 " + response.data.message, "success");
                        resetForm();
                        refreshList();
                        if (navigator.vibrate) navigator.vibrate([100, 50, 100]);
                    } else {
                        showAlert("❌ " + response.data.message, "error");
                    }
                }).fail(function() {
                    setLoading(false);
                    showAlert("❌ خطا در اتصال به سرور!", "error");
                });
            });

            function showAlert(msg, type) {
                var $a = $("#wcbpm-alert");
                $a.removeClass("success error").addClass(type).html(msg).show();
                $("html,body").animate({ scrollTop: 0 }, 300);
                if (type === "success") {
                    setTimeout(function() { $a.fadeOut(); }, 4000);
                }
            }

            function setLoading(isLoading) {
                var $btn = $("#wcbpm-submit");
                if (isLoading) {
                    $btn.prop("disabled", true);
                    $("#wcbpm-btn-text").hide();
                    $("#wcbpm-btn-loader").show();
                } else {
                    $btn.prop("disabled", false);
                    $("#wcbpm-btn-text").show();
                    $("#wcbpm-btn-loader").hide();
                }
            }

            function resetForm() {
                $("#wcbpm-form")[0].reset();
                $("#wcbpm-preview").hide();
                $("#wcbpm-placeholder").show();
                uploadedImageId = null;
                $("#product-status").val("publish");
                $(".wcbpm-status-btn").removeClass("active");
                $(".wcbpm-status-btn[data-status=\"publish\"]").addClass("active");
            }

            function refreshList() {
                $.post(wcbpm_ajax.ajax_url, {
                    action: "wcbpm_get_recent",
                    nonce:  wcbpm_ajax.nonce,
                }, function(response) {
                    if (response.success) {
                        $("#wcbpm-recent-list").html(response.data.html);
                    }
                });
            }

        });
    })(jQuery);
    </script>';
}

// ===================================================
// کلاس اصلی
// ===================================================
class WC_Bale_Product_Manager {

    public function __construct() {
        add_action('plugins_loaded', [$this, 'init']);
        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deactivate']);
    }

    // ===== init =====
    public function init() {
        if (!class_exists('WooCommerce')) {
            add_action('admin_notices', function() {
                echo '<div class="error"><p>⚠️ افزونه نیاز به ووکامرس دارد!</p></div>';
            });
            return;
        }

        // شورت‌کد
        add_shortcode('wcbpm_panel', [$this, 'render_panel']);

        // اسکریپت‌ها
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);

        // AJAX
        add_action('wp_ajax_wcbpm_add_product',  [$this, 'ajax_add_product']);
        add_action('wp_ajax_wcbpm_upload_image',  [$this, 'ajax_upload_image']);
        add_action('wp_ajax_wcbpm_get_recent',    [$this, 'ajax_get_recent']);
        add_action('wp_ajax_wcbpm_set_webhook',   [$this, 'ajax_set_webhook']);

        // ادمین
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);

        // ربات بله Webhook
        add_action('rest_api_init', [$this, 'register_bale_webhook']);
    }

    // ===== فعال‌سازی =====
    public function activate() {
        if (!get_role('product_staff')) {
            add_role('product_staff', 'کارمند محصول', [
                'read'             => true,
                'publish_products' => true,
                'edit_products'    => true,
                'upload_files'     => true,
            ]);
        }

        if (!get_page_by_path('product-panel')) {
            wp_insert_post([
                'post_title'   => 'پنل افزودن محصول',
                'post_name'    => 'product-panel',
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_content' => '[wcbpm_panel]',
            ]);
        }

        flush_rewrite_rules();
    }

    // ===== غیرفعال‌سازی =====
    public function deactivate() {
        flush_rewrite_rules();
    }

    // ===== اسکریپت‌ها =====
    public function enqueue_assets() {
        global $post;
        if (!is_a($post, 'WP_Post') || !has_shortcode($post->post_content, 'wcbpm_panel')) return;

        wp_enqueue_script('jquery');
        wp_localize_script('jquery', 'wcbpm_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('wcbpm_nonce'),
        ]);
    }

    // ===== رندر پنل =====
    public function render_panel() {
        $output = wcbpm_get_css();

        if (!is_user_logged_in()) {
            return $output . '
            <div class="wcbpm-container">
                <div class="wcbpm-login-msg">
                    <p style="font-size:48px;margin:0">🔐</p>
                    <h3>ابتدا وارد شوید</h3>
                    <p>برای افزودن محصول باید وارد حساب کاربری شوید</p>
                    <a href="' . wp_login_url(get_permalink()) . '" class="wcbpm-login-btn">
                        ورود به حساب
                    </a>
                </div>
            </div>' . wcbpm_get_js();
        }

        if (!current_user_can('publish_products')) {
            return $output . '
            <div class="wcbpm-container">
                <div class="wcbpm-login-msg">
                    <p style="font-size:48px;margin:0">🚫</p>
                    <h3>دسترسی ندارید!</h3>
                    <p>شما مجوز افزودن محصول ندارید</p>
                </div>
            </div>';
        }

        $categories = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);

        $output .= '
        <div class="wcbpm-container">

            <div class="wcbpm-header">
                <h2>➕ افزودن محصول</h2>
                <span>👤 ' . esc_html(wp_get_current_user()->display_name) . '</span>
            </div>

            <div class="wcbpm-alert" id="wcbpm-alert"></div>

            <form id="wcbpm-form">

                <div class="wcbpm-field">
                    <label>📷 عکس محصول</label>
                    <div class="wcbpm-image-upload">
                        <div id="wcbpm-placeholder">
                            <span>📸</span>
                            <p>کلیک کنید یا عکس بگیرید</p>
                        </div>
                        <img id="wcbpm-preview" src="" alt="">
                        <input type="file" id="wcbpm-image-input" accept="image/*" capture="environment">
                        <input type="hidden" id="wcbpm-image-id">
                    </div>
                    <div class="wcbpm-upload-status" id="wcbpm-upload-status"></div>
                </div>

                <div class="wcbpm-field">
                    <label for="product-title">📝 عنوان محصول *</label>
                    <input
                        type="text"
                        id="product-title"
                        placeholder="مثال: کفش اسپرت مردانه"
                        required
                    >
                </div>

                <div class="wcbpm-field">
                    <label>💰 قیمت (تومان)</label>
                    <div class="wcbpm-price-row">
                        <div class="wcbpm-price-input">
                            <label for="product-price">قیمت اصلی</label>
                            <input type="number" id="product-price" placeholder="0" min="0">
                        </div>
                        <div class="wcbpm-price-input">
                            <label for="product-sale-price">قیمت تخفیف</label>
                            <input type="number" id="product-sale-price" placeholder="اختیاری" min="0">
                        </div>
                    </div>
                </div>

                <div class="wcbpm-field">
                    <label for="product-category">📂 دسته‌بندی</label>
                    <select id="product-category">
                        <option value="">انتخاب دسته‌بندی...</option>';

        if (!empty($categories) && !is_wp_error($categories)) {
            foreach ($categories as $cat) {
                $output .= '<option value="' . esc_attr($cat->term_id) . '">'
                         . esc_html($cat->name) . '</option>';
            }
        }

        $output .= '
                    </select>
                </div>

                <div class="wcbpm-field">
                    <label for="product-desc">📄 توضیحات</label>
                    <textarea
                        id="product-desc"
                        rows="4"
                        placeholder="توضیحات محصول را بنویسید..."
                    ></textarea>
                </div>

                <div class="wcbpm-field">
                    <label for="product-stock">📦 موجودی</label>
                    <input
                        type="number"
                        id="product-stock"
                        placeholder="تعداد موجودی"
                        min="0"
                    >
                </div>

                <div class="wcbpm-field">
                    <label>📌 وضعیت انتشار</label>
                    <div class="wcbpm-status-buttons">
                        <button type="button" class="wcbpm-status-btn active" data-status="publish">
                            ✅ منتشر شود
                        </button>
                        <button type="button" class="wcbpm-status-btn" data-status="draft">
                            📋 پیش‌نویس
                        </button>
                    </div>
                    <input type="hidden" id="product-status" value="publish">
                </div>

                <button type="submit" class="wcbpm-submit-btn" id="wcbpm-submit">
                    <span id="wcbpm-btn-text">🚀 افزودن محصول</span>
                    <span id="wcbpm-btn-loader" style="display:none">⏳ در حال ثبت...</span>
                </button>

            </form>

            <div class="wcbpm-recent">
                <h3>📋 محصولات اخیر</h3>
                <div id="wcbpm-recent-list">' . $this->get_recent_html() . '</div>
            </div>

        </div>';

        return $output . wcbpm_get_js();
    }

    // ===== محصولات اخیر =====
    private function get_recent_html() {
        $products = wc_get_products([
            'limit'   => 5,
            'orderby' => 'date',
            'order'   => 'DESC',
            'author'  => get_current_user_id(),
        ]);

        if (empty($products)) {
            return '<p class="wcbpm-no-products">هنوز محصولی اضافه نکردید 😊</p>';
        }

        $html = '<ul class="wcbpm-product-list">';
        foreach ($products as $p) {
            $icon  = $p->get_status() === 'publish' ? '✅' : '📋';
            $html .= '<li>
                <span>' . $icon . '</span>
                <span class="wcbpm-product-name">' . esc_html($p->get_name()) . '</span>
                <a href="' . esc_url(get_edit_post_link($p->get_id())) . '" class="wcbpm-edit-btn" target="_blank">✏️</a>
            </li>';
        }
        return $html . '</ul>';
    }

    // ===== AJAX افزودن محصول =====
    public function ajax_add_product() {
        check_ajax_referer('wcbpm_nonce', 'nonce');

        if (!current_user_can('publish_products')) {
            wp_send_json_error(['message' => 'دسترسی ندارید!']);
        }

        $title      = sanitize_text_field($_POST['title'] ?? '');
        $desc       = sanitize_textarea_field($_POST['description'] ?? '');
        $price      = floatval($_POST['price'] ?? 0);
        $sale_price = floatval($_POST['sale_price'] ?? 0);
        $category   = intval($_POST['category'] ?? 0);
        $stock      = intval($_POST['stock'] ?? 0);
        $status     = in_array($_POST['status'] ?? '', ['publish', 'draft']) ? $_POST['status'] : 'publish';
        $image_id   = intval($_POST['image_id'] ?? 0);

        if (empty($title)) {
            wp_send_json_error(['message' => 'عنوان الزامی است!']);
        }

        $product = new WC_Product_Simple();
        $product->set_name($title);
        $product->set_description($desc);
        $product->set_status($status);

        if ($price > 0)      $product->set_regular_price($price);
        if ($sale_price > 0) $product->set_sale_price($sale_price);
        if ($stock > 0) {
            $product->set_manage_stock(true);
            $product->set_stock_quantity($stock);
        }
        if ($category > 0) $product->set_category_ids([$category]);
        if ($image_id > 0)  $product->set_image_id($image_id);

        $id = $product->save();

        if ($id) {
            wp_send_json_success(['message' => 'محصول با موفقیت اضافه شد! 🎉']);
        } else {
            wp_send_json_error(['message' => 'خطا در ثبت محصول!']);
        }
    }

    // ===== AJAX آپلود عکس =====
    public function ajax_upload_image() {
        check_ajax_referer('wcbpm_nonce', 'nonce');

        if (!current_user_can('upload_files')) {
            wp_send_json_error(['message' => 'دسترسی ندارید!']);
        }

        if (empty($_FILES['image'])) {
            wp_send_json_error(['message' => 'فایلی انتخاب نشده!']);
        }

        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $id = media_handle_upload('image', 0);

        if (is_wp_error($id)) {
            wp_send_json_error(['message' => 'خطا در آپلود تصویر!']);
        }

        wp_send_json_success([
            'attachment_id' => $id,
            'url'           => wp_get_attachment_url($id),
        ]);
    }

    // ===== AJAX محصولات اخیر =====
    public function ajax_get_recent() {
        check_ajax_referer('wcbpm_nonce', 'nonce');
        wp_send_json_success(['html' => $this->get_recent_html()]);
    }

    // ===================================================
    // ربات بله
    // ===================================================
    public function register_bale_webhook() {
        register_rest_route('wcbpm/v1', '/bale', [
            'methods'             => 'POST',
            'callback'            => [$this, 'handle_bale_webhook'],
            'permission_callback' => '__return_true',
        ]);
    }

    public function handle_bale_webhook(WP_REST_Request $request) {
        $update = $request->get_json_params();

        if (!empty($update['message'])) {
            $this->bale_process_message($update['message']);
        }

        if (!empty($update['callback_query'])) {
            $this->bale_process_callback($update['callback_query']);
        }

        return new WP_REST_Response('OK', 200);
    }

    private function bale_process_message($message) {
        $chat_id = $message['chat']['id'];
        $text    = $message['text'] ?? '';
        $photo   = $message['photo'] ?? null;

        // چک دسترسی
        $allowed_raw = get_option('wcbpm_allowed_chats', '');

		// اگه آرایه بود
		if (is_array($allowed_raw)) {
			$allowed = $allowed_raw;
		} else {
			// اگه متن بود خط به خط جدا کن
			$allowed = array_filter(array_map('trim', explode("\n", $allowed_raw)));
		}

		$allowed = array_map('strval', $allowed);
		$chat_id_str = (string)$chat_id;

			// لاگ برای دیباگ
			error_log('WCBPM - Chat ID: ' . $chat_id_str);
			error_log('WCBPM - Allowed: ' . implode(', ', $allowed));

if (!in_array($chat_id_str, $allowed)) {
    $this->bale_send($chat_id, 
        "❌ دسترسی ندارید!\n\n" .
        "Chat ID شما: " . $chat_id_str . "\n" .
        "این عدد رو به ادمین بدید"
    );
    return;
}
        $session = get_transient('wcbpm_bale_' . $chat_id) ?: ['step' => 'idle', 'data' => []];

        // دستورات
        if ($text === '/start' || $text === '/add') {
            $session = ['step' => 'title', 'data' => []];
            set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
            $this->bale_send($chat_id,
                "🛍 افزودن محصول جدید\n\n" .
                "📝 مرحله ۱ از ۵\n" .
                "عنوان محصول را بنویسید:\n\n" .
                "برای لغو /cancel بزنید"
            );
            return;
        }

        if ($text === '/cancel') {
            delete_transient('wcbpm_bale_' . $chat_id);
            $this->bale_send($chat_id, '❌ عملیات لغو شد.');
            return;
        }

        if ($text === '/list') {
            $this->bale_send_recent($chat_id);
            return;
        }

        if ($session['step'] === 'idle' || $text === '/help') {
            $this->bale_send($chat_id,
                "👋 سلام!\n\n" .
                "دستورات:\n" .
                "➕ /add - افزودن محصول جدید\n" .
                "📋 /list - محصولات اخیر\n" .
                "❌ /cancel - لغو عملیات\n" .
                "❓ /help - راهنما"
            );
            return;
        }

        $this->bale_process_step($chat_id, $session, $text, $photo);
    }

    private function bale_process_step($chat_id, $session, $text, $photo) {
        $step = $session['step'];
        $data = $session['data'];

        switch ($step) {

            case 'title':
                $data['title'] = $text;
                $session = ['step' => 'price', 'data' => $data];
                set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
                $this->bale_send($chat_id,
                    "✅ عنوان ثبت شد!\n\n" .
                    "💰 مرحله ۲ از ۵\n" .
                    "قیمت را وارد کنید (تومان):\n" .
                    "برای رد کردن عدد 0 بزنید"
                );
                break;

            case 'price':
                $data['price'] = is_numeric($text) ? floatval($text) : 0;
                $session = ['step' => 'category', 'data' => $data];
                set_transient('wcbpm_bale_' . $chat_id, $session, 3600);

                $cats     = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
                $keyboard = [];
                foreach ((array)$cats as $cat) {
                    $keyboard[] = [[
                        'text'          => $cat->name,
                        'callback_data' => 'cat_' . $cat->term_id,
                    ]];
                }
                $keyboard[] = [['text' => '⏭ بدون دسته‌بندی', 'callback_data' => 'cat_0']];

                $this->bale_send($chat_id,
                    "✅ قیمت ثبت شد!\n\n" .
                    "📂 مرحله ۳ از ۵\n" .
                    "دسته‌بندی را انتخاب کنید:",
                    $keyboard
                );
                break;

            case 'description':
                $data['description'] = ($text === '0') ? '' : $text;
                $session = ['step' => 'photo', 'data' => $data];
                set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
                $this->bale_send($chat_id,
                    "✅ توضیحات ثبت شد!\n\n" .
                    "📸 مرحله ۵ از ۵\n" .
                    "عکس محصول را ارسال کنید:\n" .
                    "برای رد کردن عدد 0 بزنید"
                );
                break;

            case 'photo':
                if ($photo) {
                    $file_id          = end($photo)['file_id'];
                    $data['image_id'] = $this->bale_upload_photo($file_id);
                }
                $this->bale_create_product($chat_id, $data);
                delete_transient('wcbpm_bale_' . $chat_id);
                break;
        }
    }

    private function bale_process_callback($callback) {
        $chat_id  = $callback['message']['chat']['id'];
        $data_str = $callback['data'];

        if (strpos($data_str, 'cat_') === 0) {
            $cat_id  = intval(str_replace('cat_', '', $data_str));
            $session = get_transient('wcbpm_bale_' . $chat_id) ?: ['step' => 'idle', 'data' => []];
            $data    = $session['data'];

            $data['category'] = $cat_id;
            $session = ['step' => 'description', 'data' => $data];
            set_transient('wcbpm_bale_' . $chat_id, $session, 3600);

            $this->bale_send($chat_id,
                "✅ دسته‌بندی ثبت شد!\n\n" .
                "📄 مرحله ۴ از ۵\n" .
                "توضیحات محصول را بنویسید:\n" .
                "برای رد کردن عدد 0 بزنید"
            );
        }

        // پاسخ به callback
        $token = get_option('wcbpm_bale_token', '');
        if ($token) {
            wp_remote_post(
                "https://tapi.bale.ai/bot{$token}/answerCallbackQuery",
                [
                    'body'    => ['callback_query_id' => $callback['id']],
                    'timeout' => 10,
                ]
            );
        }
    }

    private function bale_create_product($chat_id, $data) {
        $product = new WC_Product_Simple();
        $product->set_name($data['title']);
        $product->set_status('publish');

        if (!empty($data['description']))                        $product->set_description($data['description']);
        if (!empty($data['price']) && $data['price'] > 0)       $product->set_regular_price($data['price']);
        if (!empty($data['category']) && $data['category'] > 0) $product->set_category_ids([$data['category']]);
        if (!empty($data['image_id']))                           $product->set_image_id($data['image_id']);

        $id = $product->save();

        if ($id) {
            $this->bale_send($chat_id,
                "🎉 محصول با موفقیت اضافه شد!\n\n" .
                "📦 " . $data['title'] . "\n\n" .
                "برای افزودن محصول جدید /add را بزنید"
            );
        } else {
            $this->bale_send($chat_id, '❌ خطا در ایجاد محصول! دوباره تلاش کنید.');
        }
    }

    private function bale_upload_photo($file_id) {
        $token    = get_option('wcbpm_bale_token', '');
        $response = wp_remote_get(
            "https://tapi.bale.ai/bot{$token}/getFile?file_id={$file_id}",
            ['timeout' => 15]
        );

        $result = json_decode(wp_remote_retrieve_body($response), true);
        $path   = $result['result']['file_path'] ?? null;
        if (!$path) return null;

        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $tmp = download_url("https://tapi.bale.ai/file/bot{$token}/{$path}");
        if (is_wp_error($tmp)) return null;

        $file_array = [
            'name'     => 'bale-' . time() . '.jpg',
            'tmp_name' => $tmp,
        ];

        $attachment_id = media_handle_sideload($file_array, 0);
        @unlink($tmp);

        return is_wp_error($attachment_id) ? null : $attachment_id;
    }

    private function bale_send_recent($chat_id) {
        $products = wc_get_products(['limit' => 5, 'orderby' => 'date', 'order' => 'DESC']);

        if (empty($products)) {
            $this->bale_send($chat_id, '📋 هنوز محصولی ثبت نشده!');
            return;
        }

        $text = "📋 آخرین محصولات:\n\n";
        foreach ($products as $p) {
            $text .= "• " . $p->get_name() . "\n";
        }
        $this->bale_send($chat_id, $text);
    }

    public function bale_send($chat_id, $text, $keyboard = null) {
        $token = get_option('wcbpm_bale_token', '');
        if (empty($token)) return;

        $body = [
            'chat_id' => $chat_id,
            'text'    => $text,
        ];

        if ($keyboard) {
            $body['reply_markup'] = json_encode(['inline_keyboard' => $keyboard]);
        }

        wp_remote_post("https://tapi.bale.ai/bot{$token}/sendMessage", [
            'body'    => $body,
            'timeout' => 15,
        ]);
    }

    // ===================================================
    // صفحه ادمین
    // ===================================================
    public function add_admin_menu() {
        add_menu_page(
            'محصول آسان با بله',
            '🛍 محصول آسان',
            'manage_options',
            'wcbpm-settings',
            [$this, 'render_settings_page'],
            'dashicons-smartphone',
            30
        );
    }

    public function register_settings() {
        register_setting('wcbpm_settings', 'wcbpm_bale_token',   'sanitize_text_field');
        register_setting('wcbpm_settings', 'wcbpm_allowed_chats');
    }

    public function ajax_set_webhook() {
        check_ajax_referer('wcbpm_webhook', 'nonce');

        $token       = get_option('wcbpm_bale_token', '');
        $webhook_url = rest_url('wcbpm/v1/bale');

        if (empty($token)) {
            wp_send_json_error(['message' => 'توکن ربات بله وارد نشده!']);
        }

        $response = wp_remote_post(
            "https://tapi.bale.ai/bot{$token}/setWebhook",
            [
                'body'    => ['url' => $webhook_url],
                'timeout' => 15,
            ]
        );

        $result = json_decode(wp_remote_retrieve_body($response), true);

        if (!empty($result['ok'])) {
            wp_send_json_success(['message' => 'Webhook ربات بله با موفقیت ثبت شد!']);
        } else {
            wp_send_json_error(['message' => $result['description'] ?? 'خطا در ثبت Webhook']);
        }
    }

    public function render_settings_page() {
        $token         = get_option('wcbpm_bale_token', '');
        $allowed_chats = (array) get_option('wcbpm_allowed_chats', []);
        $webhook_url   = rest_url('wcbpm/v1/bale');
        $panel_url     = home_url('/product-panel/');
        ?>
        <div class="wrap" dir="rtl" style="font-family:Tahoma;">
            <h1>🛍 محصول آسان - پنل مدیریت</h1>

            <!-- پنل موبایل -->
            <div class="card" style="max-width:650px;padding:20px;margin-bottom:20px;">
                <h2>📱 پنل موبایل کارمندان</h2>
                <p>کارمندان از این لینک میتوانند محصول اضافه کنند:</p>
                <code style="background:#f0f0f0;padding:10px 14px;border-radius:6px;display:block;font-size:14px;margin:8px 0;">
                    <?php echo esc_url($panel_url); ?>
                </code>
                <p style="margin-top:12px;">
                    <a href="<?php echo esc_url($panel_url); ?>" target="_blank" class="button button-primary">
                        🔗 مشاهده پنل موبایل
                    </a>
                    &nbsp;
                    <a href="<?php echo esc_url(admin_url('user-new.php')); ?>" class="button">
                        👤 افزودن کارمند جدید
                    </a>
                </p>
            </div>

            <!-- تنظیمات ربات بله -->
            <div class="card" style="max-width:650px;padding:20px;margin-bottom:20px;">
                <h2>🤖 تنظیمات ربات بله</h2>
                <form method="post" action="options.php">
                    <?php settings_fields('wcbpm_settings'); ?>
                    <table class="form-table">

                        <tr>
                            <th scope="row">توکن ربات بله</th>
                            <td>
                                <input
                                    type="text"
                                    name="wcbpm_bale_token"
                                    value="<?php echo esc_attr($token); ?>"
                                    style="width:400px;"
                                    placeholder="توکن ربات بله را اینجا وارد کنید"
                                >
                                <p class="description" style="margin-top:8px;">
                                    ⚠️ این توکن ربات <strong>بله</strong> است نه تلگرام!<br><br>
                                    📌 راهنمای دریافت توکن بله:<br>
                                    ۱. اپ بله رو باز کن<br>
                                    ۲. سرچ کن: BaleBot@<br>
                                    ۳. بنویس: /newbot<br>
                                    ۴. یک اسم برای ربات بده<br>
                                    ۵. توکن رو کپی کن و اینجا بذار
                                </p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">Chat ID کارمندان بله</th>
                            <td>
                                <textarea
                                    name="wcbpm_allowed_chats"
                                    rows="5"
                                    style="width:400px;"
                                    placeholder="هر Chat ID در یک خط&#10;مثال:&#10;123456789&#10;987654321"
                                ><?php echo esc_textarea(implode("\n", $allowed_chats)); ?></textarea>
                                <p class="description" style="margin-top:8px;">
                                    📌 برای دریافت Chat ID بله:<br>
                                    ۱. توی بله سرچ کن: BaleBot@<br>
                                    ۲. بنویس: /chatid<br>
                                    ۳. عدد رو کپی کن اینجا بذار
                                </p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">آدرس Webhook بله</th>
                            <td>
                                <code style="background:#f0f0f0;padding:6px 10px;border-radius:4px;display:block;margin-bottom:10px;">
                                    <?php echo esc_url($webhook_url); ?>
                                </code>
                                <button type="button" class="button button-primary" id="wcbpm-set-webhook">
                                    ✅ ثبت Webhook ربات بله
                                </button>
                                <span id="wcbpm-webhook-result" style="margin-right:12px;font-weight:bold;font-size:14px;"></span>
                            </td>
                        </tr>

                    </table>
                    <?php submit_button('💾 ذخیره تنظیمات'); ?>
                </form>
            </div>

            <!-- لیست کارمندان -->
            <div class="card" style="max-width:650px;padding:20px;">
                <h2>👥 کارمندان محصول</h2>
                <?php
                $staff = get_users(['role' => 'product_staff']);
                if (empty($staff)) {
                    echo '<p style="color:#666;">هنوز کارمندی اضافه نشده است.</p>';
                } else {
                    echo '<table class="wp-list-table widefat fixed striped">
                        <thead>
                            <tr>
                                <th>نام</th>
                                <th>ایمیل</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>';
                    foreach ($staff as $u) {
                        echo '<tr>
                            <td>' . esc_html($u->display_name) . '</td>
                            <td>' . esc_html($u->user_email) . '</td>
                            <td>
                                <a href="' . esc_url(get_edit_user_link($u->ID)) . '">✏️ ویرایش</a>
                            </td>
                        </tr>';
                    }
                    echo '</tbody></table>';
                }
                ?>
                <p style="margin-top:16px;">
                    <a href="<?php echo esc_url(admin_url('user-new.php')); ?>" class="button button-primary">
                        ➕ افزودن کارمند جدید
                    </a>
                </p>
            </div>

        </div>

        <script>
        document.getElementById('wcbpm-set-webhook').addEventListener('click', function() {
            var btn    = this;
            var result = document.getElementById('wcbpm-webhook-result');

            btn.disabled       = true;
            result.textContent = '⏳ در حال ثبت Webhook ربات بله...';
            result.style.color = '#666';

            var fd = new FormData();
            fd.append('action', 'wcbpm_set_webhook');
            fd.append('nonce', '<?php echo wp_create_nonce('wcbpm_webhook'); ?>');

            fetch(ajaxurl, { method: 'POST', body: fd })
                .then(function(r) { return r.json(); })
                .then(function(d) {
                    btn.disabled = false;
                    if (d.success) {
                        result.textContent = '✅ ' + d.data.message;
                        result.style.color = 'green';
                    } else {
                        result.textContent = '❌ ' + d.data.message;
                        result.style.color = 'red';
                    }
                })
                .catch(function() {
                    btn.disabled       = false;
                    result.textContent = '❌ خطا در اتصال!';
                    result.style.color = 'red';
                });
        });
        </script>
        <?php
    }
}

// اجرا
new WC_Bale_Product_Manager();