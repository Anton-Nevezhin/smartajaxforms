document.addEventListener("DOMContentLoaded", function(event) {
	// в скрытое поле заносим текущий урл чтобы знать откуда заполнена форма
	$('[name=url]').each(function(){
	    eval($(this).val(window.location.href));
	});

	///////////// внимание!!!! для работы нужно:
	/// 1.  у тега <form> добавить класс ajaxform 
	/// 2.  сообщение после отправки - добавить div с классом  messageAjaxForm, оно должно идти сразу после <form>
	/// 3. для работы целей метрики поменять ID 999999999999 на свой
	/// 4. также нужен принимающий файл ajaxform.php 
	/// 5. обязательных полей нет, но, как правило, делаем обязательным поле телефона - обычным required и name="ajaxx_phone"
	/// 6. обязательно в каждую форму нужно добавить name=url hidden с пустым значением.
	/// 7. дополнительыне поля создаются следующим образом: само поле для заполнения name="ajaxx_*", например  name="ajaxx_vopros" 
	/// и поле которое передаст название этого поля: name="ajaxx_name_vopros" type="hidden" value="Вопрос"
	/// 8. желательно на каждую форму скрытое поле name=formname value="заказать звонок" чтобы передать название заполненной формы.

    document.querySelector(".ajaxform").addEventListene("submit", function(ev) {
    	ev.preventDefault();
    	
    	if( ! validatePhoneAjaxForm(this.find('input[name="ajaxx_phone"]').val())) { return false; }
		let dataSubmit = this.serialize()
		const thisForm = this;
		thisForm.hide(1000);
	    thisForm.next(".messageAjaxForm").show(2000);
	    
		$.ajax({
		    url: '/ajaxform.php',
		    method: 'post',
		    dataType: 'html',
		    data: dataSubmit,
		    success: function(dataSubmit){
			  //  console.log(dataSubmit);
			    ym(999999999999,'reachGoal','formcompleted');
			    console.log('Достижение цели: Успешно отправленная форма.');
			    

			}
        });
    })
    
    // цель в метрику по открытию модального окна (обычно оно с формой)
    document.querySelector("[data-bs-toggle=modal]").addEventListener("click", function() {
        ym(102613859,'reachGoal','openmodal');
        console.log('Достижение цели: Открыл модальное окно');
    });
    
    // проверка телефона
    
     function validatePhoneAjaxForm(phoneInput) {
        if(phoneInput.length < 7) { alert('Слишком короткий номер телефона. Перепроверьте. '); return false;}
        let digitsPhone = phoneInput.replace(/\D/g, "");
        if(digitsPhone.length < 7) { alert('Слишком короткий номер телефона. Проверьте цифры.  '); return false;}
        if(digitsPhone.length > 14) { alert('Слишком длинный номер телефона. Проверьте цифры.  '); return false;}
        else  { return true;}
        
    }
    
})