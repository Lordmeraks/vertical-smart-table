/**
 * Класс для создания модальных окон.
 * при обращении к нему, можно сразу указать id для модального окна
 * Пример:
 * modal = new Modal_window_jquery("ваш id")
 * modal.init();
 * modal.setTitle('Some Modal Title');
 * modal.load(HTML - some HTML code);
 * modal.setModalWidth("600px");
 * modal.find("#my_id").on('click', function (e) {
                //do something;
            });
 * modal.show();
 * modal.hide();
 */
class Modal_window_jquery {
        constructor(id = 'InstallModal') {
                this.inmodal = $("<div>", {class: "modal inmodal", id: id, tabindex: "-1", role: "dialog", "aria-hidden": "true", style: "display: none;"});
                this.dialog = $("<div>", {class: "modal-dialog", style: "width: 850px"});
                this.btnClose = $("<button>", {class: "close", type: "button", "data-dismiss": "modal"});
                this.modalTitle = $("<h5>", {class: "modal-title"});
                this.modalBody = $("<div>", {class: "modal-body"});
                this.modalContent = $("<div>", {class: "modal-content animated fadeIn"})
                    .append($("<div>", {class: "modal-header"})
                        .append(this.btnClose
                            .append($("<span>", {"aria-hidden": "true"}).text('×'))
                            .append($("<span>", {class: "sr-only"}).text('Close'))
                        )
                        .append(this.modalTitle.text('Назначить время прихода техника')
                        ))
                    .append(this.modalBody);
                this.modalJ = this.inmodal.append(this.dialog.append(this.modalContent));
        }

        /**
         * дает возможность вернуть объект класса.. [not tested]
         * @returns {Modal_window_jquery}
         */
        static create () {
                return this;
        }

        /**
         * Загружает HTML код внутрь контентной области модального окна.
         * @param data
         */
        loadData (data) {
                this.modalBody.html(data);
        }

        /**
         * Позволяет по указанному селектору (прим.: #my_id, .my_class, tag) найти элемент внутри модального окна и работать дальше с ним в обертке JQuery
         * @param selector
         * @returns {*}
         */
        find (selector) {
                return this.modalBody.find(selector);
        }

        /**
         * Позволяет задать текст названия модального окна
         * @param text
         */
        setTitle (text) {
                this.modalTitle.text(text);
        }

        /**
         * Позволяет задать ширину модального окна
         * @param width
         */
        setModalWidth (width = "850px") {
                this.dialog.css({"width": width});
        }

        /**
         * Инициализация модального окна. Присоединение всей HTML конструкции в конец <body> документа.
         */
        init () {
                $("body").append(this.modalJ);
        }

        /**
         * Отображает модальное окно
         */
        show () {
                this.modalJ.modal();
        }

        /**
         * Скрывает модальное окно
         */
        hide () {
                this.inmodal.modal("hide");
        }
}