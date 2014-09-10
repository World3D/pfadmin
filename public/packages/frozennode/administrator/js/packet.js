function close_packetdialog() {
	$("#packet_fullbg, #packet_dialog").hide();
}

function get_space_str(number) {
	var str = '';
	for (var i = 0; i < number; ++i) {
		str += '&nbsp;';
	}
	return str;
}

function appendhtml(id, index) {
	var html = '';
	var fourspace = get_space_str(4);
	html += '<div id="packetdata_line' +index+ '">';
	html += fourspace;
	html += " type:&nbsp;&nbsp;"; 
	html += "	<select id='packet_type" +index+ "'> ";
	html += "	<option value='1'>int8</option>";
	html += "	<option value='2'>int16</option>";
	html += "	<option value='3'>int32</option>";
	html += "	<option value='4'>int64</option>";
	html += "	<option value='5'>uint8</option>";
	html += "	<option value='6'>int16</option>";
	html += "	<option value='7'>int32</option>";
	html += "	<option value='8'>int64</option>";
	html += "	<option value='9'>float</option>";
	html += "	<option value='10'>double</option>";
	html += "	<option value='11'>string</option>";
	html += "	</select>";
	html += fourspace;
	html += " name:&nbsp;&nbsp;<input type='text' id='packet_name" +index+ "'>";
	html += fourspace;
	html += " size:&nbsp;&nbsp;<input type='text' id='packet_size" +index+ "' onfocus='check_size(" +index+ ")'>";
	html += '<input type="button" onclick="packet_delete(' +index+ ')" value="移除">';
	html += '</div>';
	$("#" +id).append(html);
}

function get_newindex() {
	var result = 0;
	var jsonindex = $("#packet_jsonindex_max").val();
	for (var i = 0; i < jsonindex; ++i) {
		var index = i;
		var type = parseInt($('#packet_type' +index).val());
		if (isNaN(type)) {
			result = index;
			break;
		}
		if (index + 1 == jsonindex) {
			result = ++index;
		}
	}
	return result;
}

function check_size(index) {
	var typestr = $('#packet_type' +index+ ' option:selected').text();
	if (typestr != 'string') {
		alert('only string can input size');
		$('#packet_name' +index).focus();
		$('#packet_size' +index).val('');
		return;
	}
}

function get_init_html(jsonstr) {
	var html = '';
	var fourspace = get_space_str(4);
    html += '<form id="packet_form">';
    html += '<input type="hidden" value="0" id="packet_jsonindex_max">';
    html += '<div id="packetdatas_div">';
    html += '<div id="packetdata_line0">';
    html += fourspace;
    html += " type:&nbsp;&nbsp;";
    html += '	<select id="packet_type0">';
    html += '	<option value="1">int8</option>';
    html += '	<option value="2">int16</option>';
    html += '	<option value="3">int32</option>';
    html += '	<option value="4">int64</option>';
    html += '	<option value="5">uint8</option>';
    html += '	<option value="6">int16</option>';
    html += '	<option value="7">int32</option>';
    html += '	<option value="8">int64</option>';
    html += '	<option value="9">float</option>';
    html += '	<option value="10">double</option>';
    html += '	<option value="11">string</option>';
    html += '	</select>';
    html += fourspace;
    html += ' name:&nbsp;&nbsp;<input type="text" id="packet_name0" sytle="width: 20">';
    html += fourspace;
    html += ' size:&nbsp;&nbsp;<input type="text" id="packet_size0" onfocus="check_size(0)">'
    html += '<input type="button" onclick="packet_addnew()" value="增加一行">';
    html += '</div>';
    html += '</div>';
    html += '<div sytle="algin: right"><input type="button" onclick="packet_save()" value="保存"></div>';
    html += '</form>';
    return html;
}

function packet_addnew() {
	var jsonindex = $("#packet_jsonindex_max").val();
	$("#packet_jsonindex_max").attr('value', ++jsonindex);
	appendhtml("packetdatas_div", get_newindex());
}

function packet_delete(id) {
	var jsonindex = $("#packet_jsonindex_max").val();
	$("#packet_jsonindex_max").attr('value', --jsonindex);
	$('#packetdata_line' +id).remove();
}

function in_array(needle, haystack) {
	var result = false;
	for (var i = 0; i < haystack.length; ++i) {
		if (haystack[i] == needle) {
			result = true;
			break;
		}
	}
	return result;
}

function packet_save() {
	var formcount = parseInt($("#packet_jsonindex_max").val()) + 1;
	var jsonarray = [];
	var indexarray = [];
	for (var i = 0; i < formcount; ++i) {
		var item = [];
		var index = i;
		if (in_array(index, indexarray)) continue;
		var type = parseInt($('#packet_type' +index).val());
		while (isNaN(type)) {
			++index;
			type = parseInt($('#packet_type' +index).val());
		}
		indexarray.push(index);
		var name = $('#packet_name' +index).val();
		var size = parseInt($('#packet_size' +index).val());
		var typename = $('#packet_type' +index+ ' option:selected').text();
		item.push(type);
		if ('' == name) {
			if (0 == index && 1 == formcount) {
				alert('packet has no data');
				close_packetdialog();
				return;
			}
			$('#packet_name' +index).focus();
			alert('please input a name');
			return;
		}
		item.push(name);
		if ('packet_string' == typename && isNaN(size)) {
			$('#size' +index).focus();
			alert('string must input a size');
			return;
		}
		if (!isNaN(size)) item.push(size);
		jsonarray.push(item);
	}
	var jsonstr = JSON.stringify(jsonarray);
	$('#edit_field_data').attr('value', jsonstr);
	$('#edit_field_data').keydown(); //for knockoutjs updateValue
	close_packetdialog();
}

$(document).ready( function(){
	$('#edit_data').click(function() {
		var jsontext = $('#edit_field_data').val();
		if ('' == jsontext) jsontext = '[]';
	    var json = jQuery.parseJSON(jsontext);
	    $.each(json, function(index, value){
			var length = 0;
			length = value.length;
			var type = $('#packet_type' +index).val();
	    	if (undefined == type) {
	    		var jsonindex = $("#packet_jsonindex_max").val();
	    		$("#packet_jsonindex_max").attr('value', ++jsonindex);
	    		appendhtml('packetdatas_div', index);
			}
	    	$('#packet_type' +index).val(value[0]);
			$('#packet_name' +index).val(value[1]);
			if (length >= 3) $('#packet_size' +index).val(value[2]);
	    });
	    
		var bodyheight = $("body").height(); 
		var bodywidth = $("body").width(); 
		$("#packet_fullbg").css({ 
			height: bodyheight, 
			width: bodywidth, 
			display: "block" 
		}); 
		$("#packet_dialog").show();
	});
	
	var bghtml = '';
	bghtml += '<div id="packet_fullbg"></div>'; 
	bghtml += '<div id="packet_dialog">'; 
	bghtml += '<p class="close"><span style="color: red">packet data edit' +get_space_str(110)+ '</span><a href="#" onclick="close_packetdialog();">关闭</a></p>'; 
	bghtml += '<div id="packetdata_div"></div>';
	bghtml += '</div>';
	$('body').append(bghtml);
	$('#packetdata_div').append(get_init_html(''));
	$("#packet_fullbg, #packet_dialog").hide();
});