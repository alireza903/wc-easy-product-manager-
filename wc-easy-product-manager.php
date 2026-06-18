<?php
/**
 * Plugin Name: WC Bale Product Manager
 * Plugin URI: #
 * Description: افزودن ساده محصول + ربات بله (با دسته‌بندی‌های مادر سفارشی، اسکن اکسل و ویرایش)
 * Version: 1.6.0
 * Author: Admin
 * Requires at least: 5.0
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) exit;

define('WCBPM_VERSION', '1.6.0');
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
    .wcbpm-alert { padding: 12px 16px; border-radius: 12px; margin-bottom: 16px; font-size: 14px; text-align: center; display: none; }
    .wcbpm-alert.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .wcbpm-alert.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    .wcbpm-field { background: white; border-radius: 16px; padding: 16px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
    .wcbpm-field label { display: block; font-size: 14px; font-weight: bold; color: #333; margin-bottom: 8px; }
    .wcbpm-field input[type="text"], .wcbpm-field input[type="number"], .wcbpm-field textarea, .wcbpm-field select { width: 100%; padding: 12px; border: 2px solid #e9ecef; border-radius: 12px; font-size: 16px; font-family: Tahoma, sans-serif; direction: rtl; outline: none; transition: border-color 0.2s; background: #fafafa; -webkit-appearance: none; }
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
    .wcbpm-submit-btn { width: 100%; padding: 18px; background: linear-gradient(135deg, #1a73e8, #0d47a1); color: white; border: none; border-radius: 16px; font-size: 18px; font-family: Tahoma, sans-serif; font-weight: bold; cursor: pointer; box-shadow: 0 4px 15px rgba(26,115,232,0.4); margin-top: 8px; }
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
    .wcbpm-login-btn { display: inline-block; padding: 12px 32px; background: linear-gradient(135deg, #1a73e8, #0d47a1); color: white; border-radius: 12px; text-decoration: none; font-weight: bold; margin-top: 12px; }
    .wcbpm-upload-status { font-size: 13px; margin-top: 8px; color: #1a73e8; display: none; }
    .wcbpm-no-products { color: #6c757d; font-size: 14px; text-align: center; padding: 16px 0; }
    .wcbpm-holoocode-result { margin-top: 8px; padding: 8px 12px; border-radius: 8px; font-size: 13px; display: none; }
    .wcbpm-holoocode-result.found { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .wcbpm-holoocode-result.notfound { background: #fff3cd; color: #856404; border: 1px solid #ffc107; }
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

            // جستجوی بارکد در پنل سایت
            var barcodeTimer = null;
            $("#product-barcode").on("input", function() {
                clearTimeout(barcodeTimer);
                var barcode = $(this).val().trim();
                if (barcode.length < 3) {
                    $("#wcbpm-holoocode-result").hide();
                    $("#product-holoocode").val("");
                    return;
                }
                barcodeTimer = setTimeout(function() {
                    $.post(wcbpm_ajax.ajax_url, {
                        action: "wcbpm_lookup_barcode",
                        nonce:  wcbpm_ajax.nonce,
                        barcode: barcode,
                    }, function(response) {
                        var $res = $("#wcbpm-holoocode-result");
                        if (response.success && response.data.found) {
                            $("#product-holoocode").val(response.data.holooCode);
                            $res.removeClass("notfound").addClass("found")
                                .html("✅ شناسه هلو یافت شد: <strong>" + response.data.holooCode + "</strong> — " + response.data.holooName)
                                .show();
                        } else {
                            $("#product-holoocode").val("");
                            $res.removeClass("found").addClass("notfound")
                                .html("⚠️ بارکد در فایل هلو پیدا نشد — شناسه هلو خالی میماند")
                                .show();
                        }
                    });
                }, 500);
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
                    action:      "wcbpm_add_product",
                    nonce:       wcbpm_ajax.nonce,
                    title:       title,
                    description: $("#product-desc").val(),
                    price:       $("#product-price").val(),
                    sale_price:  $("#product-sale-price").val(),
                    category:    $("#product-category").val(),
                    stock:       $("#product-stock").val(),
                    barcode:     $("#product-barcode").val(),
                    holoocode:   $("#product-holoocode").val(),
                    status:      $("#product-status").val(),
                    image_id:    uploadedImageId || 0,
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
                $("#wcbpm-holoocode-result").hide();
                $("#product-holoocode").val("");
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

    // لیست ثابت و سفارشی دسته‌بندی‌های مادر (طبق درخواست شما)
    private $allowed_parents = [
        'تنقلات', 'دخانیات', 'لبنیات', 'بهداشت شخصی', 
        'لوازم آرایش و بهداشتی', 'کالای اساسی و خواروبار', 
        'لوازم بهداشتی مصرفی', 'بهداشت خانگی', 'نان', 'میوه', 'ساندویچ'
    ];

    public function __construct() {
        add_action('plugins_loaded', [$this, 'init']);
        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deactivate']);
    }

    public function init() {
        if (!class_exists('WooCommerce')) {
            add_action('admin_notices', function() { echo '<div class="error"><p>⚠️ افزونه نیاز به ووکامرس دارد!</p></div>'; });
            return;
        }

        add_shortcode('wcbpm_panel', [$this, 'render_panel']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);

        // AJAX
        add_action('wp_ajax_wcbpm_add_product',    [$this, 'ajax_add_product']);
        add_action('wp_ajax_wcbpm_upload_image',   [$this, 'ajax_upload_image']);
        add_action('wp_ajax_wcbpm_get_recent',     [$this, 'ajax_get_recent']);
        add_action('wp_ajax_wcbpm_set_webhook',    [$this, 'ajax_set_webhook']);
        add_action('wp_ajax_wcbpm_lookup_barcode', [$this, 'ajax_lookup_barcode']);
        add_action('wp_ajax_wcbpm_upload_excel',   [$this, 'ajax_upload_excel']);

        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('rest_api_init', [$this, 'register_bale_webhook']);
    }

    public function activate() {
        if (!get_role('product_staff')) {
            add_role('product_staff', 'کارمند محصول', [
                'read' => true, 'publish_products' => true, 'edit_products' => true, 'upload_files' => true,
            ]);
        }
        if (!get_page_by_path('product-panel')) {
            wp_insert_post([
                'post_title' => 'پنل افزودن محصول', 'post_name' => 'product-panel',
                'post_status' => 'publish', 'post_type' => 'page', 'post_content' => '[wcbpm_panel]',
            ]);
        }
        flush_rewrite_rules();
    }

    public function deactivate() { flush_rewrite_rules(); }

    public function enqueue_assets() {
        global $post;
        if (!is_a($post, 'WP_Post') || !has_shortcode($post->post_content, 'wcbpm_panel')) return;
        wp_enqueue_script('jquery');
        wp_localize_script('jquery', 'wcbpm_ajax', ['ajax_url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('wcbpm_nonce')]);
    }

    // ===================================================
    // توابع اکسل و هلو
    // ===================================================
    private function get_holoocode_meta_key() {
        return get_option('wcbpm_holoocode_meta_key', '_holo_sku');
    }

    private function is_ghoghnoos_sheet($name) {
        $name = trim($name);
        return ($name === 'ققنوس' || $name === 'فروشگاه ققنوس');
    }

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

    public function ajax_lookup_barcode() {
        check_ajax_referer('wcbpm_nonce', 'nonce');
        $barcode = sanitize_text_field($_POST['barcode'] ?? '');
        $result  = $this->lookup_barcode_in_holoodata($barcode);

        if ($result) {
            wp_send_json_success(['found' => true, 'holooCode' => $result['holooCode'], 'holooName' => $result['holooName']]);
        } else {
            wp_send_json_success(['found' => false]);
        }
    }

    public function ajax_upload_excel() {
        check_ajax_referer('wcbpm_excel_nonce', 'nonce');
        if (!current_user_can('manage_options')) wp_send_json_error(['message' => 'دسترسی ندارید!']);
        if (empty($_FILES['excel_file'])) wp_send_json_error(['message' => 'فایلی انتخاب نشده!']);

        $file = $_FILES['excel_file'];
        $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, ['xlsx', 'xls'])) {
            wp_send_json_error(['message' => 'فقط فایل Excel قابل قبول است!']);
        }

        $rows = $this->parse_excel_file($file['tmp_name']);

        if ($rows === false) wp_send_json_error(['message' => 'خطا در خواندن فایل Excel! شیت ققنوس پیدا نشد.']);
        if (empty($rows)) wp_send_json_error(['message' => 'شیت ققنوس پیدا شد ولی داده‌ای در آن نبود!']);

        update_option('wcbpm_holoodata', $rows, false);
        update_option('wcbpm_holoodata_updated', current_time('mysql'));

        wp_send_json_success(['message' => 'فایل هلو با موفقیت بارگذاری شد! ' . count($rows) . ' محصول ثبت شد.']);
    }

    private function parse_excel_file($filepath) {
        if (class_exists('\PhpOffice\PhpSpreadsheet\IOFactory')) {
            try {
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filepath);
                $rows = [];
                foreach ($spreadsheet->getSheetNames() as $sheetName) {
                    if (!$this->is_ghoghnoos_sheet($sheetName)) continue;
                    $sheet = $spreadsheet->getSheetByName($sheetName);
                    $data  = $sheet->toArray(null, true, false, false);
                    if (empty($data) || count($data) < 2) continue;

                    $headers = array_map('trim', $data[0]);
                    $cIdx = array_search('holooCode', $headers);
                    $nIdx = array_search('holooName', $headers);
                    $bIdx = array_search('holooCustomerCode', $headers);

                    if ($cIdx === false || $nIdx === false || $bIdx === false) continue;

                    for ($i = 1; $i < count($data); $i++) {
                        $row   = $data[$i];
                        $code  = trim((string)($row[$cIdx] ?? ''));
                        $name  = trim((string)($row[$nIdx] ?? ''));
                        $bcode = trim((string)($row[$bIdx] ?? ''));

                        if ($code === '' || $bcode === '' || strtolower($bcode) === 'nan') continue;
                        $rows[] = ['holooCode' => $code, 'holooName' => $name, 'holooCustomerCode' => $bcode];
                    }
                }
                return $rows;
            } catch (\Exception $e) {}
        }

        if (class_exists('ZipArchive')) {
            $zip = new ZipArchive();
            if ($zip->open($filepath) === true) {
                $rows = $this->parse_xlsx_native($zip);
                $zip->close();
                return $rows;
            }
        }
        return false;
    }

    private function parse_xlsx_native($zip) {
        $rows = [];
        $sharedStrings = [];
        $ssContent = $zip->getFromName('xl/sharedStrings.xml');
        if ($ssContent) {
            $ssXml = simplexml_load_string($ssContent);
            if ($ssXml) {
                foreach ($ssXml->si as $si) {
                    $text = '';
                    if (isset($si->t)) $text = (string)$si->t;
                    elseif (isset($si->r)) { foreach ($si->r as $r) { if (isset($r->t)) $text .= (string)$r->t; } }
                    $sharedStrings[] = $text;
                }
            }
        }

        $wbContent = $zip->getFromName('xl/workbook.xml');
        if (!$wbContent) return $rows;
        $wb = simplexml_load_string($wbContent);
        if (!$wb) return $rows;

        $sheetIdx = 1;
        foreach ($wb->sheets->sheet as $sheet) {
            $sheetName = (string)$sheet['name'];
            if (!$this->is_ghoghnoos_sheet($sheetName)) { $sheetIdx++; continue; }

            $sheetFile    = "xl/worksheets/sheet{$sheetIdx}.xml";
            $sheetContent = $zip->getFromName($sheetFile);
            if (!$sheetContent) { $sheetIdx++; continue; }

            $sheetXml = simplexml_load_string($sheetContent);
            if (!$sheetXml) { $sheetIdx++; continue; }

            $sheetData = [];
            foreach ($sheetXml->sheetData->row as $row) {
                $rowData = [];
                foreach ($row->c as $cell) {
                    $t = (string)($cell['t'] ?? '');
                    $v = isset($cell->v) ? (string)$cell->v : '';
                    if ($t === 's') $v = $sharedStrings[(int)$v] ?? '';
                    $rowData[] = $v;
                }
                $sheetData[] = $rowData;
            }

            if (count($sheetData) < 2) { $sheetIdx++; continue; }

            $headers = array_map('trim', $sheetData[0]);
            $cIdx = array_search('holooCode', $headers);
            $nIdx = array_search('holooName', $headers);
            $bIdx = array_search('holooCustomerCode', $headers);

            if ($cIdx === false || $nIdx === false || $bIdx === false) { $sheetIdx++; continue; }

            for ($i = 1; $i < count($sheetData); $i++) {
                $row   = $sheetData[$i];
                $code  = trim((string)($row[$cIdx] ?? ''));
                $name  = trim((string)($row[$nIdx] ?? ''));
                $bcode = trim((string)($row[$bIdx] ?? ''));

                if ($code === '' || $bcode === '' || strtolower($bcode) === 'nan') continue;
                $rows[] = ['holooCode' => $code, 'holooName' => $name, 'holooCustomerCode' => $bcode];
            }
            $sheetIdx++;
        }
        return $rows;
    }

    // ===================================================
    // رندر پنل موبایل وردپرس
    // ===================================================
    public function render_panel() {
        $output = wcbpm_get_css();
        if (!is_user_logged_in()) { return $output . '<div class="wcbpm-container"><div class="wcbpm-login-msg"><p style="font-size:48px;margin:0">🔐</p><h3>ابتدا وارد شوید</h3><p>برای افزودن محصول باید وارد حساب کاربری شوید</p><a href="' . wp_login_url(get_permalink()) . '" class="wcbpm-login-btn">ورود به حساب</a></div></div>' . wcbpm_get_js(); }
        if (!current_user_can('publish_products')) { return $output . '<div class="wcbpm-container"><div class="wcbpm-login-msg"><p style="font-size:48px;margin:0">🚫</p><h3>دسترسی ندارید!</h3></div></div>'; }

        // فقط نمایش دسته‌بندی‌های مجاز در پنل هم ایده خوبیه، اما اینجا کلشو میاریم
        $categories = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => 0]);
        $output .= '
        <div class="wcbpm-container">
            <div class="wcbpm-header"><h2>➕ افزودن محصول</h2><span>👤 ' . esc_html(wp_get_current_user()->display_name) . '</span></div>
            <div class="wcbpm-alert" id="wcbpm-alert"></div>
            <form id="wcbpm-form">
                <div class="wcbpm-field">
                    <label>📷 عکس محصول</label>
                    <div class="wcbpm-image-upload"><div id="wcbpm-placeholder" class="wcbpm-image-placeholder"><span>📸</span><p>کلیک کنید یا عکس بگیرید</p></div><img id="wcbpm-preview" src="" alt=""><input type="file" id="wcbpm-image-input" accept="image/*" capture="environment"><input type="hidden" id="wcbpm-image-id"></div>
                    <div class="wcbpm-upload-status" id="wcbpm-upload-status"></div>
                </div>
                <div class="wcbpm-field"><label for="product-title">📝 عنوان محصول *</label><input type="text" id="product-title" placeholder="مثال: کفش اسپرت مردانه" required></div>
                <div class="wcbpm-field">
                    <label>💰 قیمت (تومان)</label>
                    <div class="wcbpm-price-row"><div class="wcbpm-price-input"><label for="product-price">قیمت اصلی</label><input type="number" id="product-price" placeholder="0" min="0"></div><div class="wcbpm-price-input"><label for="product-sale-price">قیمت تخفیف</label><input type="number" id="product-sale-price" placeholder="اختیاری" min="0"></div></div>
                </div>
                <div class="wcbpm-field">
                    <label for="product-barcode">🔍 بارکد محصول</label>
                    <input type="text" id="product-barcode" placeholder="بارکد را وارد کنید تا شناسه هلو پیدا شود" inputmode="numeric">
                    <div class="wcbpm-holoocode-result" id="wcbpm-holoocode-result"></div>
                    <input type="hidden" id="product-holoocode">
                </div>
                <div class="wcbpm-field"><label for="product-category">📂 دسته‌بندی</label><select id="product-category"><option value="">انتخاب دسته‌بندی...</option>';
        if (!empty($categories) && !is_wp_error($categories)) { foreach ($categories as $cat) { $output .= '<option value="' . esc_attr($cat->term_id) . '">' . esc_html($cat->name) . '</option>'; } }
        $output .= '</select></div>
                <div class="wcbpm-field"><label for="product-desc">📄 توضیحات</label><textarea id="product-desc" rows="4" placeholder="توضیحات محصول را بنویسید..."></textarea></div>
                <div class="wcbpm-field"><label for="product-stock">📦 موجودی</label><input type="number" id="product-stock" placeholder="تعداد موجودی" min="0"></div>
                <div class="wcbpm-field"><label>📌 وضعیت انتشار</label><div class="wcbpm-status-buttons"><button type="button" class="wcbpm-status-btn active" data-status="publish">✅ منتشر شود</button><button type="button" class="wcbpm-status-btn" data-status="draft">📋 پیش‌نویس</button></div><input type="hidden" id="product-status" value="publish"></div>
                <button type="submit" class="wcbpm-submit-btn" id="wcbpm-submit"><span id="wcbpm-btn-text">🚀 افزودن محصول</span><span id="wcbpm-btn-loader" style="display:none">⏳ در حال ثبت...</span></button>
            </form>
            <div class="wcbpm-recent"><h3>📋 محصولات اخیر</h3><div id="wcbpm-recent-list">' . $this->get_recent_html() . '</div></div>
        </div>';
        return $output . wcbpm_get_js();
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
        if (!current_user_can('publish_products')) wp_send_json_error(['message' => 'دسترسی ندارید!']);
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

        if (empty($holoocode) && !empty($barcode)) {
            $found = $this->lookup_barcode_in_holoodata($barcode);
            if ($found) $holoocode = $found['holooCode'];
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

        $id = $product->save();

        if ($id) {
            if (!empty($barcode)) {
                $p = wc_get_product($id);
                $p->set_sku($barcode);
                $p->save();
            }
            if (!empty($holoocode)) update_post_meta($id, $this->get_holoocode_meta_key(), $holoocode);
            
            $msg = 'محصول با موفقیت اضافه شد! 🎉' . (!empty($holoocode) ? ' (شناسه هلو: ' . $holoocode . ')' : '');
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

        if ($text_lower === '/start' || $text_lower === '/add') {
            $session = ['step' => 'title', 'data' => []];
            set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
            $this->bale_send($chat_id, "🛍 افزودن محصول جدید\n\n📝 مرحله ۱ از ۷\nعنوان محصول را بنویسید:\n\nبرای لغو /cancel بزنید");
            return;
        }

        if ($text_lower === '/scan' || $text_lower === 'اسکن') {
            $session = ['step' => 'scan_only', 'data' => []];
            set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
            $this->bale_send($chat_id, "🔎 جستجوی کالا و شناسه هلو\n\nلطفاً بارکد را اسکن کنید:\nبرای خروج /cancel بزنید");
            return;
        }

        if ($text_lower === '/cancel') {
            delete_transient('wcbpm_bale_' . $chat_id);
            $this->bale_send($chat_id, '❌ عملیات لغو شد.');
            return;
        }

        if ($text_lower === '/list') { $this->bale_send_recent($chat_id); return; }
        if ($session['step'] === 'idle' || $text_lower === '/help') {
            $this->bale_send($chat_id, "👋 سلام!\n\nدستورات:\n➕ /add - افزودن محصول\n🔎 /scan - جستجوی بارکد در اکسل\n📋 /list - محصولات اخیر\n❌ /cancel - لغو عملیات");
            return;
        }

        // 🔙 دکمه بازگشت (ویرایش)
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
            case 'scan_only':
                if ($text === '0' || empty(trim($text))) { $this->bale_send($chat_id, "❌ بارکد نامعتبر است."); return; }
                $found = $this->lookup_barcode_in_holoodata(trim($text));
                if ($found) {
                    $this->bale_send($chat_id, "✅ محصول در فایل اکسل پیدا شد!\n\n📦 نام: {$found['holooName']}\n🔖 شناسه هلو: {$found['holooCode']}\n\nبرای اسکن بعدی، بارکد جدید بفرستید.\nبرای خروج /cancel بزنید.");
                } else {
                    $this->bale_send($chat_id, "❌ بارکد در فایل اکسل ققنوس یافت نشد!\nدوباره اسکن کنید یا /cancel بزنید.");
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
                $this->bale_send($chat_id, "✅ موجودی ثبت شد!\n\n🏷 مرحله ۶ از ۷\nبارکد محصول را اسکن کنید:\n(شناسه هلو به صورت خودکار از اکسل خوانده می‌شود)\n(0 = رد کردن)\n\n/back 🔙 ویرایش مرحله قبل");
                break;

            case 'barcode':
                if ($text !== '0' && !empty(trim($text))) {
                    $barcode = trim($text);
                    $data['barcode'] = $barcode;
                    $found = $this->lookup_barcode_in_holoodata($barcode);
                    if ($found) {
                        $data['holoocode'] = $found['holooCode'];
                        $this->bale_send($chat_id, "✅ بارکد ثبت شد!\n🎯 شناسه هلو (از اکسل): {$found['holooCode']}\n📦 نام در هلو: {$found['holooName']}\n\n📸 مرحله ۷ از ۷\nعکس محصول را ارسال کنید (0 = رد):");
                    } else {
                        $data['holoocode'] = '';
                        $this->bale_send($chat_id, "⚠️ بارکد در فایل اکسل پیدا نشد.\nشناسه هلو خالی می‌ماند.\n\n📸 مرحله ۷ از ۷\nعکس محصول را ارسال کنید (0 = رد):");
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

    // ===================================================
    // کیبورد شیشه‌ای با محدودیت دسته‌های مادر
    // ===================================================
    private function bale_send_category_keyboard($chat_id, $parent_id = 0, $page = 1) {
        $per_page = 10; 
        
        if ($parent_id == 0) {
            // فقط دسته‌های مادری که شما مشخص کردید
            $cats = get_terms([
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
                'name'       => $this->allowed_parents
            ]);
        } else {
            // زیرمجموعه‌های دسته انتخاب شده
            $cats = get_terms([
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
                'parent'     => $parent_id
            ]);
        }
        
        if (is_wp_error($cats) || empty($cats)) {
            $this->bale_send($chat_id, "❌ خطایی در خواندن دسته‌ها رخ داد یا دسته‌بندی پیدا نشد."); return;
        }

        $total_cats = count($cats); 
        $total_pages = ceil($total_cats / $per_page);
        if ($page > $total_pages) $page = $total_pages;
        if ($page < 1) $page = 1;

        $offset = ($page - 1) * $per_page;
        $current_cats = array_slice($cats, $offset, $per_page);
        $keyboard = [];
        
        foreach ($current_cats as $cat) {
            $keyboard[] = [['text' => '📁 ' . $cat->name, 'callback_data' => 'sel_' . $cat->term_id]];
        }

        $nav_row = [];
        if ($page > 1) $nav_row[] = ['text' => '🔼 قبلی', 'callback_data' => 'nav_' . $parent_id . '_' . ($page - 1)];
        if ($page < $total_pages) $nav_row[] = ['text' => '🔽 بعدی', 'callback_data' => 'nav_' . $parent_id . '_' . ($page + 1)];
        if (!empty($nav_row)) $keyboard[] = $nav_row;

        if ($parent_id == 0) {
            $keyboard[] = [['text' => '🚫 بدون دسته‌بندی', 'callback_data' => 'fsel_0']];
        } else {
            $term = get_term($parent_id, 'product_cat');
            $grandparent = ($term && !is_wp_error($term)) ? $term->parent : 0;
            $keyboard[] = [['text' => '✅ انتخاب همین دسته (' . $term->name . ')', 'callback_data' => 'fsel_' . $parent_id]];
            $keyboard[] = [['text' => '🔙 بازگشت به دسته‌های مادر', 'callback_data' => 'nav_0_1']];
        }

        $token = get_option('wcbpm_bale_token', '');
        if (empty($token)) return;

        $msg = "✅ قیمت (یا عنوان) ثبت شد!\n\n📂 مرحله ۳ از ۷\nیک دسته‌بندی انتخاب کنید (صفحه {$page} از {$total_pages}):\n\n/back 🔙 ویرایش مرحله قبل";
        $payload = json_encode(['chat_id' => $chat_id, 'text' => $msg, 'reply_markup' => ['inline_keyboard' => $keyboard]], JSON_UNESCAPED_UNICODE);
        wp_remote_post("https://tapi.bale.ai/bot{$token}/sendMessage", ['headers' => ['Content-Type' => 'application/json'], 'body' => $payload, 'timeout' => 15]);
    }

    private function bale_process_callback($callback) {
        $chat_id  = $callback['message']['chat']['id'] ?? $callback['from']['id'];
        $data_str = $callback['data'];

        if (strpos($data_str, 'nav_') === 0) {
            $parts = explode('_', $data_str);
            $this->bale_send_category_keyboard($chat_id, intval($parts[1]), intval($parts[2]));
        } elseif (strpos($data_str, 'sel_') === 0) {
            $term_id = intval(str_replace('sel_', '', $data_str));
            $term = get_term($term_id, 'product_cat');
            $parent_id_of_term = ($term && !is_wp_error($term)) ? $term->parent : 0;

            // فقط اگر کاربر روی دسته مادر کلیک کرد، زیرمجموعه ها رو نشون بده
            if ($parent_id_of_term == 0 || in_array(trim($term->name), $this->allowed_parents)) {
                $children = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => $term_id]);
                if (is_wp_error($children) || empty($children)) {
                    $this->finalize_category_selection($chat_id, $term_id); // اگه زیردسته نداشت همینو ثبت کن
                } else {
                    $this->bale_send_category_keyboard($chat_id, $term_id, 1); // زیردسته هاشو بیار
                }
            } else {
                // اگر روی زیردسته اول کلیک کرد -> ثبت نهایی کن (دیگه پایین تر نرو)
                $this->finalize_category_selection($chat_id, $term_id);
            }
        } elseif (strpos($data_str, 'fsel_') === 0) {
            $this->finalize_category_selection($chat_id, intval(str_replace('fsel_', '', $data_str)));
        }

        $token = get_option('wcbpm_bale_token', '');
        if ($token) wp_remote_post("https://tapi.bale.ai/bot{$token}/answerCallbackQuery", ['body' => ['callback_query_id' => $callback['id']], 'timeout' => 10]);
    }

    private function finalize_category_selection($chat_id, $term_id) {
        $session = get_transient('wcbpm_bale_' . $chat_id) ?: ['step' => 'idle', 'data' => []];
        $session['data']['category'] = $term_id;
        $session['step'] = 'description';
        set_transient('wcbpm_bale_' . $chat_id, $session, 3600);
        $cat_name = $term_id > 0 ? get_term($term_id)->name : 'بدون دسته‌بندی';
        $this->bale_send($chat_id, "✅ دسته‌بندی انتخاب شد: {$cat_name}\n\n📄 مرحله ۴ از ۷\nتوضیحات محصول را بنویسید:\n(برای رد کردن عدد 0 بزنید)\n\n/back 🔙 ویرایش مرحله قبل");
    }

    private function bale_create_product($chat_id, $data) {
        $product = new WC_Product_Simple();
        $product->set_name($data['title']);
        $product->set_status('publish');

        if (!empty($data['description'])) $product->set_description($data['description']);
        if (!empty($data['price']) && $data['price'] > 0) $product->set_regular_price($data['price']);
        if (!empty($data['category']) && $data['category'] > 0) $product->set_category_ids([$data['category']]);
        if (!empty($data['image_id'])) $product->set_image_id($data['image_id']);
        if (!empty($data['stock']) && $data['stock'] > 0) { $product->set_manage_stock(true); $product->set_stock_quantity($data['stock']); $product->set_stock_status('instock'); }
        if (!empty($data['barcode'])) {
            $product->set_sku($data['barcode']);
        }

        $id = $product->save();

        if ($id) {
            if (!empty($data['holoocode'])) {
                update_post_meta($id, $this->get_holoocode_meta_key(), $data['holoocode']);
            }
            
            $msg = "🎉 محصول با موفقیت اضافه شد!\n\n📦 {$data['title']}";
            if (!empty($data['holoocode'])) $msg .= "\n🔗 شناسه هلو: {$data['holoocode']}";
            elseif (!empty($data['barcode'])) $msg .= "\n⚠️ بارکد در هلو پیدا نشد، اما به عنوان SKU ثبت شد.";
            $msg .= "\n\nبرای افزودن محصول جدید /add را بزنید";

            $this->bale_send($chat_id, $msg);
        } else {
            $this->bale_send($chat_id, '❌ خطا در ایجاد محصول! دوباره تلاش کنید.');
        }
    }

    private function bale_upload_photo($file_id) {
        $token = get_option('wcbpm_bale_token', '');
        $response = wp_remote_get("https://tapi.bale.ai/bot{$token}/getFile?file_id={$file_id}", ['timeout' => 15]);
        $result = json_decode(wp_remote_retrieve_body($response), true);
        $path = $result['result']['file_path'] ?? null;
        if (!$path) return null;
        require_once ABSPATH . 'wp-admin/includes/image.php'; require_once ABSPATH . 'wp-admin/includes/file.php'; require_once ABSPATH . 'wp-admin/includes/media.php';
        $tmp = download_url("https://tapi.bale.ai/file/bot{$token}/{$path}");
        if (is_wp_error($tmp)) return null;
        $attachment_id = media_handle_sideload(['name' => 'bale-' . time() . '.jpg', 'tmp_name' => $tmp], 0);
        @unlink($tmp);
        return is_wp_error($attachment_id) ? null : $attachment_id;
    }

    private function bale_send_recent($chat_id) {
        $products = wc_get_products(['limit' => 5, 'orderby' => 'date', 'order' => 'DESC']);
        if (empty($products)) { $this->bale_send($chat_id, '📋 هنوز محصولی ثبت نشده!'); return; }
        $text = "📋 آخرین محصولات:\n\n";
        foreach ($products as $p) { $text .= "• " . $p->get_name() . "\n"; }
        $this->bale_send($chat_id, $text);
    }

    public function bale_send($chat_id, $text) {
        $token = get_option('wcbpm_bale_token', '');
        if (empty($token)) return;
        wp_remote_post("https://tapi.bale.ai/bot{$token}/sendMessage", ['headers' => ['Content-Type' => 'application/json'], 'body' => json_encode(['chat_id' => $chat_id, 'text' => $text], JSON_UNESCAPED_UNICODE), 'timeout' => 15]);
    }

    // ===================================================
    // صفحه ادمین
    // ===================================================
    public function add_admin_menu() {
        add_menu_page('محصول آسان', '🛍 محصول آسان', 'manage_options', 'wcbpm-settings', [$this, 'render_settings_page'], 'dashicons-smartphone', 30);
    }

    public function register_settings() {
        register_setting('wcbpm_settings', 'wcbpm_bale_token', 'sanitize_text_field');
        register_setting('wcbpm_settings', 'wcbpm_allowed_chats');
        register_setting('wcbpm_settings', 'wcbpm_holoocode_meta_key', 'sanitize_text_field');
    }

    public function ajax_set_webhook() {
        check_ajax_referer('wcbpm_webhook', 'nonce');
        $token = get_option('wcbpm_bale_token', '');
        if (empty($token)) wp_send_json_error(['message' => 'توکن ربات بله وارد نشده!']);
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