(function ($) {
    "use strict";

    let lastSubmittedColor = null;
    let lastSubmittedImage = null;

    // 1. Chọn ảnh từ Media Uploader
    $(document).on("click", ".efa-upload-image", function (e) {
        e.preventDefault();

        const $btn = $(this);
        const $container = $btn.closest(".form-field, td");
        const $input = $container.find('input[type="hidden"]');
        const $preview = $container.find(".efa-image-preview");

        let frame = wp.media({
            multiple: false,
        });

        frame.on("select", function () {
            const attachment = frame.state().get("selection").first().toJSON();
            const imageId = attachment.id;
            const imageURL = attachment.sizes?.thumbnail?.url || attachment.url;

            $input.val(imageId);
            $preview.html(
                `<img src="${imageURL}" style="max-width:80px;" alt=""/>`
            );

            lastSubmittedImage = {
                id: imageId,
                url: imageURL,
            };
        });

        frame.open();
    });

    // 2. Ghi lại color + image đã chọn khi bắt đầu thêm mới
    $(document).ajaxSend(function (event, xhr, settings) {
        if (!settings.data || !settings.data.includes("action=add-tag")) return;

        const params = new URLSearchParams(settings.data);
        const taxonomy = params.get("taxonomy");
        const color = params.get("term_color");

        if (taxonomy?.startsWith("pa_")) {
            lastSubmittedColor = color || null;
            // lastSubmittedImage giữ nguyên từ media uploader
        }
    });

    // 3. Sau khi thêm term, chèn color/image vào hàng mới
    $(document).ajaxComplete(function (event, xhr, settings) {
        if (!settings.data || !settings.data.includes("action=add-tag")) return;

        const taxonomy = new URLSearchParams(settings.data).get("taxonomy");
        if (!taxonomy?.startsWith("pa_")) return;

        const $newRow = $("table.wp-list-table tbody tr").first();
        if (!$newRow.length || !$newRow.attr("id")?.startsWith("tag-")) return;

        // Thêm cột màu
        if (lastSubmittedColor) {
            const html = `
        <div style="display:flex;align-items:center;gap:6px">
            <div style="width:24px;height:24px;border:1px solid #ccc;background:${lastSubmittedColor};"></div>
            <span style="font-family:monospace;">${lastSubmittedColor}</span>
        </div>
      `;
            insertSwatchCell($newRow, "color", html);
            lastSubmittedColor = null;
        }

        // Thêm ảnh preview
        if (lastSubmittedImage?.url) {
            const html = `<img src="${lastSubmittedImage.url}" style="width:50px;height:auto;" alt=""/>`;
            insertSwatchCell($newRow, "image", html);
            lastSubmittedImage = null;
        }
    });

    // 4. Chèn ô mới trước cột "posts"
    function insertSwatchCell($row, type, htmlContent) {
        const colClass = `column-${type}`;
        const $handleCell = $row.find("td.column-posts");

        if ($handleCell.length && !$row.find(`td.${colClass}`).length) {
            $(`<td class="${colClass}"></td>`).insertBefore($handleCell);
        }

        $row.find(`td.${colClass}`).html(htmlContent);
    }

    // 5. Khi xoá term bằng AJAX thì xoá metadata kèm theo
    $(document).ajaxComplete(function (event, xhr, settings) {
        if (!settings.data || !settings.data.includes("action=delete-tag")) return;

        const taxonomy = new URLSearchParams(window.location.search).get("taxonomy");
        if (!taxonomy || !taxonomy.startsWith("pa_")) return;

        const match = settings.data.match(/tag_ID=(\d+)/);
        const termId = match ? parseInt(match[1], 10) : null;
        if (!termId) return;

        $.post(
            ajaxurl,
            {
                action: "efa_delete_term_meta_by_term_id",
                term_id: termId,
                taxonomy: taxonomy,
            },
            function (res) {
                if (res.success) {
                    console.log("Metadata deleted successfully");
                } else {
                    console.warn("Error deleting metadata:", res.data?.msg || "Unknown");
                }
            }
        );
    });
})(jQuery);