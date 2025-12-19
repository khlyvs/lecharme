document.addEventListener("DOMContentLoaded", function () {
    const modalElement = document.getElementById("kt_modal_add_customer");
    const closeBtn = document.getElementById("kt_modal_add_customer_close");
    const cancelBtn = document.getElementById("kt_modal_add_customer_cancel");
    const form = modalElement.querySelector("form");

    const modalInstance = new bootstrap.Modal(modalElement);

    // "X" düyməsinə klik
    if (closeBtn) {
        closeBtn.addEventListener("click", function () {
            modalInstance.hide();
        });
    }

    // "Ləğv Et" düyməsinə klik
    if (cancelBtn) {
        cancelBtn.addEventListener("click", function (e) {
            e.preventDefault();
            form.reset(); // Formanı sıfırla
            modalInstance.hide(); // Modalı bağla
        });
    }
});


document.addEventListener("DOMContentLoaded", function () {
    const modalElement = document.getElementById("edit_user_modal");
    const closeBtn = document.getElementById("kt_modal_edit_user_close");
    const cancelBtn = document.getElementById("kt_modal_edit_user_cancel");

    if (!modalElement) return;

    const form = modalElement.querySelector("form");
    const modalInstance = new bootstrap.Modal(modalElement);

    // "X" düyməsinə klik
    if (closeBtn) {
        closeBtn.addEventListener("click", function () {
            modalInstance.hide();
        });
    }

    // "Ləğv Et" düyməsinə klik
    if (cancelBtn) {
        cancelBtn.addEventListener("click", function (e) {
            e.preventDefault();  // default davranışı blokla (məsələn, form reset tipini)
            form.reset();
            modalInstance.hide();
        });
    }

    // Əgər test üçün modalı avtomatik açmaq istəyirsənsə:
    // modalInstance.show();
});


document.addEventListener("DOMContentLoaded", function () {
    const modalElement = document.getElementById("edit_customer_modal");
    const closeBtn = document.getElementById("kt_modal_edit_customer_close");
    const cancelBtn = document.getElementById("kt_modal_edit_customer_cancel");

    if (!modalElement) return;

    const form = modalElement.querySelector("form");
    const modalInstance = new bootstrap.Modal(modalElement);

    // "X" düyməsinə klik
    if (closeBtn) {
        closeBtn.addEventListener("click", function () {
            modalInstance.hide();
        });
    }

    // "Ləğv Et" düyməsinə klik
    if (cancelBtn) {
        cancelBtn.addEventListener("click", function (e) {
            e.preventDefault();
            form.reset(); // Formanı sıfırla
            modalInstance.hide(); // Modalı bağla
        });
    }
});