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

function appendhtml(id, typecount) {
	var html = '';
	var fourspace = get_space_str(4);
	html += '<div id="packetdata_line' +typecount+ '">';
	html += fourspace;
	html += " type:&nbsp;&nbsp;"; 
	html += "	<select id='packet_type" +typecount+ "'> ";
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
	html += " name:&nbsp;&nbsp;<input type='text' id='packet_name" +typecount+ "'>";
	html += fourspace;
	html += " size:&nbsp;&nbsp;<input type='text' id='packet_size" +typecount+ "'>";
	html += '<input type="button" onclick="packet_delete(' +typecount+ ')" value="移除">';
	html += '</div>';
	$("#" +id).append(html);
	$("#packet_jsonindex_max").attr('value', typecount); //why add one, index to count
}

function get_init_html(jsonstr) {
	var html = '';
	var fourspace = get_space_str(4);
    html += '<form id="packet_form">';
    html += '<input type="hidden" value="0" id="packet_jsonindex_max">';
    html += '<div id="packetdatas_div">';
    html += '<div>';
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
    html += ' size:&nbsp;&nbsp;<input type="text" id="packet_size0">'
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
	appendhtml("packetdatas_div", jsonindex);
}

function packet_delete(id) {
	var jsonindex = $("#packet_jsonindex_max").val();
	$("#packet_jsonindex_max").attr('value', --jsonindex);
	$('#packetdata_line' +id).remove();
}

function packet_save() {
	var formcount = parseInt($("#packet_jsonindex_max").val()) + 1;
	var jsonarray = [];
	for (var i = 0; i < formcount; ++i) {
		var item = [];
		var index = i;
		var type = parseInt($('#packet_type' +index).val());
		while (isNaN(type)) {
			++index;
			type = parseInt($('#packet_type' +index).val());
		}
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