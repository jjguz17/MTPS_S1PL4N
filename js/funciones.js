
$(document).ready(function(){
	$('#lupa').click(function(e){$("#fbuscar").submit()});
});

function ajax_json(url, mensaje_correcto, mensaje_incorrecto, data2) {
	if(typeof(mensaje_correcto) == "undefined") {
		var men_cor="loadingcircle***La petición se ha completado éxitosamente!";
	}
	else {
		var men_cor=""+mensaje_correcto+"";
	}
	if(typeof(mensaje_incorrecto) == "undefined") {
		var men_inc="loadingcircle***Error en la peticitión! Se perdió la conexión a la red";
	}
	else {
		var men_inc=""+mensaje_incorrecto+"";
	}
	var effect1 = men_cor.split("***")[0];
	var bueno_men = men_cor.split("***")[1];
	var effect2 = men_inc.split("***")[0];
	var malo_men = '<p style="color:red !important;">' + men_inc.split("***")[1] + '</p>';
	$.ajax({
		url: url,
		dataType:"json",
		type: "POST",
		data: data2,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
		success: function(data) {
			var json=data;
			if(Number(json['resultado'])==1) {
				/*if(effect1!=" ")
					alerta_rapida(effect1, bueno_men, 'notice');*/
				val= json;
				return true;
			}
			else {
				if(effect2!=" ")
					alerta_rapida(effect2,malo_men, 'error');
				return false;
			}
		},
		error:function(data) {
			alerta_rapida('loadingcircle', malo_men, 'error');
			return false;
		}
	});			
}

function alerta_rapida(effect, mensaje, tipo)
{
	if(effect=="loadingcircle") {
		var svgshapeLoadingCircle = document.getElementById( 'notification-shape-loading-circle' )
		var notification = new NotificationFx({
			wrapper : svgshapeLoadingCircle,
			message :mensaje,
			layout : 'other',
			effect : effect,
			ttl : 7000,
			type : tipo // notice, warning or error
		});
	}
	else {
		var notification = new NotificationFx({
			message : mensaje,
			layout : 'attached',
			effect : effect, 
			type : tipo // notice, warning or error
		});
	}
	notification.show();
}

function confirmacion(titulo, mensaje, url)
{
	$("#modal .modal-title").html(titulo);
	$("#modal .modal-body").html(mensaje);
	$("#modal .btn-success").attr("onClick","ajax_json('"+url+"');return false;");	
}

function number_format(number, decimals, dec_point, thousands_sep) {
  //  discuss at: http://phpjs.org/functions/number_format/
  // original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: davook
  // improved by: Brett Zamir (http://brett-zamir.me)
  // improved by: Brett Zamir (http://brett-zamir.me)
  // improved by: Theriault
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // bugfixed by: Michael White (http://getsprink.com)
  // bugfixed by: Benjamin Lupton
  // bugfixed by: Allan Jensen (http://www.winternet.no)
  // bugfixed by: Howard Yeend
  // bugfixed by: Diogo Resende
  // bugfixed by: Rival
  // bugfixed by: Brett Zamir (http://brett-zamir.me)
  //  revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
  //  revised by: Luke Smith (http://lucassmith.name)
  //    input by: Kheang Hok Chin (http://www.distantia.ca/)
  //    input by: Jay Klehr
  //    input by: Amir Habibi (http://www.residence-mixte.com/)
  //    input by: Amirouche
  //   example 1: number_format(1234.56);
  //   returns 1: '1,235'
  //   example 2: number_format(1234.56, 2, ',', ' ');
  //   returns 2: '1 234,56'
  //   example 3: number_format(1234.5678, 2, '.', '');
  //   returns 3: '1234.57'
  //   example 4: number_format(67, 2, ',', '.');
  //   returns 4: '67,00'
  //   example 5: number_format(1000);
  //   returns 5: '1,000'
  //   example 6: number_format(67.311, 2);
  //   returns 6: '67.31'
  //   example 7: number_format(1000.55, 1);
  //   returns 7: '1,000.6'
  //   example 8: number_format(67000, 5, ',', '.');
  //   returns 8: '67.000,00000'
  //   example 9: number_format(0.9, 0);
  //   returns 9: '1'
  //  example 10: number_format('1.20', 2);
  //  returns 10: '1.20'
  //  example 11: number_format('1.20', 4);
  //  returns 11: '1.2000'
  //  example 12: number_format('1.2000', 3);
  //  returns 12: '1.200'
  //  example 13: number_format('1 000,50', 2, '.', ' ');
  //  returns 13: '100 050.00'
  //  example 14: number_format(1e-8, 8, '.', '');
  //  returns 14: '0.00000001'

  number = (number + '')
    .replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + (Math.round(n * k) / k)
        .toFixed(prec);
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
    .split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '')
    .length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1)
      .join('0');
  }
  return s.join(dec);
}

(function($) {
$.fn.serializefiles = function() {
    var obj = $(this);
    /* ADD FILE TO PARAM AJAX */
    var formData = new FormData();
    $.each($(obj).find("input[type='file']"), function(i, tag) {
        $.each($(tag)[0].files, function(i, file) {
            formData.append(tag.name, file);
        });
    });
    var params = $(obj).serializeArray();
    $.each(params, function (i, val) {
        formData.append(val.name, val.value);
    });
    return formData;
};
})(jQuery);