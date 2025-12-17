document.addEventListener('DOMContentLoaded', function() {
	// в скрытое поле заносим текущий урл чтобы знать откуда заполнена форма
	document.querySelectorAll('[name=url]').forEach(function(field) {
		field.value = window.location.href;
	});

     document.querySelectorAll(".ajaxform").forEach(function(form) {
        form.addEventListener("submit", function(ev) {
            ev.preventDefault();
            
            var phoneInput = this.querySelector('input[name="ajaxx_phone"]');
            if(!validatePhoneAjaxForm(phoneInput.value)) { return false; }
            
            var dataSubmit = new URLSearchParams(new FormData(this)).toString();
            var thisForm = this;
            thisForm.style.display = 'none';
            var messageElement = thisForm.nextElementSibling;
            if(messageElement && messageElement.classList.contains('messageAjaxForm')) {
                messageElement.style.display = 'block';
            }
            
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/ajaxform.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send(dataSubmit);
            
            xhr.onload = function() {
                ym(99999999999999999999999999999999999,'reachGoal','formcompleted');
                console.log('Достижение цели: Успешная отправка формы.');
            };
        });
    });
    
	
	// цель в метрику по открытию модального окна (обычно оно с формой)
	document.querySelectorAll("[data-bs-toggle=modal]").forEach(function(button) {
        button.addEventListener("click", function() {
            ym(103306672,'reachGoal','openmodal');
            console.log('Достижение цели: Открыл модальное окно');
        });
    });
	
	// проверка телефона
	
	 function validatePhoneAjaxForm(phoneInput) {
		if(phoneInput.length < 7) { alert('Слишком короткий номер телефона. Перепроверьте. '); return false;}
		var digitsPhone = phoneInput.replace(/\D/g, "");
		if(digitsPhone.length < 7) { alert('Слишком короткий номер телефона. Проверьте цифры.  '); return false;}
		if(digitsPhone.length > 14) { alert('Слишком длинный номер телефона. Проверьте цифры.  '); return false;}
		else  { return true;}
		
	}
	
});