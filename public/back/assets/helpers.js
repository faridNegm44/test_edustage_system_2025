// start show الارقام العشريه
function display_number_js(value) {
    let str = value.toString();

    if (str.includes(".")) {
        // إذا كان كل ما بعد الفاصلة أصفار فقط
        if (/\.0+$/.test(str)) {
            return parseInt(str, 10);
        }
        // حذف الأصفار الزائدة فقط بعد الفاصلة
        return str.replace(/0+$/, "").replace(/\.$/, "");
    }

    return str;
}

// end show الارقام العشريه
