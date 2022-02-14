/**
 * Class for creating block of settings for smart-base
 */
class SettingsBlock {
        /**
         * Initialise html block for adding new settings
         */
        constructor() {
                this.field_name = $("<div>", {class: "col-sm-3"});
                this.field_name_label = $("<div>", {class: "form-content-label col-sm-4"});
                this.field_name_item = $("<div>", {class: "form-content-item col-sm-8"});
                this.field_type = this.field_name.clone();
                this.field_type_label = this.field_name_label.clone();
                this.field_type_item = this.field_name_item.clone();
                this.field_params = this.field_name.clone();
                this.field_params.removeClass().addClass("col-sm-4");
                this.field_params_label = this.field_name_label.clone();
                this.field_params_item = this.field_name_item.clone();
                this.field_name.append(this.field_name_label).append(this.field_name_item);
                this.field_type.append(this.field_type_label).append(this.field_type_item);
                this.field_params.append(this.field_params_label).append(this.field_params_item);
                this.controls = $("<div>", {class: "col-sm-2"});
                this.controls.append($("<i>", {
                        class: "card-info-btn full danger btn-block glyphicon glyphicon-trash text-danger delete-block"
                }));
                this.block = $("<div>", {class: "setting_block"});
                this.block.append(this.field_name).append(this.field_type).append(this.field_params).append(this.controls);
                this.field_name_label.html("Название поля");
                this.field_name_item.html($("<input>", {type: "text", class: "form-control name", name: "name[]", maxlength: "255", placeholder: "Укажите название поля"}));
                this.field_type_label.html("Тип поля");
                this.field_type_item.html(
                    $("<select>", {type: "text", class: "form-control select", name: "type[]"})
                        .append($("<option>", {value: ""}).html("Укажите тип поля"))
                        .append($("<option>", {value: "input"}).html("Обычный ввод"))
                        .append($("<option>", {value: "dropdown"}).html("Выпадающий список"))
                        .append($("<option>", {value: "only_num"}).html("Только цифры"))
                        .append($("<option>", {value: "only_char"}).html("Только буквы"))
                        .append($("<option>", {value: "tz"}).html("Теудат Зеут"))
                        .append($("<option>", {value: "email"}).html("Ел. почта"))
                );
                this.field_params_label.html("Варианты списка");
                this.add_button = $("<div>", {class: "card-info-btn full primary btn-block add-variant"});
                this.variant_input = $("<input>", {type: "text", class: "form-control", name: "variant[]", maxlength: "255", placeholder: "Укажите вариант"});
                this.add_tr_block = $("<tr>")
                    .append($("<td>", {class: ""})
                        .append($("<div>", {class: "col-sm-8"})
                            .append(this.variant_input))
                        .append($("<div>", {class: "col-sm-4"})
                            .append(this.add_button.html("Добавить"))));

                this.variants = $("<table>", {class: "table table-striped"})
                    .append(this.add_tr_block)
                ;
                this.field_params_item.append(this.variants);
        }

        /**
         * Using for appending new block of inputs
         */
        init() {
                let container = $("#smart-base-settings-container");
                container.append($("<div>", {class: "setting_block  ibox-content"}).append(this.block.html()));
        }

        /**
         * Initialize onClick functions on buttons: add new options for dropdown select and delete buttons
         */
        static initAddVariant() {
                $(".add-variant")
                    .off()
                    .click(function () {
                            let $parent = $(this).parent().parent();
                            let $input = $parent.find("input");
                            $parent.parent().before($("<tr>").append($("<td>", {class: "variant"}).html($input.val()).append($("<i>", {class: "glyphicon glyphicon-trash text-danger delete-block pull-right"}))));
                            $input.val("");
                            SettingsBlock.initDeleteBlock();
                    });
        }

        /**
         * Initialize onClick functions on "delete" buttons
         */
        static initDeleteBlock() {
                $(".delete-block")
                    .off()
                    .click(function () {
                            let $block = $(this).parent().parent();
                            $block.remove();
                    });
        }
}

/**
 * Class for all main functions used on page
 */
class PageBuilder {
        /**
         * Function for adding new clear block of setting inputs
         */
        static addNewBlock() {
                let block = new SettingsBlock();
                block.init();
                SettingsBlock.initAddVariant();
                SettingsBlock.initDeleteBlock();
        }

        /**
         * Main function for initialize all onClick functions after page loading
         */
        static initPage() {
                SettingsBlock.initAddVariant();
                SettingsBlock.initDeleteBlock();
        }

        /**
         * Function for fetching all input data. Forming array of smart-base setting and send them through AJAX
         */
        static saveSettings() {
                let blocks = $("div.setting_block");
                let all_settings = [];
                blocks.each(function () {
                        let variants = $(this).find("td.variant");
                        let var_arr = [];
                        if (variants.length > 0) {
                                variants.each(function () {
                                        if ($.trim(this.innerText) !== '') {
                                                var_arr.push($.trim(this.innerText));
                                        }
                                });
                        }
                        let settings = {
                                name: $.trim($(this).find("input.name").val()),
                                type: $.trim($(this).find("select.select").val()),
                                items: var_arr,
                        };
                        if (settings.name.length > 0 && settings.type.length > 0) {
                                all_settings.push(settings);
                        }
                });
                $.ajax({
                        url: '/smart_base/settings/save-settings',
                        method: 'POST',
                        data: {
                                data: JSON.stringify(all_settings),
                        },
                        dataType: 'json',
                        success: function (data) {
                                swal({
                                        title: "Настройки базы сохранены",
                                        type: "success"
                                });
                        },
                        error: function (xhr) {
                                console.log(xhr);
                        }
                });
        }
}

PageBuilder.initPage();
