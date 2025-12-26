/**
 * LeCharme - Product Detail Page
 * Minimal JavaScript - Only for quantity selector
 */

function changeQty(delta) {
    const input = document.getElementById('product_detail___qty_input');
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    if (val > 10) val = 10;
    input.value = val;
}
