let editor;
let defaultCodeCpp = '#include <iostream>\nusing namespace std;\n int main(){\n\n}';
let defaultCodeC = '#include <stdio.h>\n int main(){\n\n}';
let defailtCodePy = 'print("hi")';
window.onload = function() {
    editor = ace.edit("editor");
    editor.setTheme("ace/theme/merbivore");
    editor.session.setMode("ace/mode/c_cpp");
    editor.setOptions(
        {   
            fontSize: '12pt',
            enableBasicAutocompletion: true,
            enableLiveAutocompletion: true,
        }
    )
    InitialCode();
}
function InitialCode()
{
    var url_string = window.location.href;
    var url = new URL(url_string);
    var _fileName = url.searchParams.get("name");
    var _language = url.searchParams.get("lang");
    if(_language == 'py')
    {
        editor.session.setMode("ace/mode/python");
    }
    if(_fileName)
    {
        if(_language)
        {
            $.ajax({
                url: "http://192.168.1.10:1205/xampp/PBL4_Quang/app/server.php",
                method: "GET",
                data: {
                    fileName: _fileName,
                    language: _language,
                },
                success: function (response)
                {
                    response = $.parseJSON(response);
                    const tx = document.querySelector(".input");
                    tx.classList.add("mode-on");
                    $("#inputCode").val(response.input);
                    editor.getSession().setValue(response.code);
                    $("#outputCode").val(response.output);
                    console.log(response.language);
                    $("#languages").val(_language);
                }
            })
        }
    }
    else editor.setValue(defaultCodeCpp);   
}
function changeLanguage() {

    let language = $("#languages").val();

    if(language == 'cpp')
    {
        editor.session.setMode("ace/mode/c_cpp");
        editor.setValue(defaultCodeCpp);
    }
    else if(language == 'c')
    {
        editor.session.setMode("ace/mode/c_cpp");
        editor.setValue(defaultCodeC);
    }
    else if(language == 'py')
    {
        editor.session.setMode("ace/mode/python");
        editor.setValue(defailtCodePy);
    }
}
function shareCode()
{
    $.ajax({

        url: "http://192.168.1.10:1205/xampp/PBL4_Quang/app/server.php",

        method: "POST",

        data: {
            method: "share",
            language: $("#languages").val(),
            code: editor.getSession().getValue(),
            inputCode: $("#inputCode").val()
        },
     
        success: function(response) {
            response = $.parseJSON(response);
            var fileName = response.fileName;
            var language = response.language;
            var ip = response.IP;
            var url = "http://" + ip + ":1205/xampp/PBL4_Quang/UI/ide.html?name=" + fileName + "&lang=" + language;
            $("#txt_Link").val(url);
            $("#outputCode").val(response.output);
        }
    })
}
function executeCode() {
    $.ajax({

        url: "http://192.168.1.10:1205/xampp/PBL4_Quang/app/server.php",

        method: "POST",

        data: {
            method: "execute",
            language: $("#languages").val(),
            code: editor.getSession().getValue(),
            inputCode: $("#inputCode").val()
        },
     
        success: function(response) {
            response = $.parseJSON(response);
            $("#outputCode").val(response.output);
            console.log(response.output);
        }
    })
}