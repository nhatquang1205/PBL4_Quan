let editor;
let defaultCodeCpp = '#include <iostream>\nusing namespace std;\n int main(){\n\n}';
let defaultCodeC = '#include <stdio.h>\n int main(){\n\n}';
let defailtCodePy = 'print("hi")';
window.onload = function() {
    editor = ace.edit("editor");
    editor.setTheme("ace/theme/clouds");
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
                url: "http://localhost/xampp/PBL4_Quang/App/C_Execute.php",
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

        url: "http://localhost/xampp/PBL4_Quang/App/C_Execute.php",

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
            var url = "http://localhost/xampp/PBL4_Quang/UI/ide.html?name=" + fileName + "&lang=" + language;
            $("#txt_Link").val(url);
            $("#outputCode").val(response.output);
        }
    })
}
function executeCode() {
    $.ajax({

        url: "http://localhost/xampp/PBL4_Quang/App/C_Execute.php",

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
            console.log(response);
        }
    })
}
function register()
{
    var username = $("#username").val();
    var password = $("#password").val();
    var check = $("#check").val();
    console.log(password);
    console.log(check);
    $.ajax({

        beforeSend: function(){
            if(username == "")
            {
                alert("Vui lòng nhập tên đăng nhập");
                return false;
            }
            else if(password == "")
            {
                alert("Vui lòng nhập mật khẩu");
                return false;
            }
            else if(password.length < 8 || password.length > 32)
            {
                alert("Mật khẩu có độ dài từ 8 - 32 kí tự");
                return false;
            }
            else if(password.localeCompare(check))
            {
                alert("Mật khẩu chưa trùng khớp");
                return false;
            }
            return true;
          },
        url: "http://localhost/xampp/PBL4_Quang/App/C_Register.php",

        method: "POST",

        data: {
            username: $("#username").val(), 
            password: $("#password").val()
        },
        success: function(response)
        {
            console.log(response);
            if(response) alert("Đăng ký thành công");
            else alert("Đăng ký không thành công");
        }
    })
}
$('#formLogin').submit(function() {
    var username = $("#userLogin").val();
    var password = $("#passLogin").val();
    if(username == "" || password == "")
    {
        alert("Tên đăng nhập hoặc mật khẩu không được để trống");
        return false;
    }
    return true;
});