<?php
/**
 * Plugin Name: WC Bale Product Manager
 * Plugin URI: #
 * Description: افزودن ساده محصول از گوشی + ربات بله
 * Version: 1.0.1
 * Author: Admin
 * Requires at least: 5.0
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) exit;

define('WCBPM_VERSION', '1.0.1');
define('WCBPM_PATH', plugin_dir_path(__FILE__));
define('WCBPM_URL', plugin_dir_url(__FILE__));

function wcbpm_get_css() {
    return '
    <style>
    * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
    .wcbpm-container {
        max-width: 500px; margin: 0 auto; padding: 16px;
        font-family: Tahoma, sans-serif; direction: rtl;
        background: #f5f5f5; min-height: 100vh;
    }
    .wcbpm-header {
        background: linear-gradient(135deg, #1a73e8, #0d47a1);
        color: white; padding: 16px; border-radius: 16px;
        margin-bottom: 16px; display: flex;
        justify-content: space-between; align-items: center;
    }
    .wcbpm-header h2 { margin: 0; font-size: 18px; }
    .wcbpm-alert {
        padding: 12px 16px; border-radius: 12px;
        margin-bottom: 16px; font-size: 14px;
        text-align: center; display: none;
    }
    .wcbpm-alert.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .wcbpm-alert.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    .wcbpm-field {
        background: white; border-radius: 16px; padding: 16px;
        margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    .wcbpm-field label { display: block; font-size: 14px; font-weight: bold; color: #333; margin-bottom: 8px; }
    .wcbpm-field input[type="text"],
    .wcbpm-field input[type="number"],
    .wcbpm-field textarea,
    .wcbpm-field select {
        width: 100%; padding: 12px; border: 2px solid #e9ecef;
        border-radius: 12px; font-size: 16px; font-family: Tahoma, sans-serif;
        direction: rtl; outline: none; transition: border-color 0.2s;
        background: #fafafa; -webkit-appearance: none;
    }
    .wcbpm-field input:focus, .wcbpm-field textarea:focus, .wcbpm-field select:focus {
        border-color: #1a73e8; background: white;
    }
    .wcbpm-image-upload {
        position: relative; border: 3px dashed #dee2e6; border-radius: 16px;
        padding: 24px; text-align: center; cursor: pointer;
        background: #fafafa; min-height: 120px;
    }
    .wcbpm-image-placeholder span { font-size: 40px; display: block; }
    .wcbpm-image-placeholder p { margin: 8px 0 0; color: #6c757d; font-size: 14px; }
    .wcbpm-image-upload input[type="file"] {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        opacity: 0; cursor: pointer; z-index: 2;
    }
    #wcbpm-preview { width: 100%; border-radius: 12px; max-height: 200px; object-fit: cover; display: none; }
    .wcbpm-price-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .wcbpm-price-input label { font-size: 12px; color: #6c757d; font-weight: normal; margin-bottom: 4px; display: block; }
    .wcbpm-status-buttons { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 4px; }
    .wcbpm-status-btn {
        padding: 12px; border: 2px solid #e9ecef; border-radius: 12px;
        background: #fafafa; font-size: 15px; cursor: pointer;
        transition: all 0.2s; font-family: Tahoma, sans-serif; text-align: center;
    }
    .wcbpm-status-btn.active { border-color: #1a73e8; background: #e8f0fe; color: #1a73e8; font-weight: bold; }
    .wcbpm-submit-btn {
        width: 100%; padding: 18px;
        background: linear-gradient(135deg, #1a73e8, #0d47a1);
        color: white; border: none; border-radius: 16px; font-size: 18px;
        font-family: Tahoma, sans-serif; font-weight: bold; cursor: pointer;
        box-shadow: 0 4px 15px rgba(26,115,232,0.4); margin-top: 8px;
    }
    .wcbpm-submit-btn:active { transform: scale(0.98); }
    .wcbpm-submit-btn:disabled { opacity: 0.7; cursor: not-allowed; }
    .wcbpm-recent { background: white; border-radius: 16px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-top: 16px; }
    .wcbpm-recent h3 { margin: 0 0 12px; font-size: 15px; color: #333; }
    .wcbpm-product-list { list-style: none; margin: 0; padding: 0; }
    .wcbpm-product-list li { display: flex; align-items: center; padding: 10px 0; border-bottom: 1px solid #f0f0f0; gap: 8px; }
    .wcbpm-product-list li:last-child { border-bottom: none; }
    .wcbpm-product-name { flex: 1; font-size: 14px; color: #333; }
    .wcbpm-edit-btn { font-size: 18px; text-decoration: none; }
    .wcbpm-login-msg { background: white; border-radius: 16px; padding: 40px 24px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
    .wcbpm-login-btn {
        display: inline-block; padding: 12px 32px;
        background: linear-gradient(135deg, #1a73e8, #0d47a1);
        color: white; border-radius: 12px; text-decoration: none; font-weight: bold; margin-top: 12px;
    }
    .wcbpm-upload-status { font-size: 13px; margin-top: 8px; color: #1a73e8; display: none; }
    .wcbpm-no-products { color: #6c757d; font-size: 14px; text-align: center; padding: 16px 0; }
    </style>';
}

function wcbpm_get_js() {
    return '
    <script>
    (function($) {
        $(document).ready(function() {
            var uploadedImageId = null;
            var isUploading = false;

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
                    url: wcbpm_ajax.ajax_url, type: "POST", data: formData,
                    processData: false, contentType: false,
                    success: function(response) {
                        isUploading = false;
                        if (response.success) {
                            uploadedImageId = response.data.attachment_id;
                            $("#wcbpm-upload-status").html("✅ عکس آپلود شد!").css("color", "green");
                            setTimeout(function() { $("#wcbpm-upload-status").hide(); }, 2000);
                        } else {
                            $("#wcbpm-upload-status").html("❌ خطا در آپلود!").css("color", "red");
                        }
                    },
                    error: function() {
                        isUploading = false;
                        $("#wcbpm-upload-status").html("❌ خطا در اتصال!").css("color", "red");
                    }
                });
            });

            $(".wcbpm-status-btn").on("click", function() {
                $(".wcbpm-status-btn").removeClass("active");
                $(this).addClass("active");
                $("#product-status").val($(this).data("status"));
            });

            $("#wcbpm-form").on("submit", function(e) {
                e.preventDefault();
                if (isUploading) { showAlert("⏳ صبر کنید عکس آپلود شود...", "error"); return; }
                var title = $("#product-title").val().trim();
                if (!title) { showAlert("❌ عنوان محصول را وارد کنید!", "error"); $("#product-title").focus(); return; }
                setLoading(true);
                $.post(wcbpm_ajax.ajax_url, {
                    action: "wcbpm_add_product", nonce: wcbpm_ajax.nonce,
                    title: title, description: $("#product-desc").val(),
                    price: $("#product-price").val(), sale_price: $("#product-sale-price").val(),
                    category: $("#product-category").val(), stock: $("#product-stock").val(),
                    status: $("#product-status").val(), image_id: uploadedImageId || 0,
                }, function(response) {
                    setLoading(false);
                    if (response.success) {
                        showAlert("🎉 " + response.data.message, "success");
                        resetForm(); refreshList();
                        if (navigator.vibrate) navigator.vibrate([100, 50, 100]);
                    } else { showAlert("❌ " + response.data.message, "error"); }
                }).fail(function() { setLoading(false); showAlert("❌ خطا در اتصال به سرور!", "error"); });
            });

            function showAlert(msg, type) {
                var $a = $("#wcbpm-alert");
                $a.removeClass("success error").addClass(type).html(msg).show();
                $("html,body").animate({ scrollTop: 0 }, 300);
                if (type === "success") setTimeout(function() { $a.fadeOut(); }, 4000);
            }

            function setLoading(isLoading) {
                var $btn = $("#wcbpm-submit");
                if (isLoading) { $btn.prop("disabled", true); $("#wcbpm-btn-text").hide(); $("#wcbpm-btn-loader").show(); }
                else { $btn.prop("disabled", false); $("#wcbpm-btn-text").show(); $("#wcbpm-btn-loader").hide(); }
            }

            function resetForm() {
                $("#wcbpm-form")[0].reset();
                $("#wcbpm-preview").hide(); $("#wcbpm-placeholder").show();
                uploadedImageId = null; $("#product-status").val("publish");
                $(".wcbpm-status-btn").removeClass("active");
                $(".wcbpm-status-btn[data-status=\"publish\"]").addClass("active");
            }

            function refreshList() {
                $.post(wcbpm_ajax.ajax_url, { action: "wcbpm_get_recent", nonce: wcbpm_ajax.nonce },
                function(response) { if (response.success) { $("#wcbpm-recent-list").html(response.data.html); } });
            }
        });
    })(jQuery);
    </script>';
}

class WC_Bale_Product_Manager {

    public function __construct() {
        add_action('plugins_loaded', [$this, 'init']);
        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deactivate']);
    }

    public function init() {
        if (!class_exists('WooCommerce')) {
            add_action('admin_notices', function() {
                echo '<div class="error"><p>⚠️ افزونه نیاز به ووکامرس دارد!</p></div>';
            });
            return;
        }

        add_shortcode('wcbpm_panel', [$this, 'render_panel']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('wp_ajax_wcbpm_add_product',  [$this, 'ajax_add_product']);
        add_action('wp_ajax_wcbpm_upload_image',  [$this, 'ajax_upload_image']);
        add_action('wp_ajax_wcbpm_get_recent',    [$this, 'ajax_get_recent']);
        add_action('wp_ajax_wcbpm_set_webhook',   [$this, 'ajax_set_webhook']);
        add_action('admin_menu',  [$this, 'add_admin_menu']);
        add_action('admin_init',  [$this, 'register_settings']);
        add_action('rest_api_init', [$this, 'register_bale_webhook']);
    }

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

    public function deactivate() {
        flush_rewrite_rules();
    }

    public function enqueue_assets() {
        global $post;
        if (!is_a($post, 'WP_Post') || !has_shortcode($post->post_content, 'wcbpm_panel')) return;
        wp_enqueue_script('jquery');
        wp_localize_script('jquery', 'wcbpm_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('wcbpm_nonce'),
        ]);
    }

    public function render_panel() {
        $output = wcbpm_get_css();

        if (!is_user_logged_in()) {
            return $output . '
            <div class="wcbpm-container">
                <div class="wcbpm-login-msg">
                    <p style="font-size:48px;margin:0">🔐</p>
                    <h3>ابتدا وارد شوید</h3>
                    <a href="' . wp_login_url(get_permalink()) . '" class="wcbpm-login-btn">ورود به حساب</a>
                </div>
            </div>' . wcbpm_get_js();
        }

        if (!current_user_can('publish_products')) {
            return $output . '
            <div class="wcbpm-container">
                <div class="wcbpm-login-msg">
                    <p style="font-size:48px;margin:0">🚫</p>
                    <h3>دسترسی ندارید!</h3>
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
                    <input type="text" id="product-title" placeholder="مثال: کفش اسپرت مردانه" required>
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
                $output .= '<option value="' . esc_attr($cat->term_id) . '">' . esc_html($cat->name) . '</option>';
            }
        }

        $output .= '
                    </select>
                </div>
                <div class="wcbpm-field">
                    <label for="product-desc">📄 توضیحات</label>
                    <textarea id="product-desc" rows="4" placeholder="توضیحات محصول را بنویسید..."></textarea>
                </div>
                <div class="wcbpm-field">
                    <label for="product-stock">📦 موجودی</label>
                    <input type="number" id="product-stock" placeholder="تعداد موجودی" min="0">
                </div>
                <div class="wcbpm-field">
                    <label>📌 وضعیت انتشار</label>
                    <div class="wcbpm-status-buttons">
                        <button type="button" class="wcbpm-status-btn active" data-status="publish">✅ منتشر شود</button>
                        <button type="button" class="wcbpm-status-btn" data-status="draft">📋 پیش‌نویس</button>
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

        if (empty($title)) { wp_send_json_error(['message' => 'عنوان الزامی است!']); }

        $product = new WC_Product_Simple();
        $product->set_name($title);
        $product->set_description($desc);
        $product->set_status($status);
        if ($price > 0)      $product->set_regular_price($price);
        if ($sale_price > 0) $product->set_sale_price($sale_price);
        if ($stock > 0) { $product->set_manage_stock(true); $product->set_stock_quantity($stock); }
        if ($category > 0)  $product->set_category_ids([$category]);
        if ($image_id > 0)  $product->set_image_id($image_id);

        $id = $product->save();
        if ($id) { wp_send_json_success(['message' => 'محصول با موفقیت اضافه شد! 🎉']); }
        else { wp_send_json_error(['message' => 'خطا در ثبت محصول!']); }
    }

    public function ajax_upload_image() {
        check_ajax_referer('wcbpm_nonce', 'nonce');
        if (!current_user_can('upload_files')) { wp_send_json_error(['message' => 'دسترسی ندارید!']); }
        if (empty($_FILES['image'])) { wp_send_json_error(['message' => 'فایلی انتخاب نشده!']); }

        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $id = media_handle_upload('image', 0);
        if (is_wp_error($id)) { wp_send_json_error(['message' => 'خطا در آپلود تصویر!']); }
        wp_send_json_success(['attachment_id' => $id, 'url' => wp_get_attachment_url($id)]);
    }

    public function ajax_get_recent() {
        check_ajax_referer('wcbpm_nonce', 'nonce');
        wp_send_json_success(['html' => $this->get_recent_html()]);
    }

    // ===== ربات بله =====
    public function register_bale_webhook() {
        register_rest_route('wcbpm/v1', '/bale', [
            'methods'             => 'POST',
            'callback'            => [$this, 'handle_bale_webhook'],
            'permission_callback' => '__return_true',
        ]);
    }

    public function handle_bale_webhook(WP_REST_Request $request) {
        file_put_contents(ABSPATH . 'bale-test.txt', 'Webhook hit at ' . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
        $update = $request->get_json_params();
        error_log('WCBPM Update: ' . print_r($update, true));

        if (!empty($update['callback_query'])) {
            $this->bale_process_callback($update['callback_query']);
            return new WP_REST_Response('OK', 200);
        }

        if (!empty($update['message'])) {
            $this->bale_process_message($update['message']);
        }

        return new WP_REST_Response('OK', 200);
    }

    public function bale_process_message($message) {
        $chat_id = $message['chat']['id'];
        $text    = $message['text'] ?? '';
        $photo   = $message['photo'] ?? null;
        
        file_put_contents(ABSPATH . 'bale-debug.txt', "MESSAGE RECEIVED | ChatID: " . $chat_id . " | Text: " . $text . "\n", FILE_APPEND);

        // چک دسترسی
        $allowed_raw = get_option('wcbpm_allowed_chats', '');
        if (is_array($allowed_raw)) {
            $allowed = $allowed_raw;
        } else {
            $allowed = array_filter(array_map('trim', explode("\n", $allowed_raw)));
        }
        $allowed = array_map('strval', $allowed);

        if (!in_array((string)$chat_id, $allowed)) {
            $this->bale_send($chat_id, "❌ دسترسی ندارید!\n\nChat ID شما: " . $chat_id . "\nاین عدد رو به ادمین بدید");
            return;
        }

        // گرفتن سشن
        $session = get_transient('wcbpm_bale_' . $chat_id);
        if (!$session) {
            $session = ['step' => 'idle', 'data' => []];
        }

        if ($text === '/start' || $text === '/add') {
            $session = ['step' => 'title', 'data' => []];
            set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
            $this->bale_send($chat_id, "🛍 افزودن محصول جدید\n\n📝 مرحله ۱ از ۴\nعنوان محصول را بنویسید:\n\nبرای لغو /cancel بزنید");
            return;
        }

        if ($text === '/cancel') {
            delete_transient('wcbpm_bale_' . $chat_id);
            $this->bale_send($chat_id, "❌ عملیات لغو شد.");
            return;
        }

        if ($text === '/list') {
            $this->bale_send_recent($chat_id);
            return;
        }

        if ($session['step'] === 'idle' || $text === '/help') {
            $this->bale_send($chat_id, "👋 سلام!\n\nدستورات:\n➕ /add - افزودن محصول جدید\n📋 /list - محصولات اخیر\n❌ /cancel - لغو عملیات\n❓ /help - راهنما");
            return;
        }

        // ارسال به مرحله بعدی
        $this->bale_process_step($chat_id, $session, $text, $photo);
    }

    public function bale_process_step($chat_id, $session, $text, $photo) {
        $step = $session['step'];
        $data = $session['data'];

        // تبدیل خودکار اعداد فارسی به انگلیسی برای جلوگیری از خطای کیبورد
        $persian_nums = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english_nums = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $text_clean = str_replace($persian_nums, $english_nums, $text);
        
        $text_lower = strtolower(trim($text_clean));

        // ==========================================
        // 🔙 سیستم بازگشت به مرحله قبل (ویرایش مراحل)
        // ==========================================
        if ($text_lower === '/back') {
            if ($step === 'title') {
                $this->bale_send($chat_id, "شما در مرحله اول هستید. برای لغو کامل عملیات، دستور /cancel را بفرستید.");
                return;
            } elseif ($step === 'category_hierarchy') {
                $session['step'] = 'title';
                set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
                $current_title = $data['title'] ?? 'نامشخص';
                $this->bale_send($chat_id, "🔙 برگشتیم به مرحله قبل!\n\n📝 مرحله ۱ از ۴\nعنوان جدید محصول را بنویسید:\n(عنوان قبلی شما: {$current_title})");
                return;
            } elseif ($step === 'description') {
                $data['current_parent'] = 0;
                $data['page'] = 1;
                $session['step'] = 'category_hierarchy';
                $session['data'] = $data;
                $header_msg = "🔙 برگشتیم به انتخاب دسته‌بندی!\n\n📂 مرحله ۲ از ۴\nدسته‌بندی اصلی (مادر) را انتخاب کنید:\n\n";
                $this->bale_render_category_page($chat_id, $session['data'], $header_msg);
                return;
            } elseif ($step === 'photo') {
                $session['step'] = 'description';
                set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
                $current_desc = !empty($data['description']) ? $data['description'] : 'بدون توضیحات (رد شده)';
                $this->bale_send($chat_id, "🔙 برگشتیم به توضیحات!\n\n📄 مرحله ۳ از ۴\nتوضیحات محصول را بنویسید:\n(توضیحات قبلی شما: {$current_desc})\n\nبرای رد کردن عدد 0 بزنید.");
                return;
            }
        }
        // ==========================================

        // ثبت لاگ
        file_put_contents(ABSPATH . 'bale-step.txt', "STEP: " . $step . " | TEXT: " . $text_clean . "\n", FILE_APPEND);

        switch ($step) {
            case 'title':
                $data['title'] = $text; // ثبت دقیق عنوان کاربر (بدون تغییر)
                $data['current_parent'] = 0;
                $data['page'] = 1;
                
                $header_msg = "✅ عنوان ثبت شد!\n\n📂 مرحله ۲ از ۴\nبرای مشاهده زیرمجموعه‌ها، **عدد کنار هر گزینه** را بفرستید:\n\n";
                $this->bale_render_category_page($chat_id, $data, $header_msg);
                break;

            case 'category_hierarchy':
                $cat_mapping = $data['cat_mapping'] ?? [];
                $current_parent = intval($data['current_parent'] ?? 0);
                $page = intval($data['page'] ?? 1);

                if ($text_lower === 'n') {
                    $data['page'] = $page + 1;
                } elseif ($text_lower === 'p') {
                    $data['page'] = max(1, $page - 1);
                } elseif ($text_lower === '0') {
                    $data['category'] = $current_parent;
                    unset($data['cat_mapping'], $data['current_parent'], $data['page']);
                    $session = ['step' => 'description', 'data' => $data];
                    set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
                    $this->bale_send($chat_id, "✅ دسته‌بندی نهایی ثبت شد!\n\n📄 مرحله ۳ از ۴\nتوضیحات محصول را بنویسید:\nبرای رد کردن عدد 0 بزنید\n\n/back 🔙 بازگشت و ویرایش دسته‌بندی");
                    return;
                } elseif ($text_lower === 'b' && $current_parent > 0) {
                    $term = get_term($current_parent, 'product_cat');
                    $data['current_parent'] = ($term && !is_wp_error($term)) ? intval($term->parent) : 0;
                    $data['page'] = 1;
                } elseif (is_numeric($text_lower) && isset($cat_mapping[intval($text_lower)])) {
                    $target_cat = intval($cat_mapping[intval($text_lower)]);

                    $children = get_terms([
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => false,
                        'parent'     => $target_cat
                    ]);

                    if (is_wp_error($children) || empty($children)) {
                        $data['category'] = $target_cat;
                        unset($data['cat_mapping'], $data['current_parent'], $data['page']);
                        $session = ['step' => 'description', 'data' => $data];
                        set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
                        $this->bale_send($chat_id, "✅ دسته‌بندی ثبت شد! (این دسته‌بندی زیرمجموعه‌ای نداشت)\n\n📄 مرحله ۳ از ۴\nتوضیحات محصول را بنویسید:\nبرای رد کردن عدد 0 بزنید\n\n/back 🔙 بازگشت و ویرایش دسته‌بندی");
                        return;
                    } else {
                        $data['current_parent'] = $target_cat;
                        $data['page'] = 1;
                    }
                } else {
                    $this->bale_send($chat_id, "❌ ورودی نامعتبر! لطفاً فقط عدد گزینه یا حروف راهنما را بفرستید:");
                    return;
                }

                $header_msg = "";
                if ($data['current_parent'] == 0) {
                    $header_msg = "📂 دسته‌بندی‌های اصلی:\n\n";
                } else {
                    $term = get_term($data['current_parent'], 'product_cat');
                    $header_msg = "📂 زیرمجموعه‌های «" . $term->name . "»:\n\n";
                }

                $this->bale_render_category_page($chat_id, $data, $header_msg);
                break;

            case 'description':
                $data['description'] = ($text_lower === '0') ? '' : $text; // ثبت دقیق توضیحات کاربر
                $session = ['step' => 'photo', 'data' => $data];
                set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
                $this->bale_send($chat_id, "✅ توضیحات ثبت شد!\n\n📸 مرحله ۴ از ۴\nعکس محصول را ارسال کنید:\nبرای رد کردن عدد 0 بزنید\n\n/back 🔙 ویرایش توضیحات");
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

    public function bale_render_category_page($chat_id, $data, $header_msg) {
        $per_page = 15; 
        
        $cats = get_terms([
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
            'parent'     => intval($data['current_parent'])
        ]);

        if (is_wp_error($cats) || empty($cats)) {
            $this->bale_send($chat_id, "❌ هیچ دسته‌بندی یافت نشد!");
            return;
        }

        $total_cats = count($cats);
        $total_pages = ceil($total_cats / $per_page);
        if ($data['page'] > $total_pages) $data['page'] = $total_pages;
        if ($data['page'] < 1) $data['page'] = 1;

        $offset = ($data['page'] - 1) * $per_page;
        $current_cats = array_slice($cats, $offset, $per_page);

        $cat_mapping = [];
        $cat_text = $header_msg;
        $i = 1;
        
        foreach ($current_cats as $cat) {
            $cat_text .= $i . ". " . $cat->name . "\n";
            $cat_mapping[$i] = $cat->term_id; 
            $i++;
        }

        $data['cat_mapping'] = $cat_mapping;

        $cat_text .= "\n";
        if ($data['page'] < $total_pages) {
            $cat_text .= "n. 🔽 صفحه بعدی\n";
        }
        if ($data['page'] > 1) {
            $cat_text .= "p. 🔼 صفحه قبلی\n";
        }

        if ($data['current_parent'] == 0) {
            $cat_text .= "0. 🚫 بدون دسته‌بندی\n";
        } else {
            $term = get_term($data['current_parent'], 'product_cat');
            $cat_text .= "0. 🏁 پایان و ثبت دسته «" . $term->name . "»\n";
            $cat_text .= "b. 🔙 بازگشت به دسته‌های بالاتر\n";
        }

        $cat_text .= "\n🔢 برای ورود به زیرمجموعه‌ها، عدد آن را بفرستید (صفحه {$data['page']} از {$total_pages}):\n\n/back 🔙 ویرایش عنوان محصول";

        $session = [
            'step' => 'category_hierarchy',
            'data' => $data
        ];
        set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
        $this->bale_send($chat_id, $cat_text);
    }

    public function bale_process_callback($callback) {
        error_log('WCBPM Callback: ' . print_r($callback, true));
        $chat_id    = $callback['message']['chat']['id'] ?? $callback['from']['id'];
        $data_str   = $callback['data'];

        if (strpos($data_str, 'cat_') === 0) {
            $cat_id  = intval(str_replace('cat_', '', $data_str));
            $session = get_transient('wcbpm_bale_' . $chat_id) ?: ['step' => 'idle', 'data' => []];
            $data    = $session['data'];

            $data['category'] = $cat_id;
            $session = ['step' => 'description', 'data' => $data];
            set_transient('wcbpm_bale_' . $chat_id, $session, 3600);

            $cat_name = $cat_id > 0 ? get_term($cat_id)->name : 'بدون دسته‌بندی';

            $this->bale_send($chat_id, "✅ دسته‌بندی انتخاب شد: " . $cat_name . "\n\n📄 مرحله ۴ از ۶\nتوضیحات محصول را بنویسید:\nبرای رد کردن عدد 0 بزنید");
        }

        // پاسخ به callback
        $token = get_option('wcbpm_bale_token', '');
        if ($token) {
            wp_remote_post("https://tapi.bale.ai/bot{$token}/answerCallbackQuery", [
                'body'    => ['callback_query_id' => $callback['id']],
                'timeout' => 10
            ]);
        }
    }

    public function bale_create_product($chat_id, $data) {
        $product = new WC_Product_Simple();
        $product->set_name($data['title']);
        $product->set_status('publish');

        if (!empty($data['description']))                        $product->set_description($data['description']);
        if (!empty($data['price']) && $data['price'] > 0)       $product->set_regular_price($data['price']);
        if (!empty($data['category']) && $data['category'] > 0) $product->set_category_ids([$data['category']]);
        if (!empty($data['image_id']))                           $product->set_image_id($data['image_id']);
        if (!empty($data['stock']) && $data['stock'] > 0) {
            $product->set_manage_stock(true);
            $product->set_stock_quantity($data['stock']);
            $product->set_stock_status('instock');
        }

        $id = $product->save();

        if ($id) {
            $price_text = (!empty($data['price']) && $data['price'] > 0) ? number_format($data['price']) . " تومان" : "ثبت نشده";
            $stock_text = (!empty($data['stock']) && $data['stock'] > 0) ? $data['stock'] . " عدد" : "نامحدود";
            
            $this->bale_send($chat_id,
                "🎉 محصول با موفقیت اضافه شد!\n\n" .
                "📦 نام: " . $data['title'] . "\n" .
                "💰 قیمت: " . $price_text . "\n" .
                "📦 موجودی: " . $stock_text . "\n\n" .
                "برای افزودن محصول جدید /add را بزنید"
            );
        } else {
            $this->bale_send($chat_id, '❌ خطا در ایجاد محصول! دوباره تلاش کنید.');
        }
    }

    public function bale_upload_photo($file_id) {
        $token    = get_option('wcbpm_bale_token', '');
        $response = wp_remote_get("https://tapi.bale.ai/bot{$token}/getFile?file_id={$file_id}", ['timeout' => 15]);
        $result   = json_decode(wp_remote_retrieve_body($response), true);
        $path     = $result['result']['file_path'] ?? null;
        
        if (!$path) return null;

        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $tmp = download_url("https://tapi.bale.ai/file/bot{$token}/{$path}");
        if (is_wp_error($tmp)) return null;

        $file_array = ['name' => 'bale-' . time() . '.jpg', 'tmp_name' => $tmp];
        $attachment_id = media_handle_sideload($file_array, 0);
        @unlink($tmp);

        return is_wp_error($attachment_id) ? null : $attachment_id;
    }

    public function bale_send_recent($chat_id) {
        $products = wc_get_products(['limit' => 5, 'orderby' => 'date', 'order' => 'DESC']);
        if (empty($products)) { $this->bale_send($chat_id, '📋 هنوز محصولی ثبت نشده!'); return; }
        
        $text = "📋 آخرین محصولات:\n\n";
        foreach ($products as $p) { $text .= "• " . $p->get_name() . "\n"; }
        $this->bale_send($chat_id, $text);
    }

    public function bale_send($chat_id, $text, $keyboard = null) {
        $token = get_option('wcbpm_bale_token', '');
        if (empty($token)) return;
        
        $body = [
            'chat_id' => (string) $chat_id,
            'text'    => $text
        ];
        
        if ($keyboard) {
            $body['reply_markup'] = [
                'inline_keyboard' => $keyboard
            ];
        }

        wp_remote_post("https://tapi.bale.ai/bot{$token}/sendMessage", [
            'method'  => 'POST',
            'timeout' => 15,
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body'    => json_encode($body)
        ]);
    }

    // ===== ادمین =====
    public function add_admin_menu() {
        add_menu_page('محصول آسان', '🛍 محصول آسان', 'manage_options', 'wcbpm-settings', [$this, 'render_settings_page'], 'dashicons-smartphone', 30);
    }

    public function register_settings() {
        register_setting('wcbpm_settings', 'wcbpm_bale_token', 'sanitize_text_field');
        register_setting('wcbpm_settings', 'wcbpm_allowed_chats');
    }

    public function ajax_set_webhook() {
        check_ajax_referer('wcbpm_webhook', 'nonce');
        $token       = get_option('wcbpm_bale_token', '');
        $webhook_url = rest_url('wcbpm/v1/bale');
        
        if (empty($token)) { wp_send_json_error(['message' => 'توکن ربات بله وارد نشده!']); }
        
        $response = wp_remote_post("https://tapi.bale.ai/bot{$token}/setWebhook", ['body' => ['url' => $webhook_url], 'timeout' => 15]);
        $result = json_decode(wp_remote_retrieve_body($response), true);
        
        if (!empty($result['ok'])) { wp_send_json_success(['message' => 'Webhook ربات بله با موفقیت ثبت شد!']); }
        else { wp_send_json_error(['message' => $result['description'] ?? 'خطا در ثبت Webhook']); }
    }

    public function render_settings_page() {
        $token         = get_option('wcbpm_bale_token', '');
        $allowed_chats = (array) get_option('wcbpm_allowed_chats', []);
        $webhook_url   = rest_url('wcbpm/v1/bale');
        $panel_url     = home_url('/product-panel/');
        ?>
        <div class="wrap" dir="rtl" style="font-family:Tahoma;">
            <h1>🛍 محصول آسان - پنل مدیریت</h1>

            <div class="card" style="max-width:650px;padding:20px;margin-bottom:20px;">
                <h2>📱 پنل موبایل کارمندان</h2>
                <p>کارمندان از این لینک میتوانند محصول اضافه کنند:</p>
                <code style="background:#f0f0f0;padding:10px 14px;border-radius:6px;display:block;margin:8px 0;">
                    <?php echo esc_url($panel_url); ?>
                </code>
                <p>
                    <a href="<?php echo esc_url($panel_url); ?>" target="_blank" class="button button-primary">🔗 مشاهده پنل</a>
                    &nbsp;
                    <a href="<?php echo esc_url(admin_url('user-new.php')); ?>" class="button">👤 افزودن کارمند</a>
                </p>
            </div>

            <div class="card" style="max-width:650px;padding:20px;margin-bottom:20px;">
                <h2>🤖 تنظیمات ربات بله</h2>
                <form method="post" action="options.php">
                    <?php settings_fields('wcbpm_settings'); ?>
                    <table class="form-table">
                        <tr>
                            <th>توکن ربات بله</th>
                            <td>
                                <input type="text" name="wcbpm_bale_token" value="<?php echo esc_attr($token); ?>" style="width:400px;" placeholder="توکن ربات بله را اینجا وارد کنید">
                                <p class="description">
                                    ⚠️ توکن ربات <strong>بله</strong> است نه تلگرام!<br><br>
                                    📌 راهنما:<br>
                                    ۱. اپ بله رو باز کن<br>
                                    ۲. سرچ کن: BaleBot@<br>
                                    ۳. بنویس: /newbot<br>
                                    ۴. توکن رو کپی کن اینجا بذار
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>Chat ID کارمندان بله</th>
                            <td>
                                <textarea name="wcbpm_allowed_chats" rows="5" style="width:400px;" placeholder="هر Chat ID در یک خط"><?php echo esc_textarea(implode("\n", $allowed_chats)); ?></textarea>
                                <p class="description">
                                    📌 برای دریافت Chat ID:<br>
                                    ۱. توی بله سرچ کن: BaleBot@<br>
                                    ۲. بنویس: /chatid
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>Webhook بله</th>
                            <td>
                                <code style="background:#f0f0f0;padding:6px 10px;border-radius:4px;display:block;margin-bottom:10px;">
                                    <?php echo esc_url($webhook_url); ?>
                                </code>
                                <button type="button" class="button button-primary" id="wcbpm-set-webhook">✅ ثبت Webhook</button>
                                <span id="wcbpm-webhook-result" style="margin-right:12px;font-weight:bold;"></span>
                            </td>
                        </tr>
                    </table>
                    <?php submit_button('💾 ذخیره تنظیمات'); ?>
                </form>
            </div>

            <div class="card" style="max-width:650px;padding:20px;">
                <h2>👥 کارمندان</h2>
                <?php
                $staff = get_users(['role' => 'product_staff']);
                if (empty($staff)) {
                    echo '<p>هنوز کارمندی اضافه نشده.</p>';
                } else {
                    echo '<table class="wp-list-table widefat fixed striped">
                        <thead><tr><th>نام</th><th>ایمیل</th><th>عملیات</th></tr></thead><tbody>';
                    foreach ($staff as $u) {
                        echo '<tr>
                            <td>' . esc_html($u->display_name) . '</td>
                            <td>' . esc_html($u->user_email) . '</td>
                            <td><a href="' . esc_url(get_edit_user_link($u->ID)) . '">✏️ ویرایش</a></td>
                        </tr>';
                    }
                    echo '</tbody></table>';
                }
                ?>
                <p style="margin-top:16px;">
                    <a href="<?php echo esc_url(admin_url('user-new.php')); ?>" class="button button-primary">➕ افزودن کارمند</a>
                </p>
            </div>
        </div>

        <script>
        document.getElementById('wcbpm-set-webhook').addEventListener('click', function() {
            var btn = this;
            var result = document.getElementById('wcbpm-webhook-result');
            btn.disabled = true;
            result.textContent = '⏳ در حال ثبت...';
            result.style.color = '#666';
            var fd = new FormData();
            fd.append('action', 'wcbpm_set_webhook');
            fd.append('nonce', '<?php echo wp_create_nonce('wcbpm_webhook'); ?>');
            fetch(ajaxurl, { method: 'POST', body: fd })
                .then(function(r) { return r.json(); })
                .then(function(d) {
                    btn.disabled = false;
                    if (d.success) { result.textContent = '✅ ' + d.data.message; result.style.color = 'green'; }
                    else { result.textContent = '❌ ' + d.data.message; result.style.color = 'red'; }
                })
                .catch(function() { btn.disabled = false; result.textContent = '❌ خطا!'; result.style.color = 'red'; });
        });
        </script>
        <?php
    }
}

new WC_Bale_Product_Manager();