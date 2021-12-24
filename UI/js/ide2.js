let editor;
let defaultCodeCpp = '#include <iostream>\nusing namespace std;\n int main(){\n\n}';
let defaultCodeC = '#include <stdio.h>\n int main(){\n\n}';
let defailtCodePy = 'print("hi")';
var url_string = window.location.href;
var url = new URL(url_string);
var id = url.searchParams.get("id");
var username = url.searchParams.get("username");
window.onload = function() {
    const contentcase = document.querySelector(".con-case1");
    const colorcases = document.querySelectorAll(".frame-test");
    const colorcase1 =  document.querySelector(".case1");
    contentcase.classList.add("NoneCase");
    contentcase.classList.remove("BlockCase");
    for(const colorcase of colorcases)
    {
        colorcase.classList.add("oldcolor");
    }
    colorcase1.classList.add("newcolor");
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
    editor.setValue(defaultCodeCpp);
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
function executeCode() {

    $.ajax({

        url: "http://localhost/xampp/PBL4_Quang/app/C_Judge.php",

        method: "POST",

        data: {
            id: id,
            username: username,
            language: $("#languages").val(),
            code: editor.getSession().getValue(),
        },
     
        success: function(response) {
            response = $.parseJSON(response);
            console.log(response.output);
            console.log(response.result);
            for(var i = 1; i < response.size + 1; i++)
            {
                var NameCase = ".case" + i;
                const contentcase = document.querySelector(NameCase);
                contentcase.classList.remove("falsecase");
            }
            if(response.result == "Compiler Error")
            {
                alert("Compiler Error");
            }
            else if(response.index != -1)
            {
                var NameCase = ".case" + response.index;
                const contentcase = document.querySelector(NameCase);
                contentcase.classList.add("falsecase");
            }
            else
            {
                window.location="./C_Problem.php?username=" + username; 
            }
        }
       
    })
}