# SmartAjaxForms
Умные и удобные формы для любого сайта и CMS.

## Подключение и настройка

1. Для подключения необходимо в html-файл необходимой страницы перед закрывающим тегом body поместить следующий код:

~~~html
<script  src="/ajaxform.js"></script>
~~~

2. для формы задать (или добавить) css class ajaxform, пример class="ajaxform" или  class="oldclass ajaxform"
3. из обязательных полей телефон - name=ajaxx_phone
4. добавьте скрытое поле куда система запишет URL с которого заполнили форму: name=url type=hidden с пустым значением.
5. добавьте скрытое поле где будет передавать имя заполненной формы: name=formname type=hidden value="Заказать звонок"
6. добавьте блок с сообщением об успешной отправке, изначально оно должно быть display:none. и должно идти сразу после тега form с классом messageAjaxForm
7. в файле smartajaxformsconfig.php указать CSV_FILENAME, например "leadsfile.csv"


## Из необязательного

1. дополнительные поля добавляем по следующей схеме: name="ajax_{название поля}" и поле его описывающее: name="ajax_name_{название поля}" value="Комментарий"
пример: name="ajax_telegram" и name="ajax_name_telegram" value="Телеграм" 

2. чтобы подключить яндекс капчу скрытую нужно в форме добавить поле 

~~~html
<div id="captcha-container" style="display: none;"></div>
<input type="hidden" name="smartcaptcha_token" id="smartcaptcha_token">
~~~


## Запланировано:

1. вставка формы в любое место простым кодом

~~~html
<script  src="/ajaxform.js?insertform=1&formname=withPhone"></script>
~~~

2. подсказки во время заполнения формы

3. автоматическая проверка правильности установки форм, для этого нужно к урлу добавить ?checksmart=1
