//Проверка на пустые значения
(function($){
	$.empty = function(mixed_var) { 		   
	    	    return ( mixed_var === ''  || mixed_var === '0' || mixed_var === null  
	    	    	    || mixed_var === false || mixed_var === -1 || mixed_var === undefined );	   	
	}
})(jQuery);

(function($){	
	$.emptyExt = function(mixed_var, conditions) {
		var cond = $.extend({ 
			                 _cond1: '', 
			                 _cond2: '0', 
			                 _cond3: null,
			                 _cond4: false, 
			                 _cond5: -1, 
			                 _cond6: undefined 
		                     }, conditions || {});
	    for (var p in cond) {
	    	if(mixed_var === cond[p]) {
                 return true;	    		
	    	}  
	    }    
	    return false;
	}
})(jQuery);
///////////////////////////////

(function($){
	$.requiredFields = function(requiredNames, requiredTitles, conditions) { 
		var errorsText = "Не заполнены поля:\n";
		var errorsList = '';
		var requiredLength = 0;
		if (requiredNames != undefined && requiredTitles != undefined) {
            requiredLength = requiredNames.length;
        } else {
        	alert('Не указаны поля');
        	return false;
        }
         
		 for (var j = 0; j < requiredLength; j++) {
             var field = $('input[name="' + requiredNames[j] + '"]');
 
             if ($(field).is(':text')) {
            	 $.emptyExt($.trim($(field).val()), conditions) ? errorsList += getError(j) : ''; 
             } else if ($(field).is(':radio')) {
            	 $.emptyExt($('input[name="' + requiredNames[j] + '"]:checked').val(), conditions) ? errorsList += getError(j) : '';            	 
             } else if ($('select[name="' + requiredNames[j] + '"]').val()) {
            	 $.emptyExt($('select[name="' + requiredNames[j] + '"] :selected').val(), conditions) ? errorsList += getError(j) : '';             	 
             }
         }
		 if (errorsList != '') {
			 errorsList = errorsText + errorsList;
		 }
		 return errorsList;
	}
	
	var getError = function (i) {
	        return '- ' + requiredTitles[i] + '\n';
	}
})(jQuery);

//Проверка телефона на 10 цифр
(function($){
	$.fn.testPhone = function() { 
		return this.each( function(){ 
			   $(this).blur( function(){ 
				   var newStr = $(this).val().replace(/[^0-9]/g, '');
				   if (newStr.length != 10 && !$.emptyExt($(this).val())) {
	                    $(this).css('background-color', '#ff6666');
	                    alert('Номер телефона должен состоять из 10 цифр!');
	                    $(this).focus();	                    
	                } else {
	                    $(this).css('background-color', '');
	                }
				   $(this).val(newStr);
				});
			  } 
		);
	}
})(jQuery);

//Проверка по шаблону с заменой
(function($){
	$.fn.testRegReplace = function(conditions) {
		var cond = $.extend({ 
			message: 'Вводите только цифры!', 
			pattern: /[^0-9]/g,
			bgcolor: '#ff6666',
			focus: true
            }, conditions || {});
		
		return this.each( function(){ 
			   $(this).blur( function(){ 
				   if (cond.pattern.test($(this).val()) && !$.emptyExt($(this).val())) {
					    $(this).css('background-color', cond.bgcolor);
					    $(this).val($(this).val().replace(cond.pattern, ''));
			            alert(cond.message);
			            if (cond.focus) {
			            	$(this).focus();
			            }			            
			        } else {
			        	$(this).css('background-color', '');
			        }
				});
			  } 
		);
	}
})(jQuery);

//Проверка по шаблону
(function($){
	$.fn.testReg = function(conditions) {
		var cond = $.extend({ 
			message: 'Вводите только цифры!', 
			pattern: /^[0-9]+$/,
			bgcolor: '#ff6666',
			focus: true
            }, conditions || {});
		
		return this.each( function(){ 
			   $(this).blur( function(){ 
				   if (!cond.pattern.test($(this).val()) && !$.emptyExt($(this).val())) {
					    $(this).css('background-color', cond.bgcolor);
					    alert(cond.message);
					    if (cond.focus) {
			            	$(this).focus();
			            }
			        } else {
			        	$(this).css('background-color', '');
			        }
				});
			  } 
		);
	}
})(jQuery);

//Проверка по шаблону при отправки формы
(function($){
	$.fn.testRegField = function(conditions) {
		var flag = false;
		var cond = $.extend({ 		
			pattern: /^[0-9]+$/
            }, conditions || {});
		
		this.each( function(){ 		   
				   if (!cond.pattern.test($(this).val()) && !$.emptyExt($(this).val())) {
					   flag = true;
			        } else {
			           flag = false;
			        }
			  } 
		);
		return flag;
	}
})(jQuery);

//Предотвращение ввода нежелательных символов(по умолчанию только цифры)
(function($){
	$.fn.keypressFiltr = function(conditions) {
		var flag = false;
		var cond = $.extend({ 		
			pattern: /[0-9]/
            }, conditions || {});
		
		return this.each( function(){ 		   
				  $(this).keypress(function(event) {
					  if (event.which != 8 ) {
					     var char = String.fromCharCode(event.which);
					     if (event.which && !cond.pattern.test(char)) {
						     event.preventDefault();
					     }
					  }
				  });
			  } 
		);
		return flag;
	}
})(jQuery);

