$("#file1").filestyle({ text: "Select one file", btnClass: "btn-danger" });
$("#file2").filestyle({ text: "Select multiple files", btnClass: "btn-danger" });

var options = {
    success: responseFileUpload,
    dataType: 'json'
};

$('#form1').ajaxForm(options);

$('#form2').ajaxForm(options);

function responseFileUpload(data, statusText, xhr, $form) {
    alert(data.mess);
}