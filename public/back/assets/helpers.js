// start show الارقام العشريه
//function display_number_js(value) {
//    let str = value.toString();

//    if (str.includes(".")) {
//        // إذا كان كل ما بعد الفاصلة أصفار فقط
//        if (/\.0+$/.test(str)) {
//            return parseInt(str, 10);
//        }
//        // حذف الأصفار الزائدة فقط بعد الفاصلة
//        return str.replace(/0+$/, "").replace(/\.$/, "");
//    }

//    return str;
//}


function display_number_js(value) {
    // التأكد من أن القيمة رقم
    if (isNaN(value)) {
        return value;
    }

    // تحويل إلى float للتعامل مع الأرقام بدقة
    let number = parseFloat(value);
    let numberStr = number.toString();

    if (numberStr.includes(".")) {
        // فصل الرقم إلى جزئين: صحيح وعشري
        let parts = numberStr.split(".");
        let integerPart = parts[0];
        let decimalPart = parts[1].substring(0, 2); // أخذ أول منزلتين عشريتين

        // إزالة الأصفار الزائدة من اليمين في الجزء العشري
        decimalPart = decimalPart.replace(/0+$/, "");

        // تجميع الرقم مع التأكد من وجود جزء عشري فقط إذا لم يكن فارغ
        let finalNumber = decimalPart
            ? `${integerPart}.${decimalPart}`
            : integerPart;

        // إضافة فواصل للألوف
        return Number(finalNumber).toLocaleString("en-US");
    }

    // رقم صحيح، نضيف فواصل الألوف فقط
    return Number(number).toLocaleString("en-US");
}


// end show الارقام العشريه
