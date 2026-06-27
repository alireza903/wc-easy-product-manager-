<?php
/**
 * Plugin Name: WC Bale Product Manager
 * Plugin URI: #
 * Description: افزودن محصول + استعلام موجودی سایت + ربات بله (اسکنر دوربین، ضد تکرار، دسته‌بندی هوشمند، هلو)
 * Version: 2.4.1
 * Author: Admin
 * Requires at least: 5.0
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) exit;

define('WCBPM_VERSION', '2.4.1');
define('WCBPM_PATH', plugin_dir_path(__FILE__));
define('WCBPM_URL', plugin_dir_url(__FILE__));

// ===================================================
// CSS 
// ===================================================
function wcbpm_get_css() {
    return '
    <style>
    * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
    .wcbpm-container { max-width: 500px; margin: 0 auto; padding: 16px; font-family: Tahoma, sans-serif; direction: rtl; background: #f5f5f5; min-height: 100vh; }
    .wcbpm-header { background: linear-gradient(135deg, #1a73e8, #0d47a1); color: white; padding: 16px; border-radius: 16px; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center; }
    .wcbpm-header h2 { margin: 0; font-size: 18px; }
    
    /* Tabs */
    .wcbpm-tabs { display: flex; gap: 8px; margin-bottom: 16px; }
    .wcbpm-tab-btn { flex: 1; padding: 12px; border: none; border-radius: 12px; background: #e9ecef; font-family: Tahoma, sans-serif; font-size: 15px; font-weight: bold; cursor: pointer; color: #6c757d; transition: 0.3s; }
    .wcbpm-tab-btn.active { background: #1a73e8; color: white; box-shadow: 0 4px 10px rgba(26,115,232,0.3); }
    .wcbpm-tab-content { display: none; }
    .wcbpm-tab-content.active { display: block; animation: fadein 0.3s ease-in-out; }
    @keyframes fadein { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    .wcbpm-alert { padding: 12px 16px; border-radius: 12px; margin-bottom: 16px; font-size: 14px; text-align: center; display: none; }
    .wcbpm-alert.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .wcbpm-alert.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    .wcbpm-field { background: white; border-radius: 16px; padding: 16px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
    .wcbpm-field label { display: block; font-size: 14px; font-weight: bold; color: #333; margin-bottom: 8px; }
    
    .wcbpm-field input[type="text"], .wcbpm-field input[type="number"], .wcbpm-field textarea, .wcbpm-field select { 
        width: 100%; padding: 14px 12px; border: 2px solid #e9ecef; border-radius: 12px; font-size: 15px; font-family: Tahoma, sans-serif; direction: rtl; outline: none; transition: border-color 0.2s; background: #fafafa; -webkit-appearance: none; appearance: none; 
    }
    
    .wcbpm-field select { 
        padding: 16px 12px 16px 40px !important; font-size: 15px !important; line-height: 1.5 !important; min-height: 55px !important; height: auto !important; 
        background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%23333\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3Cpolyline points=\'6 9 12 15 18 9\'%3E%3C/polyline%3E%3C/svg%3E") !important; 
        background-repeat: no-repeat !important; background-position: left 15px center !important; background-size: 16px !important; text-overflow: ellipsis; white-space: nowrap; overflow: hidden; 
    }
    
    .wcbpm-field select option { padding: 10px; }
    .wcbpm-field input:focus, .wcbpm-field textarea:focus, .wcbpm-field select:focus { border-color: #1a73e8; background: white; }
    
    .wcbpm-image-upload { position: relative; border: 3px dashed #dee2e6; border-radius: 16px; padding: 24px; text-align: center; cursor: pointer; background: #fafafa; min-height: 120px; }
    .wcbpm-image-placeholder span { font-size: 40px; display: block; }
    .wcbpm-image-placeholder p { margin: 8px 0 0; color: #6c757d; font-size: 14px; }
    .wcbpm-image-upload input[type="file"] { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 2; }
    #wcbpm-preview { width: 100%; border-radius: 12px; max-height: 200px; object-fit: cover; display: none; }
    .wcbpm-price-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .wcbpm-price-input label { font-size: 12px; color: #6c757d; font-weight: normal; margin-bottom: 4px; display: block; }
    .wcbpm-status-buttons { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 4px; }
    .wcbpm-status-btn { padding: 12px; border: 2px solid #e9ecef; border-radius: 12px; background: #fafafa; font-size: 15px; cursor: pointer; transition: all 0.2s; font-family: Tahoma, sans-serif; text-align: center; }
    .wcbpm-status-btn.active { border-color: #1a73e8; background: #e8f0fe; color: #1a73e8; font-weight: bold; }
    
    .wcbpm-submit-btn, .wcbpm-check-btn { width: 100%; padding: 18px; background: linear-gradient(135deg, #1a73e8, #0d47a1); color: white; border: none; border-radius: 16px; font-size: 18px; font-family: Tahoma, sans-serif; font-weight: bold; cursor: pointer; box-shadow: 0 4px 15px rgba(26,115,232,0.4); margin-top: 8px; }
    .wcbpm-check-btn { background: linear-gradient(135deg, #28a745, #1e7e34); box-shadow: 0 4px 15px rgba(40,167,69,0.4); }
    .wcbpm-submit-btn:active, .wcbpm-check-btn:active { transform: scale(0.98); }
    .wcbpm-submit-btn:disabled, .wcbpm-check-btn:disabled { opacity: 0.6; cursor: not-allowed; filter: grayscale(100%); }
    
    .wcbpm-recent { background: white; border-radius: 16px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-top: 16px; }
    .wcbpm-recent h3 { margin: 0 0 12px; font-size: 15px; color: #333; }
    .wcbpm-product-list { list-style: none; margin: 0; padding: 0; }
    .wcbpm-product-list li { display: flex; align-items: center; padding: 10px 0; border-bottom: 1px solid #f0f0f0; gap: 8px; }
    .wcbpm-product-list li:last-child { border-bottom: none; }
    .wcbpm-product-name { flex: 1; font-size: 14px; color: #333; }
    .wcbpm-edit-btn { font-size: 18px; text-decoration: none; }
    .wcbpm-login-msg { background: white; border-radius: 16px; padding: 40px 24px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
    .wcbpm-login-btn { display: inline-block; padding: 12px 32px; background: linear-gradient(135deg, #1a73e8, #0d47a1); color: white; border-radius: 12px; text-decoration: none; font-weight: bold; margin-top: 12px; }
    .wcbpm-upload-status { font-size: 13px; margin-top: 8px; color: #1a73e8; display: none; }
    .wcbpm-no-products { color: #6c757d; font-size: 14px; text-align: center; padding: 16px 0; }
    
    .wcbpm-msg-box { margin-top: 8px; padding: 10px 12px; border-radius: 8px; font-size: 13.5px; display: none; line-height:1.5; }
    .wcbpm-msg-box.found { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .wcbpm-msg-box.notfound { background: #fff3cd; color: #856404; border: 1px solid #ffc107; }
    .wcbpm-msg-box.error-box { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    
    .wcbpm-barcode-wrapper { display: flex; gap: 8px; }
    .wcbpm-scan-btn { background: #1a73e8; color: white; border: none; border-radius: 12px; width: 60px; display: flex; justify-content: center; align-items: center; cursor: pointer; font-size: 24px; transition: 0.2s; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .wcbpm-scan-btn:active { transform: scale(0.9); }
    .wcbpm-scanner-modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.95); z-index: 99999; display: none; flex-direction: column; justify-content: center; align-items: center; padding: 20px; }
    .wcbpm-scanner-box { background: white; padding: 20px; border-radius: 16px; width: 100%; max-width: 400px; text-align: center; }
    .wcbpm-stop-scan { margin-top: 16px; padding: 12px 24px; background: #dc3545; color: white; border: none; border-radius: 12px; cursor: pointer; font-weight: bold; width: 100%; font-size: 16px; }
    #wcbpm-reader { width: 100%; border-radius: 12px; overflow: hidden; background:#000; }
    
    .wcbpm-stock-card { background:#e8f0fe; border:1px solid #b6d4fe; border-radius:12px; padding:16px; margin-top:16px; display:none; }
    .wcbpm-stock-card h4 { margin:0 0 10px; color:#0d47a1; font-size:16px; }
    .wcbpm-stock-card p { margin:6px 0; font-size:14px; color:#333; }
    .wcbpm-stock-card span { font-weight:bold; color:#1a73e8; }
    </style>';
}

// ===================================================
// JavaScript
// ===================================================
function wcbpm_get_js($children_map = []) {
    $json_map = json_encode($children_map, JSON_UNESCAPED_UNICODE);
    return '
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
    (function($) {
        $(document).ready(function() {

            // 📂 منطق تب‌ها (افزودن محصول / استعلام)
            $(".wcbpm-tab-btn").on("click", function() {
                $(".wcbpm-tab-btn").removeClass("active");
                $(".wcbpm-tab-content").removeClass("active");
                $(this).addClass("active");
                $("#tab-" + $(this).data("tab")).addClass("active");
            });

            var categoryMap = ' . $json_map . ';
            var uploadedImageId = null;
            var isUploading = false;

            // منطق دسته‌بندی‌های هوشمند (افزودن محصول)
            $("#product-parent-category").on("change", function() {
                var parentId = $(this).val();
                var $childSelect = $("#product-child-category");
                var $childWrapper = $("#child-category-wrapper");
                $childSelect.empty().append("<option value=\'\'>انتخاب زیرمجموعه (اختیاری)...</option>");
                if (parentId && categoryMap[parentId] && categoryMap[parentId].length > 0) {
                    $.each(categoryMap[parentId], function(i, child) {
                        $childSelect.append("<option value=\'" + child.id + "\'>" + child.name + "</option>");
                    });
                    $childWrapper.fadeIn(200);
                } else {
                    $childWrapper.hide();
                }
            });

            // آپلود عکس
            $("#wcbpm-image-input").on("change", function() {
                var file = this.files[0];
                if (!file) return;
                var reader = new FileReader();
                reader.onload = function(e) { $("#wcbpm-preview").attr("src", e.target.result).show(); $("#wcbpm-placeholder").hide(); };
                reader.readAsDataURL(file);
                isUploading = true;
                var formData = new FormData();
                formData.append("action", "wcbpm_upload_image");
                formData.append("nonce", wcbpm_ajax.nonce);
                formData.append("image", file);
                $("#wcbpm-upload-status").html("⏳ در حال آپلود عکس...").show();
                $.ajax({
                    url: wcbpm_ajax.ajax_url, type: "POST", data: formData, processData: false, contentType: false,
                    success: function(response) {
                        isUploading = false;
                        if (response.success) {
                            uploadedImageId = response.data.attachment_id;
                            $("#wcbpm-upload-status").html("✅ عکس آپلود شد!").css("color", "green");
                            setTimeout(function() { $("#wcbpm-upload-status").hide(); }, 2000);
                        } else { $("#wcbpm-upload-status").html("❌ خطا در آپلود!").css("color", "red"); }
                    },
                    error: function() { isUploading = false; $("#wcbpm-upload-status").html("❌ خطا در اتصال!").css("color", "red"); }
                });
            });

            // 📷 دوربین اسکنر مشترک برای هر دو تب
            var html5QrCode = null;
            var activeScanInput = null;

            $(".wcbpm-open-scanner").on("click", function() {
                if (typeof Html5Qrcode === "undefined") {
                    showAlert("❌ در حال بارگذاری کتابخانه دوربین... چند لحظه دیگر امتحان کنید.", "error"); return;
                }
                activeScanInput = $(this).data("target");
                $("#wcbpm-scanner-modal").css("display", "flex");
                if (!html5QrCode) html5QrCode = new Html5Qrcode("wcbpm-reader");
                
                html5QrCode.start(
                    { facingMode: "environment" },
                    { fps: 10, qrbox: { width: 250, height: 150 } },
                    function(decodedText, decodedResult) {
                        html5QrCode.stop().then(function() {
                            $("#wcbpm-scanner-modal").hide();
                            $(activeScanInput).val(decodedText).trigger("input");
                            if (navigator.vibrate) navigator.vibrate([100, 50, 100]);
                        });
                    },
                    function(errorMessage) { }
                ).catch(function(err) {
                    $("#wcbpm-scanner-modal").hide();
                    showAlert("❌ دسترسی به دوربین عقب ممکن نیست! مجوز دوربین را بررسی کنید.", "error");
                });
            });

            $("#wcbpm-stop-scan").on("click", function() {
                if (html5QrCode && html5QrCode.isScanning) { html5QrCode.stop().then(function() { $("#wcbpm-scanner-modal").hide(); }); } 
                else { $("#wcbpm-scanner-modal").hide(); }
            });

            // 🔍 جستجوی بارکد (ضد تکرار در افزودن محصول)
            var barcodeTimer = null;
            $("#product-barcode").on("input", function() {
                clearTimeout(barcodeTimer);
                var barcode = $(this).val().trim();
                var $res = $("#wcbpm-holoocode-result");
                var $btnSubmit = $("#wcbpm-submit");
                
                if (barcode.length < 3) {
                    $res.hide(); $("#product-holoocode").val(""); $btnSubmit.prop("disabled", false); return;
                }
                
                barcodeTimer = setTimeout(function() {
                    $.post(wcbpm_ajax.ajax_url, {
                        action: "wcbpm_check_duplicate_barcode", nonce: wcbpm_ajax.nonce, barcode: barcode,
                    }, function(response) {
                        $res.removeClass("found notfound error-box");
                        
                        // اگر در سایت تکراری بود (هشدار و قفل دکمه)
                        if (response.success && response.data.exists_in_site) {
                            $res.addClass("error-box").html("⚠️ <b>اخطار تکراری:</b> این کالا قبلاً با نام «" + response.data.site_name + "» در سایت شما ثبت شده است! نمی‌توانید دوباره آن را ثبت کنید.").show();
                            $btnSubmit.prop("disabled", true);
                            $("#product-holoocode").val("");
                            return;
                        }
                        
                        // اگر تکراری نبود، فقط دیتای هلو را نشان بدهد
                        $btnSubmit.prop("disabled", false);
                        if (response.success && response.data.found_in_holoo) {
                            $("#product-holoocode").val(response.data.holooCode);
                            $res.addClass("found").html("✅ هلو یافت شد: <strong>" + response.data.holooCode + "</strong> — " + response.data.holooName).show();
                        } else {
                            $("#product-holoocode").val("");
                            $res.addClass("notfound").html("⚠️ بارکد در فایل هلو پیدا نشد — شناسه هلو خالی میماند").show();
                        }
                    });
                }, 500);
            });

            // 📦 استعلام موجودی زنده (تب دوم)
            var checkStockTimer = null;
            $("#check-stock-barcode").on("input", function() {
                clearTimeout(checkStockTimer);
                var barcode = $(this).val().trim();
                var $card = $("#wcbpm-stock-card");
                
                if (barcode.length < 3) { $card.hide(); return; }
                
                checkStockTimer = setTimeout(function() {
                    $("#wcbpm-stock-status").html("⏳ در حال جستجو در سایت...");
                    $card.show();
                    
                    $.post(wcbpm_ajax.ajax_url, {
                        action: "wcbpm_check_site_stock", nonce: wcbpm_ajax.nonce, barcode: barcode,
                    }, function(response) {
                        if (response.success) {
                            var d = response.data;
                            var html = "<h4>" + d.name + "</h4>";
                            html += "<p>🎯 کد کالا: <span>" + d.code + "</span></p>";
                            html += "<p>💰 قیمت سایت: <span>" + d.price + "</span></p>";
                            html += "<p>📊 موجودی سایت: <span>" + d.stock + "</span></p>";
                            if(d.edit_url) { html += "<a href=\'" + d.edit_url + "\' target=\'_blank\' style=\'display:inline-block;margin-top:10px;text-decoration:none;color:#1a73e8;font-weight:bold;\'>✏️ ویرایش محصول در سایت</a>"; }
                            $("#wcbpm-stock-status").html(html);
                        } else {
                            $("#wcbpm-stock-status").html("<span style=\'color:#dc3545;font-weight:bold;\'>❌ " + response.data.message + "</span>");
                        }
                    }).fail(function(){
                        $("#wcbpm-stock-status").html("<span style=\'color:#dc3545;font-weight:bold;\'>❌ خطا در ارتباط با سرور</span>");
                    });
                }, 600);
            });

            // ارسال فرم افزودن محصول
            $(".wcbpm-status-btn").on("click", function() { $(".wcbpm-status-btn").removeClass("active"); $(this).addClass("active"); $("#product-status").val($(this).data("status")); });

            $("#wcbpm-form").on("submit", function(e) {
                e.preventDefault();
                if (isUploading) { showAlert("⏳ صبر کنید عکس آپلود شود...", "error"); return; }
                var title = $("#product-title").val().trim();
                if (!title) { showAlert("❌ عنوان محصول را وارد کنید!", "error"); $("#product-title").focus(); return; }

                setLoading(true);
                var finalCategory = $("#product-child-category").val() || $("#product-parent-category").val() || 0;

                $.post(wcbpm_ajax.ajax_url, {
                    action: "wcbpm_add_product", nonce: wcbpm_ajax.nonce,
                    title: title, description: $("#product-desc").val(),
                    price: $("#product-price").val(), sale_price: $("#product-sale-price").val(),
                    category: finalCategory, stock: $("#product-stock").val(),
                    barcode: $("#product-barcode").val(), holoocode: $("#product-holoocode").val(),
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
                $(".wcbpm-status-btn").removeClass("active"); $(".wcbpm-status-btn[data-status=\"publish\"]").addClass("active");
                $("#wcbpm-holoocode-result").hide(); $("#product-holoocode").val("");
                $("#child-category-wrapper").hide(); $("#product-child-category").empty();
                $("#wcbpm-submit").prop("disabled", false);
            }

            function refreshList() {
                $.post(wcbpm_ajax.ajax_url, { action: "wcbpm_get_recent", nonce: wcbpm_ajax.nonce },
                function(response) { if (response.success) { $("#wcbpm-recent-list").html(response.data.html); } });
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

    public function init() {
        if (!class_exists('WooCommerce')) {
            add_action('admin_notices', function() { echo '<div class="error"><p>⚠️ افزونه نیاز به ووکامرس دارد!</p></div>'; }); return;
        }

        $role = get_role('product_staff');
        if (!$role) { add_role('product_staff', 'کارمند محصول', ['read' => true, 'publish_products' => true, 'edit_products' => true, 'upload_files' => true, 'edit_posts' => true]); } 
        else { $role->add_cap('read'); $role->add_cap('publish_products'); $role->add_cap('edit_products'); $role->add_cap('upload_files'); $role->add_cap('edit_posts'); }

        add_shortcode('wcbpm_panel', [$this, 'render_panel']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);

        add_action('wp_ajax_wcbpm_add_product',             [$this, 'ajax_add_product']);
        add_action('wp_ajax_wcbpm_upload_image',            [$this, 'ajax_upload_image']);
        add_action('wp_ajax_wcbpm_get_recent',              [$this, 'ajax_get_recent']);
        add_action('wp_ajax_wcbpm_set_webhook',             [$this, 'ajax_set_webhook']);
        add_action('wp_ajax_wcbpm_upload_excel',            [$this, 'ajax_upload_excel']);
        add_action('wp_ajax_wcbpm_check_duplicate_barcode', [$this, 'ajax_check_duplicate_barcode']);
        add_action('wp_ajax_wcbpm_check_site_stock',        [$this, 'ajax_check_site_stock']);

        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('rest_api_init', [$this, 'register_bale_webhook']);
    }

    public function activate() {
        if (!get_role('product_staff')) { add_role('product_staff', 'کارمند محصول', ['read' => true, 'publish_products' => true, 'edit_products' => true, 'upload_files' => true, 'edit_posts' => true]); }
        if (!get_page_by_path('product-panel')) { wp_insert_post(['post_title' => 'پنل افزودن محصول', 'post_name' => 'product-panel', 'post_status' => 'publish', 'post_type' => 'page', 'post_content' => '[wcbpm_panel]']); }
        flush_rewrite_rules();
    }
    public function deactivate() { flush_rewrite_rules(); }
    public function enqueue_assets() {
        global $post; if (!is_a($post, 'WP_Post') || !has_shortcode($post->post_content, 'wcbpm_panel')) return;
        wp_enqueue_script('jquery'); wp_localize_script('jquery', 'wcbpm_ajax', ['ajax_url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('wcbpm_nonce')]);
    }

    // ===================================================
    // توابع اکسل، هلو و جستجوی ووکامرس
    // ===================================================
    private function get_holoocode_meta_key() { return get_option('wcbpm_holoocode_meta_key', '_holo_sku'); }
    private function is_ghoghnoos_sheet($name) { $name = trim($name); return ($name === 'ققنوس' || $name === 'فروشگاه ققنوس'); }

    private function lookup_barcode_in_holoodata($barcode) {
        if (empty($barcode)) return null;
        $barcode   = trim((string)$barcode);
        $holoodata = get_option('wcbpm_holoodata', []);
        if (empty($holoodata)) return null;

        foreach ($holoodata as $row) {
            $customerCode = trim((string)($row['holooCustomerCode'] ?? ''));
            if ($customerCode !== '' && $customerCode === $barcode) {
                return ['holooCode' => $row['holooCode'], 'holooName' => $row['holooName']];
            }
        }
        return null;
    }

    private function find_product_by_barcode_or_holoo($code) {
        global $wpdb;
        $meta_key = $this->get_holoocode_meta_key();
        $product_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM {$wpdb->postmeta} WHERE (meta_key=%s OR meta_key='_sku' OR meta_key='holoo_id' OR meta_key='_holoo_code') AND meta_value=%s LIMIT 1", $meta_key, $code));
        return $product_id ? intval($product_id) : false;
    }

    // ایجکس تب افزودن: چک کردن هلو + چک کردن تکراری بودن سایت
    public function ajax_check_duplicate_barcode() {
        check_ajax_referer('wcbpm_nonce', 'nonce');
        $barcode = sanitize_text_field($_POST['barcode'] ?? '');
        $holoo = $this->lookup_barcode_in_holoodata($barcode);
        $holoo_code = $holoo ? $holoo['holooCode'] : $barcode;

        // جستجو در سایت
        $exists_id = $this->find_product_by_barcode_or_holoo($holoo_code);
        if (!$exists_id && $holoo_code !== $barcode) {
            $exists_id = $this->find_product_by_barcode_or_holoo($barcode);
        }

        $response = [
            'found_in_holoo' => $holoo ? true : false,
            'holooCode'      => $holoo ? $holoo['holooCode'] : '',
            'holooName'      => $holoo ? $holoo['holooName'] : '',
            'exists_in_site' => $exists_id ? true : false,
            'site_name'      => $exists_id ? get_the_title($exists_id) : ''
        ];
        wp_send_json_success($response);
    }

    // ایجکس تب استعلام: گرفتن موجودی کالا
    public function ajax_check_site_stock() {
        check_ajax_referer('wcbpm_nonce', 'nonce');
        $barcode = sanitize_text_field($_POST['barcode'] ?? '');
        $holoo = $this->lookup_barcode_in_holoodata($barcode);
        $holoo_code = $holoo ? $holoo['holooCode'] : $barcode;

        $product_id = $this->find_product_by_barcode_or_holoo($holoo_code);
        if (!$product_id && $holoo_code !== $barcode) {
            $product_id = $this->find_product_by_barcode_or_holoo($barcode);
        }

        if ($product_id) {
            $product = wc_get_product($product_id);
            if ($product) {
                $stock = $product->get_manage_stock() ? $product->get_stock_quantity() . " عدد" : "مدیریت موجودی غیرفعال است";
                $price = $product->get_price() ? number_format($product->get_price()) . " تومان" : "ثبت نشده";
                wp_send_json_success([
                    'name' => $product->get_name(),
                    'code' => $holoo_code,
                    'price' => $price,
                    'stock' => $stock,
                    'edit_url' => get_edit_post_link($product_id, '')
                ]);
            }
        }
        wp_send_json_error(['message' => 'این کالا در سایت یافت نشد!']);
    }

    public function ajax_upload_excel() {
        check_ajax_referer('wcbpm_excel_nonce', 'nonce');
        if (!current_user_can('manage_options')) wp_send_json_error(['message' => 'دسترسی ندارید!']);
        if (empty($_FILES['excel_file'])) wp_send_json_error(['message' => 'فایلی انتخاب نشده!']);
        $file = $_FILES['excel_file']; $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['xlsx', 'xls'])) wp_send_json_error(['message' => 'فقط فایل Excel قابل قبول است!']);
        $rows = $this->parse_excel_file($file['tmp_name']);
        if ($rows === false) wp_send_json_error(['message' => 'خطا در خواندن فایل Excel! شیت «ققنوس» پیدا نشد.']);
        if (empty($rows)) wp_send_json_error(['message' => 'شیت ققنوس پیدا شد ولی داده‌ای در آن نبود!']);
        update_option('wcbpm_holoodata', $rows, false); update_option('wcbpm_holoodata_updated', current_time('mysql'));
        wp_send_json_success(['message' => 'فایل هلو با موفقیت بارگذاری شد! ' . count($rows) . ' محصول از ققنوس ثبت شد.']);
    }

    private function parse_excel_file($filepath) {
        if (class_exists('\PhpOffice\PhpSpreadsheet\IOFactory')) {
            try {
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filepath); $rows = [];
                foreach ($spreadsheet->getSheetNames() as $sheetName) {
                    if (!$this->is_ghoghnoos_sheet($sheetName)) continue;
                    $sheet = $spreadsheet->getSheetByName($sheetName); $data = $sheet->toArray(null, true, false, false);
                    if (empty($data) || count($data) < 2) continue;
                    $headers = array_map('trim', $data[0]);
                    $cIdx = array_search('holooCode', $headers); $nIdx = array_search('holooName', $headers); $bIdx = array_search('holooCustomerCode', $headers);
                    if ($cIdx === false || $nIdx === false || $bIdx === false) continue;
                    for ($i = 1; $i < count($data); $i++) {
                        $row = $data[$i]; $code = trim((string)($row[$cIdx] ?? '')); $name = trim((string)($row[$nIdx] ?? '')); $bcode = trim((string)($row[$bIdx] ?? ''));
                        if ($code === '' || $bcode === '' || strtolower($bcode) === 'nan') continue;
                        $rows[] = ['holooCode' => $code, 'holooName' => $name, 'holooCustomerCode' => $bcode];
                    }
                } return $rows;
            } catch (\Exception $e) {}
        }
        if (class_exists('ZipArchive')) {
            $zip = new ZipArchive();
            if ($zip->open($filepath) === true) { $rows = $this->parse_xlsx_native($zip); $zip->close(); return $rows; }
        } return false;
    }

    private function parse_xlsx_native($zip) {
        $rows = []; $sharedStrings = []; $ssContent = $zip->getFromName('xl/sharedStrings.xml');
        if ($ssContent) {
            $ssXml = simplexml_load_string($ssContent);
            if ($ssXml) { foreach ($ssXml->si as $si) { $text = ''; if (isset($si->t)) $text = (string)$si->t; elseif (isset($si->r)) { foreach ($si->r as $r) { if (isset($r->t)) $text .= (string)$r->t; } } $sharedStrings[] = $text; } }
        }
        $wbContent = $zip->getFromName('xl/workbook.xml'); if (!$wbContent) return $rows; $wb = simplexml_load_string($wbContent); if (!$wb) return $rows;
        $sheetIdx = 1;
        foreach ($wb->sheets->sheet as $sheet) {
            $sheetName = (string)$sheet['name']; if (!$this->is_ghoghnoos_sheet($sheetName)) { $sheetIdx++; continue; }
            $sheetFile = "xl/worksheets/sheet{$sheetIdx}.xml"; $sheetContent = $zip->getFromName($sheetFile); if (!$sheetContent) { $sheetIdx++; continue; }
            $sheetXml = simplexml_load_string($sheetContent); if (!$sheetXml) { $sheetIdx++; continue; }
            $sheetData = [];
            foreach ($sheetXml->sheetData->row as $row) {
                $rowData = [];
                foreach ($row->c as $cell) { $t = (string)($cell['t'] ?? ''); $v = isset($cell->v) ? (string)$cell->v : ''; if ($t === 's') $v = $sharedStrings[(int)$v] ?? ''; $rowData[] = $v; }
                $sheetData[] = $rowData;
            }
            if (count($sheetData) < 2) { $sheetIdx++; continue; }
            $headers = array_map('trim', $sheetData[0]); $cIdx = array_search('holooCode', $headers); $nIdx = array_search('holooName', $headers); $bIdx = array_search('holooCustomerCode', $headers);
            if ($cIdx === false || $nIdx === false || $bIdx === false) { $sheetIdx++; continue; }
            for ($i = 1; $i < count($sheetData); $i++) {
                $row = $sheetData[$i]; $code = trim((string)($row[$cIdx] ?? '')); $name = trim((string)($row[$nIdx] ?? '')); $bcode = trim((string)($row[$bIdx] ?? ''));
                if ($code === '' || $bcode === '' || strtolower($bcode) === 'nan') continue;
                $rows[] = ['holooCode' => $code, 'holooName' => $name, 'holooCustomerCode' => $bcode];
            } $sheetIdx++;
        } return $rows;
    }

    // ===================================================
    // رندر پنل وب وردپرس (با تب‌های جدید)
    // ===================================================
    public function render_panel() {
        $output = wcbpm_get_css();
        if (!is_user_logged_in()) { return $output . '<div class="wcbpm-container"><div class="wcbpm-login-msg"><p style="font-size:48px;margin:0">🔐</p><h3>ابتدا وارد شوید</h3><p>برای مدیریت محصول باید وارد حساب شوید</p><a href="' . wp_login_url(get_permalink()) . '" class="wcbpm-login-btn">ورود به حساب</a></div></div>' . wcbpm_get_js(); }
        if (!current_user_can('edit_products')) { return $output . '<div class="wcbpm-container"><div class="wcbpm-login-msg"><p style="font-size:48px;margin:0">🚫</p><h3>دسترسی ندارید!</h3></div></div>'; }

        // آرایه‌ی کامل دسته‌بندی‌های مادر طبق نظر شما
        $allowed_parents = [
            'تنقلات', 'دخانیات', 'لبنیات', 'بهداشت شخصی', 'لوازم آرایش و بهداشتی', 
            'کالاهای اساسی و خواروبار', 'لوازم بهداشتی مصرفی', 'بهداشت خانگی', 
            'نان', 'میوه و سبزیجات', 'ساندویچ', 'نوشیدنی ها', 'کالاهای اساسی و خواربار', 
            'کالای اساسی و خواروبار', 'میوه'
        ];
        
        $all_parents = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => 0]);
        $filtered_parents = [];
        foreach ($all_parents as $p) { if (in_array(trim($p->name), $allowed_parents)) { $filtered_parents[] = $p; } }

        $children_map = [];
        foreach ($filtered_parents as $p) {
            $children = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => $p->term_id]);
            $children_map[$p->term_id] = [];
            if (!is_wp_error($children)) { foreach ($children as $c) { $children_map[$p->term_id][] = ['id' => $c->term_id, 'name' => $c->name]; } }
        }

        $output .= '
        <div class="wcbpm-container">
            <div class="wcbpm-header"><h2>📦 مدیریت انبار هوشمند</h2><span>👤 ' . esc_html(wp_get_current_user()->display_name) . '</span></div>
            
            <div class="wcbpm-tabs">
                <button type="button" class="wcbpm-tab-btn active" data-tab="add">➕ افزودن</button>
                <button type="button" class="wcbpm-tab-btn" data-tab="check">🔍 استعلام</button>
            </div>
            
            <div class="wcbpm-alert" id="wcbpm-alert"></div>
            
            <!-- تَب 1: افزودن محصول -->
            <div id="tab-add" class="wcbpm-tab-content active">
                <form id="wcbpm-form">
                    <div class="wcbpm-field">
                        <label>📷 عکس محصول</label>
                        <div class="wcbpm-image-upload"><div id="wcbpm-placeholder" class="wcbpm-image-placeholder"><span>📸</span><p>کلیک کنید یا عکس بگیرید</p></div><img id="wcbpm-preview" src="" alt=""><input type="file" id="wcbpm-image-input" accept="image/*" capture="environment"><input type="hidden" id="wcbpm-image-id"></div>
                        <div class="wcbpm-upload-status" id="wcbpm-upload-status"></div>
                    </div>
                    
                    <div class="wcbpm-field"><label for="product-title">📝 عنوان محصول *</label><input type="text" id="product-title" placeholder="مثال: کیک شکلاتی" required></div>
                    
                    <div class="wcbpm-field">
                        <label>💰 قیمت (تومان)</label>
                        <div class="wcbpm-price-row"><div class="wcbpm-price-input"><label for="product-price">قیمت اصلی</label><input type="number" id="product-price" placeholder="0" min="0"></div><div class="wcbpm-price-input"><label for="product-sale-price">قیمت تخفیف</label><input type="number" id="product-sale-price" placeholder="اختیاری" min="0"></div></div>
                    </div>
                    
                    <div class="wcbpm-field">
                        <label for="product-barcode">🔍 بارکد محصول</label>
                        <div class="wcbpm-barcode-wrapper">
                            <input type="text" id="product-barcode" placeholder="اسکن یا تایپ..." inputmode="numeric" style="flex:1;">
                            <button type="button" class="wcbpm-scan-btn wcbpm-open-scanner" data-target="#product-barcode" title="اسکن با دوربین">📷</button>
                        </div>
                        <div class="wcbpm-msg-box" id="wcbpm-holoocode-result"></div>
                        <input type="hidden" id="product-holoocode">
                    </div>
                    
                    <div class="wcbpm-field"><label for="product-parent-category">📂 دسته‌بندی اصلی</label><select id="product-parent-category"><option value="">انتخاب دسته‌بندی...</option>';
            foreach ($filtered_parents as $cat) { $output .= '<option value="' . esc_attr($cat->term_id) . '">' . esc_html($cat->name) . '</option>'; }
            $output .= '</select></div>
                    
                    <div class="wcbpm-field" id="child-category-wrapper" style="display:none; background:#e8f0fe; border: 1px solid #1a73e8;">
                        <label for="product-child-category" style="color:#0d47a1;">🏷 زیرمجموعه</label>
                        <select id="product-child-category"><option value="">ابتدا دسته‌بندی اصلی را انتخاب کنید</option></select>
                    </div>

                    <div class="wcbpm-field"><label for="product-desc">📄 توضیحات</label><textarea id="product-desc" rows="4" placeholder="توضیحات محصول را بنویسید..."></textarea></div>
                    <div class="wcbpm-field"><label for="product-stock">📦 موجودی</label><input type="number" id="product-stock" placeholder="تعداد موجودی" min="0"></div>
                    <div class="wcbpm-field"><label>📌 وضعیت انتشار</label><div class="wcbpm-status-buttons"><button type="button" class="wcbpm-status-btn active" data-status="publish">✅ منتشر شود</button><button type="button" class="wcbpm-status-btn" data-status="draft">📋 پیش‌نویس</button></div><input type="hidden" id="product-status" value="publish"></div>
                    <button type="submit" class="wcbpm-submit-btn" id="wcbpm-submit"><span id="wcbpm-btn-text">🚀 افزودن محصول</span><span id="wcbpm-btn-loader" style="display:none">⏳ در حال ثبت...</span></button>
                </form>

                <div class="wcbpm-recent"><h3>📋 محصولات اخیر</h3><div id="wcbpm-recent-list">' . $this->get_recent_html() . '</div></div>
            </div>
            
            <!-- تَب 2: استعلام موجودی -->
            <div id="tab-check" class="wcbpm-tab-content">
                <div class="wcbpm-field">
                    <label>🔍 بارکد کالا را برای استعلام وارد کنید</label>
                    <div class="wcbpm-barcode-wrapper">
                        <input type="text" id="check-stock-barcode" placeholder="اسکن یا تایپ بارکد..." inputmode="numeric" style="flex:1;">
                        <button type="button" class="wcbpm-scan-btn wcbpm-open-scanner" data-target="#check-stock-barcode" title="اسکن با دوربین">📷</button>
                    </div>
                </div>
                <div class="wcbpm-stock-card" id="wcbpm-stock-card">
                    <div id="wcbpm-stock-status">⏳ در حال جستجو...</div>
                </div>
            </div>

            <!-- مودال اسکنر مشترک -->
            <div class="wcbpm-scanner-modal" id="wcbpm-scanner-modal">
                <div class="wcbpm-scanner-box">
                    <h3 style="margin-top:0;margin-bottom:16px;">اسکن بارکد با دوربین</h3>
                    <div id="wcbpm-reader"></div>
                    <button type="button" id="wcbpm-stop-scan" class="wcbpm-stop-scan">انصراف و بستن دوربین</button>
                </div>
            </div>

        </div>';
        return $output . wcbpm_get_js($children_map);
    }

    private function get_recent_html() {
        $products = wc_get_products(['limit' => 5, 'orderby' => 'date', 'order' => 'DESC', 'author' => get_current_user_id()]);
        if (empty($products)) return '<p class="wcbpm-no-products">هنوز محصولی اضافه نکردید 😊</p>';
        $html = '<ul class="wcbpm-product-list">';
        foreach ($products as $p) {
            $icon  = $p->get_status() === 'publish' ? '✅' : '📋';
            $html .= '<li><span>' . $icon . '</span><span class="wcbpm-product-name">' . esc_html($p->get_name()) . '</span><a href="' . esc_url(get_edit_post_link($p->get_id())) . '" class="wcbpm-edit-btn" target="_blank">✏️</a></li>';
        }
        return $html . '</ul>';
    }

    public function ajax_add_product() {
        check_ajax_referer('wcbpm_nonce', 'nonce');
        if (!current_user_can('edit_products')) wp_send_json_error(['message' => 'دسترسی ندارید!']);
        
        $title     = sanitize_text_field($_POST['title'] ?? '');
        $desc      = sanitize_textarea_field($_POST['description'] ?? '');
        $price     = floatval($_POST['price'] ?? 0);
        $sale_price= floatval($_POST['sale_price'] ?? 0);
        $category  = intval($_POST['category'] ?? 0);
        $stock     = intval($_POST['stock'] ?? 0);
        $status    = in_array($_POST['status'] ?? '', ['publish', 'draft']) ? $_POST['status'] : 'publish';
        $image_id  = intval($_POST['image_id'] ?? 0);
        $barcode   = sanitize_text_field($_POST['barcode'] ?? '');
        $holoocode = sanitize_text_field($_POST['holoocode'] ?? '');

        if (empty($title)) wp_send_json_error(['message' => 'عنوان الزامی است!']);

        // بررسی ضد تکرار امنیتی در بک‌اند
        $check_code = !empty($holoocode) ? $holoocode : $barcode;
        if (!empty($check_code)) {
            $exists_id = $this->find_product_by_barcode_or_holoo($check_code);
            if (!$exists_id && $check_code !== $barcode) $exists_id = $this->find_product_by_barcode_or_holoo($barcode);
            if ($exists_id) wp_send_json_error(['message' => 'این کالا قبلاً در سایت ثبت شده است! نمی‌توانید دوباره آن را ثبت کنید.']);
        }

        $product = new WC_Product_Simple();
        $product->set_name($title);
        $product->set_description($desc);
        $product->set_status($status);
        if ($price > 0) $product->set_regular_price($price);
        if ($sale_price > 0) $product->set_sale_price($sale_price);
        if ($category > 0) $product->set_category_ids([$category]);
        if ($image_id > 0) $product->set_image_id($image_id);
        if ($stock > 0) { $product->set_manage_stock(true); $product->set_stock_quantity($stock); }
        if (!empty($barcode)) { $product->set_sku($barcode); }

        $id = $product->save();

        if ($id) {
            if (!empty($holoocode)) update_post_meta($id, $this->get_holoocode_meta_key(), $holoocode);
            $msg = 'محصول با موفقیت اضافه شد! 🎉' . (!empty($holoocode) ? ' (هلو: ' . $holoocode . ')' : '');
            wp_send_json_success(['message' => $msg]);
        } else {
            wp_send_json_error(['message' => 'خطا در ثبت محصول!']);
        }
    }

    // ===================================================
    // ربات بله
    // ===================================================
    public function register_bale_webhook() {
        register_rest_route('wcbpm/v1', '/bale', [
            'methods' => 'POST', 'callback' => [$this, 'handle_bale_webhook'], 'permission_callback' => '__return_true',
        ]);
    }

    public function handle_bale_webhook(WP_REST_Request $request) {
        $update = $request->get_json_params();
        if (!empty($update['message'])) $this->bale_process_message($update['message']);
        if (!empty($update['callback_query'])) $this->bale_process_callback($update['callback_query']);
        return new WP_REST_Response('OK', 200);
    }

    private function bale_process_message($message) {
        $chat_id = $message['chat']['id'];
        $text    = $message['text'] ?? '';
        $photo   = $message['photo'] ?? null;

        $allowed_raw = get_option('wcbpm_allowed_chats', '');
        $allowed = is_array($allowed_raw) ? $allowed_raw : array_filter(array_map('trim', explode("\n", $allowed_raw)));
        $allowed = array_map('strval', $allowed);

        if (!in_array((string)$chat_id, $allowed)) {
            $this->bale_send($chat_id, "❌ دسترسی ندارید!\nChat ID شما: {$chat_id}");
            return;
        }

        $session = get_transient('wcbpm_bale_' . $chat_id) ?: ['step' => 'idle', 'data' => []];

        $persian_nums = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english_nums = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $text_clean = str_replace($persian_nums, $english_nums, $text);
        $text_lower = strtolower(trim($text_clean));

        // منوی استارت
        if ($text_lower === '/start' || $text_lower === 'شروع') {
            $session = ['step' => 'idle', 'data' => []];
            set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
            
            $keyboard = [
                [['text' => '➕ افزودن محصول جدید', 'callback_data' => 'action_add']],
                [['text' => '📦 استعلام موجودی سایت', 'callback_data' => 'action_stock']]
            ];
            
            $this->bale_send($chat_id, "👋 سلام! به دستیار هوشمند انبار خوش آمدید.\nلطفاً یک گزینه را انتخاب کنید:", $keyboard);
            return;
        }

        if ($text_lower === '/add') {
            $session = ['step' => 'title', 'data' => []];
            set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
            $this->bale_send($chat_id, "🛍 افزودن محصول جدید\n\n📝 مرحله ۱ از ۷\nعنوان محصول را بنویسید:\n\nبرای لغو /cancel بزنید");
            return;
        }

        if ($text_lower === '/cancel') {
            delete_transient('wcbpm_bale_' . $chat_id);
            $this->bale_send($chat_id, '❌ عملیات لغو شد. برای شروع مجدد /start را بفرستید.');
            return;
        }

        if ($text_lower === '/list') { $this->bale_send_recent($chat_id); return; }
        if ($session['step'] === 'idle' || $text_lower === '/help') {
            $this->bale_send($chat_id, "برای شروع کار، دکمه /start را بفرستید."); return;
        }

        // 🔙 دکمه بازگشت
        if ($text_lower === '/back') {
            if ($session['step'] === 'title') {
                $this->bale_send($chat_id, "مرحله اول هستید. برای لغو /cancel بزنید."); return;
            } elseif ($session['step'] === 'price') {
                $session['step'] = 'title'; set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
                $this->bale_send($chat_id, "🔙 برگشتیم به عنوان!\nعنوان قبلی: {$session['data']['title']}\n\n📝 مرحله ۱ از ۷\nعنوان جدید را بنویسید:"); return;
            } elseif ($session['step'] === 'category') {
                $session['step'] = 'price'; set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
                $this->bale_send($chat_id, "🔙 برگشتیم به قیمت!\nقیمت قبلی: {$session['data']['price']}\n\n💰 مرحله ۲ از ۷\nقیمت را وارد کنید:"); return;
            } elseif ($session['step'] === 'description') {
                $session['step'] = 'category'; set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
                $this->bale_send_category_keyboard($chat_id); return;
            } elseif ($session['step'] === 'stock') {
                $session['step'] = 'description'; set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
                $this->bale_send($chat_id, "🔙 برگشتیم به توضیحات!\n\n📄 مرحله ۴ از ۷\nتوضیحات را بنویسید (0 = رد):"); return;
            } elseif ($session['step'] === 'barcode') {
                $session['step'] = 'stock'; set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
                $this->bale_send($chat_id, "🔙 برگشتیم به موجودی!\n\n📦 مرحله ۵ از ۷\nتعداد موجودی را وارد کنید (0 = رد):"); return;
            } elseif ($session['step'] === 'photo') {
                $session['step'] = 'barcode'; set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
                $this->bale_send($chat_id, "🔙 برگشتیم به بارکد!\n\n🏷 مرحله ۶ از ۷\nبارکد محصول را اسکن کنید (0 = رد):"); return;
            }
        }

        $this->bale_process_step($chat_id, $session, $text_clean, $photo);
    }

    private function bale_process_step($chat_id, $session, $text, $photo) {
        $step = $session['step'];
        $data = $session['data'];

        switch ($step) {
            case 'check_stock':
                $barcode = trim($text);
                if (empty($barcode) || $barcode === '0') { $this->bale_send($chat_id, "❌ بارکد نامعتبر است."); return; }

                $holoo_code = $barcode;
                $found = $this->lookup_barcode_in_holoodata($barcode);
                if ($found && !empty($found['holooCode'])) $holoo_code = $found['holooCode'];

                $product_id = $this->find_product_by_barcode_or_holoo($holoo_code);
                if (!$product_id && $holoo_code !== $barcode) $product_id = $this->find_product_by_barcode_or_holoo($barcode);

                if ($product_id) {
                    $product = wc_get_product($product_id);
                    if ($product) {
                        $stock = $product->get_manage_stock() ? $product->get_stock_quantity() . " عدد" : "مدیریت موجودی غیرفعال";
                        $price = $product->get_price() ? number_format($product->get_price()) . " تومان" : "ثبت نشده";
                        $msg = "✅ کالا در سایت پیدا شد!\n\n📦 نام: " . $product->get_name() . "\n🎯 شناسه: " . $holoo_code . "\n💰 قیمت سایت: " . $price . "\n📊 موجودی سایت: " . $stock . "\n\nبرای بررسی کالای دیگر، بارکد جدید بفرستید.\nبرای خروج /cancel بزنید.";
                        $this->bale_send($chat_id, $msg);
                    }
                } else {
                    $this->bale_send($chat_id, "❌ من نتونستم کالا را در سایت پیدا کنم.\n\nلطفاً دوباره اسکن کنید یا /cancel بزنید.");
                }
                break;

            case 'title':
                $data['title'] = $text;
                $session = ['step' => 'price', 'data' => $data];
                set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
                $this->bale_send($chat_id, "✅ عنوان ثبت شد!\n\n💰 مرحله ۲ از ۷\nقیمت را وارد کنید (تومان):\n(0 = بدون قیمت)\n\n/back 🔙 ویرایش مرحله قبل");
                break;

            case 'price':
                $data['price'] = is_numeric($text) ? floatval($text) : 0;
                $session = ['step' => 'category', 'data' => $data];
                set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
                $this->bale_send_category_keyboard($chat_id);
                break;

            case 'description':
                $data['description'] = ($text === '0') ? '' : $text;
                $session = ['step' => 'stock', 'data' => $data];
                set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
                $this->bale_send($chat_id, "✅ توضیحات ثبت شد!\n\n📦 مرحله ۵ از ۷\nتعداد موجودی را وارد کنید:\n(0 = نامحدود)\n\n/back 🔙 ویرایش مرحله قبل");
                break;

            case 'stock':
                $data['stock'] = is_numeric($text) ? intval($text) : 0;
                $session = ['step' => 'barcode', 'data' => $data];
                set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
                $this->bale_send($chat_id, "✅ موجودی ثبت شد!\n\n🏷 مرحله ۶ از ۷\nبارکد محصول را اسکن کنید:\n(سیستم شناسه هلو را استخراج می‌کند و از ثبت تکراری جلوگیری می‌کند)\n(0 = رد کردن)\n\n/back 🔙 ویرایش مرحله قبل");
                break;

            case 'barcode':
                if ($text !== '0' && !empty(trim($text))) {
                    $barcode = trim($text);
                    $found = $this->lookup_barcode_in_holoodata($barcode);
                    $holoocode = $found ? $found['holooCode'] : $barcode;

                    // بررسی ضد تکرار در ربات
                    $exists_id = $this->find_product_by_barcode_or_holoo($holoocode);
                    if (!$exists_id && $holoocode !== $barcode) $exists_id = $this->find_product_by_barcode_or_holoo($barcode);
                    
                    if ($exists_id) {
                        $p = wc_get_product($exists_id);
                        $this->bale_send($chat_id, "⚠️ اخطار: این کالا قبلاً در سایت با نام «" . $p->get_name() . "» ثبت شده است!\n\nامکان ثبت مجدد وجود ندارد.\nلطفاً یک بارکد جدید بفرستید یا برای خروج /cancel بزنید.");
                        return; // متوقف کردن روند و ماندن در همین مرحله
                    }

                    $data['barcode'] = $barcode;
                    if ($found) {
                        $data['holoocode'] = $found['holooCode'];
                        $this->bale_send($chat_id, "✅ بارکد جدید است!\n🎯 هلو: {$found['holooCode']}\n📦 نام در هلو: {$found['holooName']}\n\n📸 مرحله ۷ از ۷\nعکس محصول را ارسال کنید (0 = رد):");
                    } else {
                        $data['holoocode'] = '';
                        $this->bale_send($chat_id, "⚠️ بارکد جدید است (در هلو پیدا نشد).\n\n📸 مرحله ۷ از ۷\nعکس محصول را ارسال کنید (0 = رد):");
                    }
                } else {
                    $data['barcode'] = ''; $data['holoocode'] = '';
                    $this->bale_send($chat_id, "⏭ بارکد رد شد.\n\n📸 مرحله ۷ از ۷\nعکس محصول را ارسال کنید (0 = رد):");
                }
                $session = ['step' => 'photo', 'data' => $data];
                set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
                break;

            case 'photo':
                if ($photo) {
                    $file_id = end($photo)['file_id'];
                    $data['image_id'] = $this->bale_upload_photo($file_id);
                }
                $this->bale_create_product($chat_id, $data);
                delete_transient('wcbpm_bale_' . $chat_id);
                break;
        }
    }

    private function bale_send_category_keyboard($chat_id, $parent_id = 0, $page = 1) {
        $per_page = 10; 
        $cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => $parent_id]);
        if (is_wp_error($cats) || empty($cats)) { $this->bale_send($chat_id, "❌ خطایی در خواندن دسته‌ها رخ داد."); return; }

        if ($parent_id == 0) {
            $allowed_parents = [
                'تنقلات', 'دخانیات', 'لبنیات', 'بهداشت شخصی', 'لوازم آرایش و بهداشتی',
                'لوازم بهداشتی مصرفی', 'بهداشت خانگی', 'نان', 'میوه و سبزیجات', 'ساندویچ', 'نوشیدنی ها',
                'کالاهای اساسی و خواربار', 'کالاهای اساسی و خواروبار', 'کالای اساسی و خواروبار',
                'کالاهای اساسی', 'خواربار', 'خواروبار', 'میوه', 'افزودنی ها', 'افزودنیها'
            ];
            $filtered_cats = [];
            foreach ($cats as $c) { if (in_array(trim($c->name), $allowed_parents)) $filtered_cats[] = $c; }
            $cats = $filtered_cats;
        }

        $total_cats = count($cats); $total_pages = ceil($total_cats / $per_page);
        if ($page > $total_pages) $page = $total_pages; if ($page < 1) $page = 1;
        $offset = ($page - 1) * $per_page; $current_cats = array_slice($cats, $offset, $per_page);
        
        $keyboard = [];
        foreach ($current_cats as $cat) {
            if ($parent_id == 0) { $cb = 'sel_' . $cat->term_id; $prefix = '📁 '; } else { $cb = 'fsel_' . $cat->term_id; $prefix = '└ 🏷 '; }
            $keyboard[] = [['text' => $prefix . $cat->name, 'callback_data' => $cb]];
        }

        $nav_row = [];
        if ($page > 1) $nav_row[] = ['text' => '🔼 قبلی', 'callback_data' => 'nav_' . $parent_id . '_' . ($page - 1)];
        if ($page < $total_pages) $nav_row[] = ['text' => '🔽 بعدی', 'callback_data' => 'nav_' . $parent_id . '_' . ($page + 1)];
        if (!empty($nav_row)) $keyboard[] = $nav_row;

        if ($parent_id == 0) {
            $keyboard[] = [['text' => '🚫 بدون دسته‌بندی', 'callback_data' => 'fsel_0']];
        } else {
            $term = get_term($parent_id, 'product_cat');
            $keyboard[] = [['text' => '✅ انتخاب خود دسته (' . $term->name . ')', 'callback_data' => 'fsel_' . $parent_id]];
            $keyboard[] = [['text' => '🔙 بازگشت به دسته‌های مادر', 'callback_data' => 'nav_0_1']];
        }

        $this->bale_send($chat_id, "✅ مرحله قبل ثبت شد!\n\n📂 مرحله ۳ از ۷\nیک دسته‌بندی انتخاب کنید (صفحه {$page} از {$total_pages}):\n\n/back 🔙 ویرایش مرحله قبل", $keyboard);
    }

    private function bale_process_callback($callback) {
        $chat_id  = $callback['message']['chat']['id'] ?? $callback['from']['id'];
        $data_str = $callback['data'];

        if ($data_str === 'action_add') {
            $session = ['step' => 'title', 'data' => []]; set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
            $this->bale_send($chat_id, "🛍 افزودن محصول جدید\n\n📝 مرحله ۱ از ۷\nعنوان محصول را بنویسید:\n\nبرای لغو /cancel بزنید");
        } elseif ($data_str === 'action_stock') {
            $session = ['step' => 'check_stock', 'data' => []]; set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
            $this->bale_send($chat_id, "📦 استعلام موجودی از سایت\n\nلطفاً بارکد کالا را اسکن کنید:\n\nبرای خروج /cancel بزنید");
        } elseif (strpos($data_str, 'nav_') === 0) {
            $parts = explode('_', $data_str); $this->bale_send_category_keyboard($chat_id, intval($parts[1]), intval($parts[2]));
        } elseif (strpos($data_str, 'sel_') === 0) {
            $term_id = intval(str_replace('sel_', '', $data_str)); $children = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => $term_id]);
            if (is_wp_error($children) || empty($children)) $this->finalize_category_selection($chat_id, $term_id); else $this->bale_send_category_keyboard($chat_id, $term_id, 1);
        } elseif (strpos($data_str, 'fsel_') === 0) {
            $this->finalize_category_selection($chat_id, intval(str_replace('fsel_', '', $data_str)));
        }

        $token = get_option('wcbpm_bale_token', '');
        if ($token) wp_remote_post("https://tapi.bale.ai/bot{$token}/answerCallbackQuery", ['body' => ['callback_query_id' => $callback['id']], 'timeout' => 10]);
    }

    private function finalize_category_selection($chat_id, $term_id) {
        $session = get_transient('wcbpm_bale_' . $chat_id) ?: ['step' => 'idle', 'data' => []];
        $session['data']['category'] = $term_id; $session['step'] = 'description';
        set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
        $cat_name = $term_id > 0 ? get_term($term_id)->name : 'بدون دسته‌بندی';
        $this->bale_send($chat_id, "✅ دسته‌بندی انتخاب شد: {$cat_name}\n\n📄 مرحله ۴ از ۷\nتوضیحات محصول را بنویسید:\n(برای رد کردن عدد 0 بزنید)\n\n/back 🔙 ویرایش مرحله قبل");
    }

    private function bale_create_product($chat_id, $data) {
        $product = new WC_Product_Simple();
        $product->set_name($data['title']); $product->set_status('publish');
        if (!empty($data['description'])) $product->set_description($data['description']);
        if (!empty($data['price']) && $data['price'] > 0) $product->set_regular_price($data['price']);
        if (!empty($data['category']) && $data['category'] > 0) $product->set_category_ids([$data['category']]);
        if (!empty($data['image_id'])) $product->set_image_id($data['image_id']);
        if (!empty($data['barcode'])) $product->set_sku($data['barcode']);
        if (!empty($data['stock']) && $data['stock'] > 0) { $product->set_manage_stock(true); $product->set_stock_quantity($data['stock']); $product->set_stock_status('instock'); }

        $id = $product->save();
        if ($id) {
            if (!empty($data['holoocode'])) update_post_meta($id, $this->get_holoocode_meta_key(), $data['holoocode']);
            $msg = "🎉 محصول با موفقیت اضافه شد!\n\n📦 {$data['title']}";
            if (!empty($data['holoocode'])) $msg .= "\n🔗 هلو: {$data['holoocode']}"; elseif (!empty($data['barcode'])) $msg .= "\n⚠️ هلو پیدا نشد";
            $this->bale_send($chat_id, $msg . "\n\nبرای شروع مجدد /start را بزنید.");
        } else {
            $this->bale_send($chat_id, '❌ خطا در ایجاد محصول! دوباره تلاش کنید.');
        }
    }

    private function bale_upload_photo($file_id) {
        $token = get_option('wcbpm_bale_token', '');
        $response = wp_remote_get("https://tapi.bale.ai/bot{$token}/getFile?file_id={$file_id}", ['timeout' => 15]);
        $result = json_decode(wp_remote_retrieve_body($response), true);
        $path = $result['result']['file_path'] ?? null; if (!$path) return null;
        require_once ABSPATH . 'wp-admin/includes/image.php'; require_once ABSPATH . 'wp-admin/includes/file.php'; require_once ABSPATH . 'wp-admin/includes/media.php';
        $tmp = download_url("https://tapi.bale.ai/file/bot{$token}/{$path}"); if (is_wp_error($tmp)) return null;
        $attachment_id = media_handle_sideload(['name' => 'bale-' . time() . '.jpg', 'tmp_name' => $tmp], 0); @unlink($tmp);
        return is_wp_error($attachment_id) ? null : $attachment_id;
    }

    private function bale_send_recent($chat_id) {
        $products = wc_get_products(['limit' => 5, 'orderby' => 'date', 'order' => 'DESC']);
        if (empty($products)) { $this->bale_send($chat_id, '📋 هنوز محصولی ثبت نشده!'); return; }
        $text = "📋 آخرین محصولات:\n\n";
        foreach ($products as $p) { $text .= "• " . $p->get_name() . "\n"; }
        $this->bale_send($chat_id, $text);
    }

    public function bale_send($chat_id, $text, $keyboard = null) {
        $token = get_option('wcbpm_bale_token', ''); if (empty($token)) return;
        $body = ['chat_id' => $chat_id, 'text' => $text];
        if ($keyboard) { $body['reply_markup'] = ['inline_keyboard' => $keyboard]; }
        wp_remote_post("https://tapi.bale.ai/bot{$token}/sendMessage", ['headers' => ['Content-Type' => 'application/json'], 'body' => json_encode($body, JSON_UNESCAPED_UNICODE), 'timeout' => 15]);
    }

    // ===================================================
    // صفحه ادمین
    // ===================================================
    public function add_admin_menu() { add_menu_page('محصول آسان', '🛍 محصول آسان', 'manage_options', 'wcbpm-settings', [$this, 'render_settings_page'], 'dashicons-smartphone', 30); }
    public function register_settings() { register_setting('wcbpm_settings', 'wcbpm_bale_token', 'sanitize_text_field'); register_setting('wcbpm_settings', 'wcbpm_allowed_chats'); register_setting('wcbpm_settings', 'wcbpm_holoocode_meta_key', 'sanitize_text_field'); }
    public function ajax_set_webhook() {
        check_ajax_referer('wcbpm_webhook', 'nonce');
        $token = get_option('wcbpm_bale_token', ''); if (empty($token)) wp_send_json_error(['message' => 'توکن ربات بله وارد نشده!']);
        $response = wp_remote_post("https://tapi.bale.ai/bot{$token}/setWebhook", ['headers' => ['Content-Type' => 'application/json'], 'body' => json_encode(['url' => rest_url('wcbpm/v1/bale')], JSON_UNESCAPED_UNICODE), 'timeout' => 15]);
        $result = json_decode(wp_remote_retrieve_body($response), true);
        if (!empty($result['ok'])) wp_send_json_success(['message' => 'Webhook ربات بله با موفقیت ثبت شد!']);
        else wp_send_json_error(['message' => $result['description'] ?? 'خطا در ثبت Webhook']);
    }

    public function render_settings_page() {
        $token           = get_option('wcbpm_bale_token', '');
        $allowed_chats   = (array) get_option('wcbpm_allowed_chats', []);
        $webhook_url     = rest_url('wcbpm/v1/bale');
        $panel_url       = home_url('/product-panel/');
        $holoodata_count = count((array) get_option('wcbpm_holoodata', []));
        $holoodata_date  = get_option('wcbpm_holoodata_updated', '');
        $holoocode_key   = get_option('wcbpm_holoocode_meta_key', '_holo_sku');
        ?>
        <div class="wrap" dir="rtl" style="font-family:Tahoma;">
            <h1>🛍 محصول آسان - پنل مدیریت</h1>

            <div class="card" style="max-width:650px;padding:20px;margin-bottom:20px;border-right:4px solid #1a73e8;">
                <h2>📊 فایل داده هلو (اکسل) — شیت ققنوس</h2>
                <?php if ($holoodata_count > 0): ?>
                <div style="background:#d4edda;border:1px solid #c3e6cb;border-radius:8px;padding:12px 16px;margin-bottom:16px;color:#155724;">✅ <strong><?php echo number_format($holoodata_count); ?> محصول</strong> از شیت فروشگاه ققنوس بارگذاری شده<br><small>آخرین بروزرسانی: <?php echo esc_html($holoodata_date); ?></small></div>
                <?php else: ?>
                <div style="background:#fff3cd;border:1px solid #ffc107;border-radius:8px;padding:12px 16px;margin-bottom:16px;color:#856404;">⚠️ فایل هلو هنوز بارگذاری نشده!</div>
                <?php endif; ?>
                <p>فایل اکسل هلو را آپلود کنید. افزونه فقط شیت <strong>«ققنوس»</strong> یا <strong>«فروشگاه ققنوس»</strong> را می‌خواند.</p>
                <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
                    <input type="file" id="wcbpm-excel-file" accept=".xlsx,.xls" style="border:2px dashed #dee2e6;border-radius:8px;padding:8px 12px;flex:1;min-width:200px;">
                    <button type="button" class="button button-primary" id="wcbpm-upload-excel">📤 آپلود فایل هلو</button>
                </div>
                <div id="wcbpm-excel-result" style="margin-top:12px;font-weight:bold;font-size:14px;display:none;"></div>
            </div>

            <div class="card" style="max-width:650px;padding:20px;margin-bottom:20px;">
                <h2>📱 پنل موبایل کارمندان</h2>
                <code style="background:#f0f0f0;padding:10px 14px;border-radius:6px;display:block;font-size:14px;margin:8px 0;"><?php echo esc_url($panel_url); ?></code>
                <p><a href="<?php echo esc_url($panel_url); ?>" target="_blank" class="button button-primary">🔗 مشاهده پنل</a> &nbsp; <a href="<?php echo esc_url(admin_url('user-new.php')); ?>" class="button">👤 افزودن کارمند</a></p>
            </div>

            <div class="card" style="max-width:650px;padding:20px;margin-bottom:20px;">
                <h2>⚙️ تنظیمات</h2>
                <form method="post" action="options.php">
                    <?php settings_fields('wcbpm_settings'); ?>
                    <table class="form-table">
                        <tr><th>توکن ربات بله</th><td><input type="text" name="wcbpm_bale_token" value="<?php echo esc_attr($token); ?>" style="width:400px;"></td></tr>
                        <tr><th>Chat ID کارمندان</th><td><textarea name="wcbpm_allowed_chats" rows="5" style="width:400px;"><?php echo esc_textarea(implode("\n", $allowed_chats)); ?></textarea></td></tr>
                        <tr><th>Meta Key شناسه هلو</th><td><input type="text" name="wcbpm_holoocode_meta_key" value="<?php echo esc_attr($holoocode_key); ?>" style="width:300px;"><p class="description">کلید افزونه نیلا — معمولاً <code>_holo_sku</code></p></td></tr>
                        <tr><th>Webhook بله</th><td><code style="background:#f0f0f0;padding:6px 10px;border-radius:4px;display:block;margin-bottom:10px;"><?php echo esc_url($webhook_url); ?></code><button type="button" class="button button-primary" id="wcbpm-set-webhook">✅ ثبت Webhook</button><span id="wcbpm-webhook-result" style="margin-right:12px;font-weight:bold;font-size:14px;"></span></td></tr>
                    </table>
                    <?php submit_button('💾 ذخیره تنظیمات'); ?>
                </form>
            </div>

            <div class="card" style="max-width:650px;padding:20px;">
                <h2>👥 کارمندان محصول</h2>
                <?php
                $staff = get_users(['role' => 'product_staff']);
                if (empty($staff)) echo '<p style="color:#666;">هنوز کارمندی اضافه نشده.</p>';
                else {
                    echo '<table class="wp-list-table widefat fixed striped"><thead><tr><th>نام</th><th>ایمیل</th><th>عملیات</th></tr></thead><tbody>';
                    foreach ($staff as $u) echo '<tr><td>' . esc_html($u->display_name) . '</td><td>' . esc_html($u->user_email) . '</td><td><a href="' . esc_url(get_edit_user_link($u->ID)) . '">✏️ ویرایش</a></td></tr>';
                    echo '</tbody></table>';
                }
                ?>
                <p style="margin-top:16px;"><a href="<?php echo esc_url(admin_url('user-new.php')); ?>" class="button button-primary">➕ افزودن کارمند</a></p>
            </div>
        </div>

        <script>
        document.getElementById('wcbpm-set-webhook').addEventListener('click', function() {
            var btn = this, result = document.getElementById('wcbpm-webhook-result');
            btn.disabled = true; result.textContent = '⏳ در حال ثبت...';
            var fd = new FormData(); fd.append('action', 'wcbpm_set_webhook'); fd.append('nonce', '<?php echo wp_create_nonce('wcbpm_webhook'); ?>');
            fetch(ajaxurl, {method:'POST', body:fd}).then(r => r.json()).then(d => {
                btn.disabled = false; result.textContent = d.success ? '✅ ' + d.data.message : '❌ ' + d.data.message; result.style.color = d.success ? 'green' : 'red';
            }).catch(() => { btn.disabled = false; result.textContent = '❌ خطا در اتصال!'; result.style.color='red'; });
        });

        document.getElementById('wcbpm-upload-excel').addEventListener('click', function() {
            var file = document.getElementById('wcbpm-excel-file').files[0];
            if (!file) { alert('لطفاً ابتدا فایل اکسل را انتخاب کنید!'); return; }
            var btn = this, result = document.getElementById('wcbpm-excel-result');
            btn.disabled = true; btn.textContent = '⏳ در حال پردازش...';
            result.textContent = '⏳ در حال بارگذاری...'; result.style.display = 'block';
            var fd = new FormData(); fd.append('action', 'wcbpm_upload_excel'); fd.append('nonce', '<?php echo wp_create_nonce('wcbpm_excel_nonce'); ?>'); fd.append('excel_file', file);
            fetch(ajaxurl, {method:'POST', body:fd}).then(r => r.json()).then(d => {
                btn.disabled = false; btn.textContent = '📤 آپلود فایل هلو';
                result.textContent = d.success ? '✅ ' + d.data.message : '❌ ' + d.data.message; result.style.color = d.success ? 'green' : 'red';
                if (d.success) setTimeout(() => location.reload(), 1500);
            }).catch(() => {
                btn.disabled = false; btn.textContent = '📤 آپلود فایل هلو'; result.textContent = '❌ خطا در اتصال!'; result.style.color = 'red';
            });
        });
        </script>
        <?php
    }
}

new WC_Bale_Product_Manager();