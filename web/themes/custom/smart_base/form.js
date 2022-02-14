class Form {
        /**
         * Standard constructor for class
         */
        constructor() {
                /**
                 * Here we find div where should be our form
                 * @type {*|jQuery|HTMLElement}
                 */
                this.form_block = $("#form");

                /**
                 * Here we find input where should be client phone number
                 * @type {*|jQuery|HTMLElement}
                 */
                this.phone = $("#phone");

                /**
                 * Initialize modal window using Modal_window_jquery::class
                 * @type {Modal_window_jquery}
                 */
                this.modal_window = new Modal_window_jquery("history-grid");
                this.modal_window.init();
        }

        /**
         * Using to create new obj of Form::class and if phone input not empty -> init ajax request to get clients form
         */
        static getForm() {
                let form = new Form();
                if (form.phone.val().length > 0) {
                        form.ajaxRequestForm();
                }
        }

        /**
         * Make GET request to get clients form
         */
        ajaxRequestForm() {
                let form = this;
                $.ajax({
                        url: '/smart_base/form/index-ajax',
                        method: 'GET',
                        dataType: 'html',
                        success: function (data) {
                                form.ajaxRequestClientData(data);
                                let active_element = document.activeElement;
                                active_element.blur();
                        },
                        error: function (xhr) {
                                console.log(xhr);
                        }
                });
        }

        /**
         * After receiving clients form we get POST request to get client data
         * @param data {html5types}
         */
        ajaxRequestClientData(data) {
                let form = this;
                form.form_block.html($(data).html());
                $.ajax({
                        url: '/smart_base/form/get-client-data',
                        method: 'POST',
                        data: {
                                number: this.phone.val(),
                        },
                        dataType: 'json',
                        success: function (data) {
                                form.setClientData(data);
                        },
                        error: function (xhr) {
                                console.log(xhr);
                        }
                });
        }

        /**
         * If client data not empty we fill form inputs by client data that we have
         * @param data {Array}
         */
        setClientData(data) {
                let form = this;
                if (data.length > 0) {
                        for (let attribute of data) {
                                let input = form.form_block.find("[name='" + attribute.field + "']");
                                input.val(attribute.value);
                                let history_button = input.parent().parent().find(".show-history");
                                history_button.css("display", "block");
                                history_button.click(function () {
                                        form.modal_window.setTitle("История изменения поля \"" + attribute.field + "\"");
                                        form.loadHistory(attribute.field);
                                        form.modal_window.show();

                                });
                        }
                }
                let block = document.getElementsByClassName('setting_block');
                if (block.length > 0) {
                        let inputs = block[0].getElementsByTagName('input');
                        if (inputs.length > 0) {
                                inputs[0].focus();
                        }
                }
        }

        /**
         * Show all saved field in selected dialogue
         * @param id {String}
         */
        loadDialogueInfo(id) {
                let form = this;
                $.ajax({
                        url: '/smart_base/form/get-dialogue',
                        method: 'POST',
                        data: {
                                number: form.phone.val(),
                                id: id,
                        },
                        dataType: 'html',
                        success: function (data) {
                                let newModal = new Modal_window_jquery('dialogue');
                                newModal.setTitle('История записей диалога');
                                newModal.loadData(data);
                                newModal.show();
                        },
                        error: function (xhr) {
                                console.log(xhr);
                        }
                });
        }

        /**
         * Function for loading field change history
         * @param field {String}
         */
        loadHistory(field) {
                let form = this;
                $.ajax({
                        url: '/smart_base/form/get-history',
                        method: 'POST',
                        data: {
                                number: form.phone.val(),
                                field: field,
                        },
                        dataType: 'html',
                        success: function (data) {
                                form.modal_window.loadData(data);
                                let dialogue_links = form.modal_window.find(".dialogue-history");
                                dialogue_links.each(function () {
                                        $(this).click(function (e) {
                                                e.preventDefault();
                                                console.log($(this).data("dialogue"));
                                                form.loadDialogueInfo($(this).data("dialogue"));
                                        });
                                });
                        },
                        error: function (xhr) {
                                console.log(xhr);
                        }
                });
        }

        /**
         * Saving client data that entered into form
         */
        static saveForm() {
                let form = new Form();
                let all_fields = [];
                let fields = form.form_block.find(".form-control");
                let error_blocks = form.form_block.find(".error");
                if (fields.length > 0) {
                        fields.each(function () {
                                $(this).css("border-color", "#ccc");
                                let item = {
                                        field: $(this).attr('name'),
                                        type: $(this).data('type'),
                                        value: $(this).val(),
                                };
                                all_fields.push(item);
                        });
                }
                if (error_blocks.length > 0) {
                        error_blocks.each(function () {
                                $(this).html("");
                        });
                }
                if (form.phone.val().length > 0) {
                        $.ajax({
                                url: '/smart_base/form/save-client-data',
                                method: 'POST',
                                data: {
                                        number: form.phone.val(),
                                        data: JSON.stringify(all_fields),
                                },
                                dataType: 'json',
                                success: function (data) {
                                        console.log(data.errors);
                                        if (data.errors) {
                                                for (let error of data.errors) {
                                                        let input = form.form_block.find("[name='" + error.field + "']");
                                                        input.css("border-color", "crimson");
                                                        let error_block = input.parent().find(".error");
                                                        error_block.html(error.message);
                                                }
                                        } else {
                                                swal({
                                                            title: "Анкета Сохранена",
                                                            type: "success"
                                                    },
                                                    function () {
                                                            location.reload();
                                                    });
                                        }
                                },
                                error: function (xhr) {
                                        console.log(xhr);
                                }
                        });
                }
        }

        /**
         * Some preparations that need to be done on page
         */
        static start() {
                let form = new Form();
                form.phone.focus();
                $(document).on('keypress', function (e) {
                        if (e.which === 13) {
                                if (form.form_block.html() === '') {
                                        Form.getForm();
                                } else {
                                        Form.saveForm();
                                }
                        }
                });
        }
}

Form.start();
